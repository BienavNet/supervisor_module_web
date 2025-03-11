<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/supervisor_module_web/config/imports.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/supervisor_module_web/config/session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo constant("BOOTSTRAP_CDN_CSS") ?>
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/supervisor_module_web/public/assets/css/dashboard.css">
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../assets/js/graficas/index.js"></script>
</head>
<body>
 <div class="container-fluid col justify-content-center my-5" style="width: 100%;">
    <div class="row m-3">
        <button class="btn btn-primary" onclick="printPage()">Imprimir</button>
    </div>
    <div id="salonMenosUtilizadoChart"></div>
    <div id="horasMasFrecuentesChart"></div>
    <div id="diasMasAsignadoChart"></div>
    <div id="docenteMasComentariosChart"></div>
 </div>
    <?php echo constant("BOOTSTRAP_CDN_JS") ?>
</body>
</html>


<!-- <script src="<?php $_SERVER['DOCUMENT_ROOT'] ?>/supervisor_module_web/public/assets/js/dashboard.js"></script> -->