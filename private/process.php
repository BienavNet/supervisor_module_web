<?php

use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

include_once($_SERVER['DOCUMENT_ROOT'] . "/supervisor_module_web/config/session.php");
require "{$_SERVER['DOCUMENT_ROOT']}/supervisor_module_web/phpspreadsheet/vendor/autoload.php";

const URLBASE = "http://localhost:5000/api";

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
        $uploadOk = 1;
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
$data_error = [];
$data_success = [];

function isValidDay($day)
{
    // validamos espacios en blanco
    $day = trim($day);

    // validad si tiene numeros
    if (preg_match('/\d/', $day)) {
        return "Error: El día no puede contener números.";
    }
    $normalizedDay = mb_strtolower($day, 'UTF-8');
    $normalizedDay = strtr($normalizedDay, [
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u'
    ]);

    // Lista de días permitidos (sin acentos)
    $validDays = ["lunes", "martes", "miercoles", "jueves", "viernes", "sabado", "domingo"];

    return in_array($normalizedDay, $validDays) ? true : "Error: Día inválido.";
}
function isValidSalon($salon)
{
    //validadmos espacios en blanco
    $salon = trim($salon);

    // validamos que sea número entero
    if (!ctype_digit($salon)) {
        return "Error: El salón debe ser un número entero válido sin letras ni símbolos.";
    }

    // Convertimos a entero
    $salon = intval($salon);

    return ($salon >= 1 && $salon <= 1000) ? true : "Error: El número de salón debe estar entre 1 y 1000.";
}

function isValidCedula($cedula)
{
    $cedula = trim($cedula);

    if (!preg_match('/^\d{8,10}$/', $cedula)) {
        return "Error: La cédula debe contener entre 8 y 10 dígitos numéricos.";
    }
    return true;
}

function isValidDateRange($fecha_inicio, $fecha_fin)
{
    $fecha_inicio = trim($fecha_inicio);
    $fecha_fin = trim($fecha_fin);

    // Validar formato correcto con regex (MM/DD/YYYY)
    if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $fecha_inicio) || !preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $fecha_fin)) {
        return "Error: Formato de fecha inválido. Usa MM/DD/YYYY.";
    }

    // Separar mes, día y año (porque está en formato MM/DD/YYYY)
    list($mesInicio, $diaInicio, $anioInicio) = explode('/', $fecha_inicio);
    list($mesFin, $diaFin, $anioFin) = explode('/', $fecha_fin);

    // Verificar si las fechas son válidas
    if (!checkdate($mesInicio, $diaInicio, $anioInicio) || !checkdate($mesFin, $diaFin, $anioFin)) {
        return "Error: Fecha inválida.";
    }

    // Convertir a objetos DateTime
    $inicio = DateTime::createFromFormat('m/d/Y', $fecha_inicio);
    $fin = DateTime::createFromFormat('m/d/Y', $fecha_fin);

    if (!$inicio || !$fin) {
        return "Error: Error al procesar las fechas.";
    }

    // Comparar fechas
    if ($inicio > $fin) {
        return "Error: La fecha de inicio debe ser anterior a la fecha de fin.";
    }

    return true;
}
function isValidHour($hora)
{
    if (!preg_match('/^(?:[01]?\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/', $hora)) {
        return "Error: Formato de hora inválido. Usa HH:MM o HH:MM:SS.";
    }
    return true; 
}
function normalizeHour($hora) {
   
    $partes = explode(":", $hora);
    if (strlen($partes[0]) === 1) {
        $partes[0] = "0" . $partes[0];
    }
    return implode(":", $partes);
}

function isValidTimeRange($hora_inicio, $hora_fin)
{
    $hora_inicio = trim($hora_inicio);
    $hora_fin = trim($hora_fin);
    $hora_inicio = normalizeHour($hora_inicio);
    $hora_fin = normalizeHour($hora_fin);

    if (!preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/', $hora_inicio) ||
        !preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/', $hora_fin)) {
        return "Error: Formato de hora inválido. Usa HH:MM o HH:MM:SS.";
    }

    $inicio = strtotime($hora_inicio);
    $fin = strtotime($hora_fin);

    if (!$inicio || !$fin) {
        return "Error: Error al procesar las horas.";
    }

    if ($inicio >= $fin) {
        return "Error: La hora de inicio debe ser anterior a la hora de fin.";
    }

    return true;
}

function getSalonId($salon)
{
     if (isValidSalon($salon) !== true) return null;

    $response = curlRequest(URLBASE . "/salon/salon/{$salon}", 'GET');
    return $response['httpcode'] == 200 ? $response['response'][0]['salon_id'] : null;
}

function docenteExists($cedula)
{
    if (isValidCedula($cedula) !== true) return null;

    $response = curlRequest(URLBASE . "/docente/cedula/{$cedula}", 'GET');
    if ($response['httpcode'] == 200 && isset($response['response']) && is_array($response['response']) && count($response['response']) > 0) {
        return $response['response'][0]['docente_id'];
    }

    return null;
}

function supervisorExists($cedula)
{
    if (isValidCedula($cedula) !== true) return null;

    $response = curlRequest(URLBASE . "/supervisor/{$cedula}", 'GET');
    if ($response['httpcode'] == 200 && isset($response['response']) && is_array($response['response']) && count($response['response']) > 0) {
        return $response['response'][0]['supervisor_id'];
    }

    return null;
}

switch ($action) {
    case 'registerClasses':
        foreach ($data as $row) {
            if (empty($row[1]) || $row[1] == "null") continue;

            $valid_day = isValidDay($row[3]);
            $valid_salon = isValidSalon($row[6]);
            $valid_cedula_docente = isValidCedula($row[1]);
            $valid_cedula_supervisor = isValidCedula($row[7]);
            $valid_date_range = isValidDateRange($row[8], $row[9]);
            $valid_time_range = isValidTimeRange($row[4], $row[5]);

            if ($valid_day !== true) {
                $data_error[] = [$row, $valid_day];
                continue;
            }
            if ($valid_salon !== true) {
                $data_error[] = [$row, $valid_salon];
                continue;
            }
            if ($valid_cedula_docente !== true) {
                $data_error[] = [$row, $valid_cedula_docente];
                continue;
            }
            if ($valid_cedula_supervisor !== true) {
                $data_error[] = [$row, $valid_cedula_supervisor];
                continue;
            }
            if ($valid_date_range !== true) {
                $data_error[] = [$row, $valid_date_range];
                continue;
            }
            if ($valid_time_range !== true) {
                $data_error[] = [$row, $valid_time_range];
                continue;
            }


            $doc_id = docenteExists($row[1]);

            if ($doc_id === null) {
                $data_error[] = [$row, "Docente no existe. Regístrelo primero."];
                continue;
            }
            $supervisor_id = supervisorExists($row[7]);

            if ($supervisor_id === null) {
                $data_error[] = [$row, "Supervisor no existe. Regístrelo primero."];
                continue;
            }
            $salon_id = getSalonId($row[6]);
            if ($salon_id === null) {
                $data_error[] = [$row, "Salón no existe. Regístrelo primero."];
                continue;
            }


            $horario_id = createSchedule($doc_id, $row[2]);
            if ($horario_id === null) {
                $data_error[] = [$row, "Error al crear el horario."];
                continue;
            }

            $detalle_horario_id = createScheduleDetails($horario_id, $row[3], $row[4], $row[5]);
            if ($detalle_horario_id === null) {
                $data_error[] = [$row, "Error al crear detalles del horario."];
                continue;
            }

            $start_date = date('Y-m-d', strtotime($row[8]));
            $end_date = date('Y-m-d', strtotime($row[9]));

            $registro_exitoso = false;
        do {
            if (createClasses($horario_id, $salon_id, $supervisor_id, $start_date)) {
                $registro_exitoso = true;
            } else {
                $data_error[] = [$row, "Error al crear clases."];
            }
            $start_date = date("Y-m-d", strtotime($start_date . '+ 7 days'));
        } while ($start_date <= $end_date);

        if ($registro_exitoso) {
            $data_success[$row[0]] = [$row, "Clase(s) creada(s) correctamente."];
        }
        }

        echo json_encode([
           'errors' => count($data_error),
            'success' => count($data_success),
            'data' => $data_error,
            'successData' => array_values($data_success)
        ]);
        break;

    case 'registerSupervisor':
        foreach ($data as $row) {
            if (empty($row[1]) || $row[1] == "null") continue;
    
            if (!createSupervisors($row[1], $row[2], $row[3], $row[4], $row[5])) {
                $data_error[] = [$row, "No se pudo crear el supervisor."];
            } else {
                $data_success[$row[1]] = [$row, "Supervisor registrado correctamente."];
            }
        }

        echo json_encode([
            'errors' => count($data_error),
            'success' => count($data_success),
            'data' => $data_error,
            'successData' => array_values($data_success)
        ]);
        break;

    case 'registerDocentes':
        foreach ($data as $row) {
            if (empty($row[1]) || $row[1] == "null") continue;
    
            if (!createDocentes($row[1], $row[2], $row[3], $row[4], $row[5])) {
                $data_error[] = [$row, "No se pudo crear el docente."];
            } else {
                $data_success[$row[1]] = [$row, "Docente registrado correctamente."];
            }
        }
    
        echo json_encode([
            'errors' => count($data_error),
            'success' => count($data_success),
            'data' => $data_error,
            'successData' => array_values($data_success)
        ]);
        break;
}

?>
