<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/supervisor_module/config/imports.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/supervisor_module/config/session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo constant("BOOTSTRAP_CDN_CSS") ?>
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/supervisor_module/public/assets/css/supervisor.css">

    <!-- DataTable Css import-->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <script src="../assets/js/datatables/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/datatables/dataTables.js"></script>
    <script src="../assets/js/datatables/buttons.dataTables.js"></script>
    <script src="../assets/js/datatables/dataTables.buttons.js"></script>
    <script src="../assets/js/datatables/pdfmake.min.js"></script>
    <script src="../assets/js/datatables/buttons.html5.min.js"></script>
    <script src="../assets/js/datatables/buttons.print.min.js"></script>
    <script src="../assets/js/datatables/jszip.min.js"></script>
    <script src="../assets/js/datatables/vfs_fonts.js"></script>


    <title>Docentes</title>
</head>

<body>
    <div class="container-fluid" style="width: 100%;">
        <div class="row m-md-5">
            Este es mi modulo de docentes AQUI PUEDEN IR LAS OPCIONES PARA REGISTRAR, ETC
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">
                Registrar Docentes
            </button>
        </div>
        <div class="row m-md-5">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Cédula</th>
                        <th scope="col">Correo</th>
                    </tr>

                </thead>
                <tbody id="tbody">
                </tbody>
            </table>

        </div>
    </div>


    <div class="modal" id="registerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar docentes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="registerForm">
                        <div class="my-3 mx-4">
                            <label for="name">Nombre: </label>
                            <div class="col-lg-8 my-3">
                                <input type="text" class="form-control border rounded-pill" placeholder="Juan" id="name">
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="lname">Apellido: </label>
                            <div class="col-lg-8 my-3">
                                <input type="text" class="form-control border rounded-pill" placeholder="Perez" id="lname">
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="dni">Cédula: </label>
                            <div class="col-lg-8 my-3">
                                <input type="number" class="form-control border rounded-pill" placeholder="1005059856" id="dni">
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="email">Correo: </label>
                            <div class="col-lg-8 my-3">
                                <input type="email" class="form-control border rounded-pill" placeholder="juanperez@unicesar.edu.co" id="email">
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="password">Contraseña: </label>
                            <div class="col-lg-8 my-3">
                                <input type="password" class="form-control border rounded-pill" placeholder="**********" id="password">
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="cpassword">Confirmar Contraseña: </label>
                            <div class="col-lg-8 my-3">
                                <input type="password" class="form-control border rounded-pill" placeholder="**********" id="cpassword">
                            </div>
                        </div>
                        <div class="mt-4 mx4 row">
                            <div class="d-flex justify-content-end">
                                <input type="submit" class="btn btn-primary" value="Registrar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar docentes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="editForm">
                        <div class="my-3 mx-4">
                            <label for="edit-name">Nombre: </label>
                            <div class="col-lg-8 my-3">
                                <input type="text" class="form-control border rounded-pill" placeholder="Juan" id="edit-name">
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="edit-lname">Apellido: </label>
                            <div class="col-lg-8 my-3">
                                <input type="text" class="form-control border rounded-pill" placeholder="Perez" id="edit-lname">
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="edit-dni">Cédula: </label>
                            <div class="col-lg-8 my-3">
                                <input type="number" class="form-control border rounded-pill" placeholder="1005059856" id="edit-dni">
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="edit-email">Correo: </label>
                            <div class="col-lg-8 my-3">
                                <input type="email" class="form-control border rounded-pill" placeholder="juanperez@unicesar.edu.co" id="edit-email">
                            </div>
                        </div>
                        <div class="mt-4 mx4 row">
                            <div class="d-flex justify-content-end">
                                <input type="submit" class="btn btn-primary" value="Actualizar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php echo constant("BOOTSTRAP_CDN_JS") ?>
    <script src="../assets/js/docente.js"></script>

</body>

</html>