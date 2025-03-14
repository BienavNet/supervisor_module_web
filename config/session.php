<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/supervisor_module_web/config/imports.php");

$URL = "http://localhost:5000/api/login/sesion";
session_start();


if (isset($_GET['logout']) && $_GET['logout'] == 'true'){
    session_destroy();
    unset($_SESSION);
    unset($_COOKIE);
    header('Location: '. constant("PUBLIC_BASE_URL") . '/index');
    exit();
}

if (!empty($_GET['access_token'])){
    $_SESSION['access_token'] = $_GET['access_token'];
}



if (isset($_SESSION['access_token']) && !empty($_SESSION['access_token'])) {
    $access_token = $_SESSION['access_token'];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $URL);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_COOKIE, "access_token=".$access_token."");
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);
    
    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);

    // print_r($response);
    
    if (isset($response['status']) && $response['status'] == "Unauthorized"){
        header('Location: '. constant("PUBLIC_BASE_URL") . '/index');
    }else{
        $_SESSION['access_token'] = $access_token;
        setcookie('access_token', $access_token);
        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] == '/supervisor_module_web/public/index/'){
            header('Location: '. constant("PUBLIC_BASE_URL") . '/dashboard');
        }
    }
} else{
    if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/supervisor_module_web/public/index/')
        header('Location: '. constant("PUBLIC_BASE_URL") . '/index');
    // if (isset($_GET['current_path']))
        
    // else {

    // }
}





