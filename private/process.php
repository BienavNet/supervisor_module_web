<?php

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

include_once($_SERVER['DOCUMENT_ROOT'] . "/supervisor_module_web/config/session.php");
require "{$_SERVER['DOCUMENT_ROOT']}/supervisor_module_web/phpspreadsheet/vendor/autoload.php";

const URLBASE = "https://appsalones-production-106a.up.railway.app/api";

function curlRequest($url, $method, $data = null)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_COOKIE, "access_token=" . $_SESSION['access_token']);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); 
    if ($data != null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = json_decode(curl_exec($ch), true);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return array(
        'response' => $response,
        'httpcode' => $httpcode
    );
}
function cleanCell($cell) {
    return trim(preg_replace('/\s+/', ' ', $cell));
}

function docenteExists($cedula)
{
    $response = curlRequest(URLBASE . "/docente/cedula/{$cedula}", 'GET');
    if ($response['httpcode'] == 200) {
        return $response['response'][0]['docente_id'];
    } else {
        return null;
    }
}

function supervisorExists($cedula)
{
    $response = curlRequest(URLBASE . "/supervisor/{$cedula}", 'GET');
    if ($response['httpcode'] == 200) {
        return $response['response'][0]['supervisor_id'];
    } else {
        return null;
    }
}

function createSchedule($doc_id, $subject)
{
    $response = curlRequest(URLBASE . "/horarios/save", 'POST', array(
        'docente' => $doc_id,
        'asignatura' => $subject
    ));

    if ($response['httpcode'] == 200) {
        return $response['response']['id'];
    } else {
        return null;
    }
}

function createScheduleDetails($horario_id, $dia, $hora_inicio, $hora_fin)
{
    $response = curlRequest(URLBASE . "/horarios/detalles/save", 'POST', array(
        'horario' => $horario_id,
        'dia' => $dia,
        'hora_inicio' => $hora_inicio,
        'hora_fin' => $hora_fin
    ));

    if ($response['httpcode'] == 200) {
        return $response['response']['id'];
    } else {
        return null;
    }
}

function createClasses($horario_id, $salon, $supervisor, $fecha)
{

    $response = curlRequest(URLBASE . "/clase/register", 'POST', array(
        'horario' => $horario_id,
        'salon' => $salon,
        'supervisor' => $supervisor,
        'fecha' => $fecha,
        'estado' => "pendiente"
    ));

    if (isset($response['httpcode']) && $response['httpcode'] == 200) {
        return true;
    } else {
        return false;
    }
}

function createDocentes($nombre, $apellido, $cedula, $correo, $contrasena)
{
    $response = curlRequest(URLBASE . "/docente/save", 'POST', array(
        'nombre' => $nombre,
        'apellido' => $apellido,
        'cedula' => intval($cedula),
        'correo' => $correo,
        'contrasena' => $contrasena
    ));

    if ($response['httpcode'] == 200) {
        return true;
    } else {
        return false;
    }
}

function createSupervisors($nombre, $apellido, $cedula, $correo, $contrasena)
{
    $response = curlRequest(URLBASE . "/supervisor/save", 'POST', array(
        'nombre' => $nombre,
        'apellido' => $apellido,
        'cedula' => intval($cedula),
        'correo' => $correo,
        'contrasena' => $contrasena
    ));

    if ($response['httpcode'] == 200) {
        return true;
    } else {
        return false;
    }
}

function getSalonId($salon)
{
    $response = curlRequest(URLBASE . "/salon/salon/{$salon}", 'GET');
    if ($response['httpcode'] == 200) {
        return $response['response'][0]['salon_id'];
    } else {
        return null;
    }
}

if(!isset($_FILES["fileToUpload"]) || $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_NO_FILE){
    echo json_encode([
        "errors" => 1,
        "data" => [],
        "message" => "No se ha seleccionado ningún archivo"
    ]);
    exit;
}

function loadFile()
{
    $target_dir = "{$_SERVER['DOCUMENT_ROOT']}/supervisor_module_web/private/uploads/";
    $files = scandir($target_dir);
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $fileExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $new_file = $target_dir . "upload." . $fileExt;

    # se limpia el directorio de archivos antiguos 
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            unlink($target_dir . $file);
        }
    }

    $uploadOk = 1;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $new_file)) {
        // return ['status' => 1, 'file' => $new_file];
        
    } else {
        echo json_encode([
            "errors" => 1,
            "data" => [],
            "message" => "Se ha producido un error al cargar el archivo."
        ]);
        $uploadOk = 0;      
    }

    return [
        'status' => $uploadOk,
        'file' => $new_file
    ];
}

$action = $_POST['action'] ?? null;
$file_upload_status = loadFile();

if (!$file_upload_status['status']) {
    echo json_encode([
        "errors" => 1,
        "data" => [],
        "message" => "Error al subir el archivo."
    ]);
    return;
}



$reader = new ReaderXlsx();
$spreadSheet = $reader->load($file_upload_status['file']);
$workSheet = $spreadSheet->getActiveSheet();

$workSheetInfo = $reader->listWorksheetInfo($file_upload_status['file']);

$parsedData = $workSheet->toArray();

$headers = $parsedData[0];
$data = array_slice($parsedData, 1);
$data_error = array();

function isValidDay($day)
{
    $validDays = ["lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
    return in_array(strtolower($day), $validDays);
}

switch ($action) {
    case 'registerClasses':
        // $data_error = []; 
        for ($i = 0; $i < count($data); $i++) {

            if ($data[$i][1] == "null" && $data[$i][1] == null){
                continue;
            }

            $doc_id = docenteExists($data[$i][1]);
            
            if ($doc_id == null) {
                $data_error[] = array($data[$i], "Docente no existe. Por favor, regístrelo primero.");
                continue;
            }
            $supervisor_id = supervisorExists($data[$i][7]);
            
            if ($supervisor_id == null) {
                $data_error[] = array($data[$i], "Supervisor no existe. Por favor, regístrelo primero. ");
                continue;
            }
            
            if (!isValidDay($data[$i][3])) {
                $data_error[] = array($data[$i], "Día no válido. Solo se permiten lunes a sábado.");
                continue;
            }

            $salon_id = getSalonId($data[$i][6]);
            if ($salon_id == null) {
                $data_error[] = array($data[$i], "Salon no existe. Por favor, regístrelo primero.");
                continue;
            }

            $horario_id = createSchedule($doc_id, $data[$i][2]);
            if ($horario_id == null) {
                $data_error[] = array($data[$i], "Horario no existe. Por favor, regístrelo primero.");
                continue;
            }
            $detalle_horario_id = createScheduleDetails($horario_id, $data[$i][3], $data[$i][4], $data[$i][5]);
            if ($detalle_horario_id == null) {
                $data_error[] =array($data[$i], "Detalles no existe. Por favor, regístrelo primero.");
                continue;
            }
            $start_date = date('Y-m-d', strtotime($data[$i][8]));
            $end_date = date('Y-m-d', strtotime($data[$i][9]));

            do {
                $status = createClasses($horario_id, $salon_id, $supervisor_id, $start_date);
                $start_date = date("Y-m-d", strtotime($start_date . '+ 7 days'));
                if (!$status) {
                    $data_error[] = array($data[$i], "Crear Clases Error");
                    continue;
                }
            } while ($start_date <= $end_date);
        }
        echo json_encode([
            'errors' => count($data_error),
            'data' => $data_error
        ]);
        break;

    case 'registerSupervisor':
        $data_error = []; 
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i][1] == "null" && $data[$i][1] == null){
                continue;
            }
            $status = createSupervisors($data[$i][1], $data[$i][2], $data[$i][3], $data[$i][4], $data[$i][5]);
            if (!$status) {
                $data_error[] = array($data[$i], "No se pudo crear el supervisor.");
            }
        }

        echo json_encode([
            'errors' => count($data_error),
            'data' => $data_error
        ]);
        break;

    case 'registerDocentes':
        $data_error = []; 
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i][1] == "null" && $data[$i][1] == null){
                continue;
            }
            $status = createDocentes($data[$i][1], $data[$i][2], $data[$i][3], $data[$i][4], $data[$i][5]);
            if (!$status) {
                $data_error[] = array($data[$i], "No se pudo crear el docente.");
            }
        }

        echo json_encode([
            'errors' => count($data_error),
            'data' => $data_error
        ]);

        break;

    default:
        echo json_encode([
            'errors' => 1,
            'data' => [], 
            'message' => "No se ha seleccionado una acción"
        ]);
        break;
}
