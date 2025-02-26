<?php

use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

include_once($_SERVER['DOCUMENT_ROOT'] . "/supervisor_module/config/session.php");
require "{$_SERVER['DOCUMENT_ROOT']}/supervisor_module/phpspreadsheet/vendor/autoload.php";

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

function createClasses($horario_id, $salon, $supervisor, $fecha){

    $response = curlRequest(URLBASE . "/clase/register", 'POST', array(
        'horario' => $horario_id,
        'salon' => $salon,
        'supervisor' => $supervisor,
        'fecha' => $fecha,
        'estado' => "pendiente"
    ));

    if ($response['httpcode'] == 200) {
        return true;
    } else {
        return false;
    }
}

function getSalonId($salon) {
    $response = curlRequest(URLBASE . "/salon/salon/{$salon}", 'GET');
    if ($response['httpcode'] == 200) {
        return $response['response'][0]['salon_id'];
    } else {
        return null;
    }
}

use PhpOffice\PhpSpreadsheet\Reader\Xls\LoadSpreadsheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

$reader = new ReaderXlsx();
$spreadSheet = $reader->load("{$_SERVER['DOCUMENT_ROOT']}/supervisor_module/example.xlsx");
$workSheet = $spreadSheet->getActiveSheet();

$workSheetInfo = $reader->listWorksheetInfo("{$_SERVER['DOCUMENT_ROOT']}/supervisor_module/example.xlsx");

$parsedData = $workSheet->toArray();

$headers = $parsedData[0];
$data = array_slice($parsedData, 1);
$data_error = array();

for ($i = 0; $i < count($data); $i++) {
    $doc_id = docenteExists($data[$i][1]);
    if ($doc_id == null) {
        $data_error[] = $data[$i];
        continue;
    }
    $supervisor_id = supervisorExists($data[$i][7]);
    if ($supervisor_id == null) {
        $data_error[] = $data[$i];
        continue;
    }
    $salon_id = getSalonId($data[$i][6]);
    if ($salon_id == null) {
        $data_error[] = $data[$i];
        continue;
    }
    $horario_id = createSchedule($doc_id, $data[$i][2]);
    if ($horario_id == null) {
        $data_error[] = $data[$i];
        continue;
    }
    $detalle_horario_id = createScheduleDetails($horario_id, $data[$i][3], $data[$i][4], $data[$i][5]);
    if ($detalle_horario_id == null) {
        $data_error[] = $data[$i];
        continue;
    }
    $start_date = date('Y-m-d', strtotime($data[$i][8]));
    $end_date = date('Y-m-d', strtotime($data[$i][9]));

    do {
        
        $status = createClasses($horario_id, $salon_id, $supervisor_id, $start_date);
        $start_date = date("Y-m-d", strtotime($start_date.'+ 7 days'));
        if (!$status) {
            $data_error[] = $data[$i];
            continue;
        }

    } while ($start_date <= $end_date);

}
print_r($data_error);
echo "\nAccion Terminada";

// print_r($headers);

// print_r(docenteExists("112"));

$timestamp1 = "3/30/2025";
$timestamp2 = "3/30/2025";

echo var_export($timestamp1 < $timestamp2);
// $date_1 = date("m/d/Y", strtotime($timestamp.'+ 7 days'));
// $date_2 = date("m/d/Y", strtotime('4/30/2025'));
// $check = $date_1 <= $date_2;
// echo var_export($check);