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
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/supervisor_module_web/public/assets/css/global.css">
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
    <div class="container-fluid">
        <div style="margin: 1rem 0 0 2rem;">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal" id="registerBtn">
                Registrar Horarios
            </button>
        </div>
        <div class="row m-md-3">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Docente</th>
                        <!-- <th scope="col">Apellido Docente</th>
                        <th scope="col">Cédula</th> -->
                        <th scope="col">Asignatura</th>
                        <th scope="col">Día</th>
                        <th scope="col">Hora: Inicio</th>
                        <th scope="col">Hora: Fin</th>
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
                    <h5 class="modal-title">Registrar Horario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="registerForm">
                        <div class="my-3 mx-4">
                            <label for="docentes-select">Docente: </label>
                            <div class="col-lg-8 my-3">
                                <select  id="docentes-select" class="form-control border rounded-pill">

                                </select>
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="asignatura-select">Asignatura: </label>
                            <div class="col-lg-8 my-3">
                            <select id="asignatura-select" class="form-control border rounded-pill"></select>
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="day-select">Día: </label>
                            <div class="col-lg-8 my-3">
                                <select  id="day-select" class="form-control border rounded-pill">
                                    <option value="Lunes">Lunes</option>
                                    <option value="Martes">Martes</option>
                                    <option value="Miercoles">Miércoles</option>
                                    <option value="Jueves">Jueves</option>
                                    <option value="Viernes">Viernes</option>
                                    <option value="Sabado">Sábado</option>
                                </select>
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="tstart">Hora Inicio: </label>
                            <div class="col-lg-8 my-3">
                                <input type="text" class="form-control border rounded-pill" placeholder="10:00" id="tstart">
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="tend">Hora Fin: </label>
                            <div class="col-lg-8 my-3">
                                <input type="text" class="form-control border rounded-pill" placeholder="14:00" id="tend">
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
                            <label for="edit-docentes-select">Docente: </label>
                            <div class="col-lg-8 my-3">
                                <select  id="edit-docentes-select" class="form-control border rounded-pill">

                                </select>
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                        <label for="edit-subject-select">Asignatura: </label>
                            <div class="col-lg-8 my-3">
                                <select id="edit-subject-select" class="form-control border rounded-pill">

                                </select>
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="edit-day-select">Día: </label>
                            <div class="col-lg-8 my-3">
                                <select  id="edit-day-select" class="form-control border rounded-pill">
                                    <option value="Lunes">Lunes</option>
                                    <option value="Martes">Martes</option>
                                    <option value="Miercoles">Miércoles</option>
                                    <option value="Jueves">Jueves</option>
                                    <option value="Viernes">Viernes</option>
                                    <option value="Sabado">Sábado</option>
                                </select>
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="edit-tstart">Hora Inicio: </label>
                            <div class="col-lg-8 my-3">
                                <input type="text" class="form-control border rounded-pill" placeholder="10:00" id="edit-tstart">
                            </div>
                        </div>
                        <div class="my-3 mx-4">
                            <label for="edit-tend">Hora Fin: </label>
                            <div class="col-lg-8 my-3">
                                <input type="text" class="form-control border rounded-pill" placeholder="14:00" id="edit-tend">
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
    <script src="../assets/js/horario.js"></script>

</body>

</html>