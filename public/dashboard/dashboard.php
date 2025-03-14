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
    <div style="margin: 1rem 0 0 2rem;">
        <button class="btn btn-primary d-print-none" onclick="printPage()">Imprimir</button>
    </div>
    <div id="salonMenosUtilizadoChart"></div>
    <div id="horasMasFrecuentesChart"></div>
    <div id="diasMasAsignadoChart"></div>
    <div id="docenteMasComentariosChart"></div>
 </div>
    <?php echo constant("BOOTSTRAP_CDN_JS") ?>
    <script src="../assets/js/dashboard.js"></script>
</body>
</html>