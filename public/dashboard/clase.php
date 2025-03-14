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
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/supervisor_module_web/public/assets/css/supervisor.css">

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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>

<body>
<div class="container-fluid container-lg-8">
    <div
    class="d-flex justify-content-around"
    style="margin: 1rem 0 0 2rem;">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal" id="registerBtn">
                Registrar Clases
            </button>

            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarAllModal" id="deleteAllBtn">
                Eliminar todo
            </button>
        </div>
        
        <div class="row m-md-3">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                    </tr>

                </thead>
                <tbody id="tbody">
                </tbody>
            </table>

        </div>
    </div>

    <div class="modal" id="eliminarAllModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar todas las clases</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="deleteAllform">
                        <div class="my-3 mx-4">
                            <label>Por favor confirma. Una vez borrado no hay retroceso.</label>
                        </div>
                        <div class="my-3 mx-4">
                            <label >Recuerde que al borrar las clases se eliminaran los reporte realizados a dichas clases. </label>
                        </div>
                        <div class="mt-4 mx4 row">
                            <div class="d-flex justify-content-end">
                                <input type="submit" class="btn btn-danger" value="Vaciar todo">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="registerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Clases</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="registerForm">
                        <div class="my-3 mx-4">
                            <label for="horario-select">Horario: </label>
                            <div class="col-lg-8 my-3">
                                <select id="horario-select" class="form-control border rounded-pill">

                                </select>
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="salon-select">Salon: </label>
                            <div class="col-lg-8 my-3">
                                <select id="salon-select" class="form-control border rounded-pill">
                                </select>
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="supervisor-select">Supervisor: </label>
                            <div class="col-lg-8 my-3">
                                <select id="supervisor-select" class="form-control border rounded-pill">

                                </select>
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="dstart">Fecha Inicio: </label>
                            <div class="col-lg-8 my-3">
                                <input type="date" class="form-control border rounded-pill" id="dstart">
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="dend">Fecha Fin: </label>
                            <div class="col-lg-8 my-3">
                                <input type="date" class="form-control border rounded-pill" id="dend">
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
                    <h5 class="modal-title">Actualizar Clase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="editForm">
                        <div class="my-3 mx-4">
                            <label for="edit-horario-select">Horario: </label>
                            <div class="col-lg-8 my-3">
                                <select id="edit-horario-select" class="form-control border rounded-pill">

                                </select>
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="edit-salon-select">Salon: </label>
                            <div class="col-lg-8 my-3">
                                <select id="edit-salon-select" class="form-control border rounded-pill">

                                </select>
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="edit-supervisor-select">Supervisor: </label>
                            <div class="col-lg-8 my-3">
                                <select id="edit-supervisor-select" class="form-control border rounded-pill">

                                </select>
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="edit-status">Estado: </label>
                            <div class="col-lg-8 my-3">
                                <input type="text" class="form-control border rounded-pill" placeholder="10:00" id="edit-status">
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="edit-date">Nueva Fecha: </label>
                            <div class="col-lg-8 my-3">
                                <input type="date" class="form-control border rounded-pill" placeholder="10:00" id="edit-date">
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
    <script src="../assets/js/clase.js"></script>

</body>

</html>