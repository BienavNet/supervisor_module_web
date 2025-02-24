<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . "/supervisor_module/config/imports.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/supervisor_module/config/session.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/supervisor_module/public/assets/css/index.css">
    <?php echo constant("BOOTSTRAP_CDN_CSS") ?>
    
</head>

<body>
    <div id="principal-container" class="container-fluid min-vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="row border rounded-3 shadow bg-white pl-0" style="
            width: 65%;
        ">
            <div class="col-md-7" style="padding: 0;">
                <div class="img-container h-100">
                    <img src="../assets/img/upc.png" alt="UPC Img Banner Index" class="img-fluid h-100 rounded-3">
                </div>
            </div>

            <div class="col-md-5 d-flex flex-column justify-content-center">
                <div class="container d-flex justify-content-start mt-md-3 pb-md-3 mx-md-4">
                    <span class="title border-bottom">
                        Iniciar Sesión
                    </span>
                </div>

                <form method="post" id="login-form">
                    <div class="my-3 mx-4">
                        <label for="email">CORREO ELECTRÓNICO</label>
                        <div class="col-lg-8 my-3">
                            <input type="email" class="form-control border rounded-pill" placeholder="supervisor@unicesar.edu.co" id="email">
                        </div>
                    </div>
                    <div class="my-3 mx-4">
                        <label for="password">CONTRASEÑA</label>
                        <div class="col-lg-8 my-3">
                            <input type="password" class="form-control border rounded-pill" placeholder="************" id="password">
                        </div>
                    </div>
                    <div class="form-check my-3 mx-4">
                        <input class="form-check-input" type="checkbox" value="" id="showpassword">
                        <label class="form-check-label" for="showpassword">
                            Mostrar Contraseña
                        </label>
                    </div>
                    <div class="d-grid gap-2 col-8 mx-auto py-md-3">
                        <button class="btn border rounded-pill shadow-sm btn-md-lg fs-md-1" id="btn-submit" type="submit">Iniciar Sesión</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    </div>

    <?php echo constant("BOOTSTRAP_CDN_JS") ?>
    <script src="../assets/js/index.js"></script>
</body>

</html>