<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/supervisor_module/config/imports.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/supervisor_module/config/session.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo constant("BOOTSTRAP_CDN_CSS") ?>
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/supervisor_module/public/assets/css/dashboard.css">
    <title>Dashboard</title>
</head>

<body>

    <div class="container-fluid min-vh-100">
        <div class="row">
            <div class="col-4">
                <div class="m-md-5 border rounded shadow px-3" style="height: 40rem !important; width: 20rem !important;">
                    <div class="row">
                        <span class="d-block text-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 640 512" class="m-2"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z" />
                            </svg>
                        </span>
                    </div>
                    <section class="m-3" style="height: 100%;">
                        <div class="row">
                            <h5 class="text-center">
                                Menú Principal
                            </h5>
                        </div>
                        <div class="row d-flex flex-column">
                            <div class="col border rounded py-md-3 px-md-2 my-2">
                                <div class="row">
                                    <div class="col-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="ps-2"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                            <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
                                        </svg>
                                    </div>
                                    <div class="col-9">
                                        Supervisor
                                    </div>
                                </div>
                            </div>
                            <div class="col border rounded py-md-3 px-md-2 my-2">
                                <div class="row">
                                    <div class="col-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="ps-2"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                            <path d="M192 96a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm-8 384l0-128 16 0 0 128c0 17.7 14.3 32 32 32s32-14.3 32-32l0-288 56 0 64 0 16 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-16 0 0-64 192 0 0 192-192 0 0-32-64 0 0 48c0 26.5 21.5 48 48 48l224 0c26.5 0 48-21.5 48-48l0-224c0-26.5-21.5-48-48-48L368 0c-26.5 0-48 21.5-48 48l0 80-76.9 0-65.9 0c-33.7 0-64.9 17.7-82.3 46.6l-58.3 97c-9.1 15.1-4.2 34.8 10.9 43.9s34.8 4.2 43.9-10.9L120 256.9 120 480c0 17.7 14.3 32 32 32s32-14.3 32-32z" />
                                        </svg>
                                    </div>
                                    <div class="col-9">
                                        Docente
                                    </div>
                                </div>
    
                            </div>
                            <div class="col border rounded py-md-3 px-md-2 my-2">
                                <div class="row">
                                    <div class="col-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="ps-2"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                            <path d="M128 0c17.7 0 32 14.3 32 32l0 32 128 0 0-32c0-17.7 14.3-32 32-32s32 14.3 32 32l0 32 48 0c26.5 0 48 21.5 48 48l0 48L0 160l0-48C0 85.5 21.5 64 48 64l48 0 0-32c0-17.7 14.3-32 32-32zM0 192l448 0 0 272c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 192zm64 80l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm128 0l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zM64 400l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zm112 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16z" />
                                        </svg>
                                    </div>
                                    <div class="col-9">
                                        Horario
                                    </div>
                                </div>
                            </div>
                            <div class="col border rounded py-md-3 px-md-2 my-2">
                                <div class="row">
                                    <div class="col-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="ps-2"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                            <path d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z" />
                                        </svg>
                                    </div>
                                    <div class="col-9">
                                        Reportes
                                    </div>
                                </div>
                            </div>
                            <div class="col border rounded py-md-3 px-md-2 my-2">
                                <div class="row">
                                    <div class="col-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="ps-2"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                            <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z" />
                                        </svg>
                                    </div>
                                    <div class="col-9">
                                        Cerrar Sesión
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="row d-flex flex-end"></div>
                </div>
            </div>
            <div class="col-8">
                <iframe src="horario.php" frameborder="0" class="min-vh-100" style="width: 100%;" ></iframe>
            </div>
        </div>



        <?php echo constant("BOOTSTRAP_CDN_JS") ?>
        <script src="../assets/js/dashboard.js"></script>

</body>

</html>