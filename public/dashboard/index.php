<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/supervisor_module_web/config/imports.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/supervisor_module_web/config/session.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo constant("BOOTSTRAP_CDN_CSS") ?>
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/supervisor_module_web/public/assets/css/dashboard.css">
    <script src="../assets/js/dashboard.js"></script>
    <title>Dashboard</title>
</head>

<body>
  <div class="container-fluid min-vh-100 p-0">
    <div class="d-flex flex-direction-type">
      <div class="col border shadow container-none-movil">
        <div class="px-3 w-20" style="height: 40rem !important">
          <section
            class="m-3 media-sm d-flex flex-column align-items-center"
            style="height: 100%"
          >
            <div class="row mp-2">
              <h5 class="text-center text-sm-hidden">UPClass</h5>
            </div>

            <div
              class="container-fluid flex-grow-1 text-center d-md-block d-none"
              style="height: 90%"
            >
              <div class="col" style="height: 100%">
                <div class="align-self-start pt-3" style="height: 90%">
                  <div
                    class="col border rounded py-md-2 px-md-1 my-1 btn-iframe-click active"
                    style="width: 100%"
                    data-src="dashboard.php"
                  >
                    <div class="row">
                      <div class="col-3">
                        <svg
                          viewBox="0 0 15 15"
                          width="30px"
                          height="30px"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            fill="currentColor"
                            d="M7.8254 0.120372C7.63815 -0.0401239 7.36185 -0.0401239 7.1746 0.120372L0 6.27003V13.5C0 14.3284 0.671573 15 1.5 15H5.5C5.77614 15 6 14.7761 6 14.5V11.5C6 10.6716 6.67157 10 7.5 10C8.32843 10 9 10.6716 9 11.5V14.5C9 14.7761 9.22386 15 9.5 15H13.5C14.3284 15 15 14.3284 15 13.5V6.27003L7.8254 0.120372Z"
                            fill="#000000"
                          />
                        </svg>
                      </div>
                      <div class="col-6 text-size16 pt-2">Dashboard</div>
                    </div>
                  </div>

                  <div
                    class="col border rounded py-md-2 px-md-1 my-1 btn-iframe-click"
                    style="width: 100%"
                    data-src="supervisor.php"
                  >
                    <div class="row">
                      <div class="col-3">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 640 512"
                          class="ps-2"
                          width="40px"
                          height="40px"
                        >
                          <path
                            fill="currentColor"
                            d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"
                          />
                        </svg>
                      </div>
                      <div class="col-6 text-size16 pt-2">Supervisor</div>
                    </div>
                  </div>
                  <div
                    class="col border rounded py-md-2 px-md-1 my-1 btn-iframe-click"
                    data-src="docente.php"
                  >
                    <div class="row">
                      <div class="col-3">
                        <svg
                          width="40px"
                          height="40px"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 640 512"
                          class="ps-2"
                        >
                          <path
                            fill="currentColor"
                            d="M192 96a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm-8 384l0-128 16 0 0 128c0 17.7 14.3 32 32 32s32-14.3 32-32l0-288 56 0 64 0 16 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-16 0 0-64 192 0 0 192-192 0 0-32-64 0 0 48c0 26.5 21.5 48 48 48l224 0c26.5 0 48-21.5 48-48l0-224c0-26.5-21.5-48-48-48L368 0c-26.5 0-48 21.5-48 48l0 80-76.9 0-65.9 0c-33.7 0-64.9 17.7-82.3 46.6l-58.3 97c-9.1 15.1-4.2 34.8 10.9 43.9s34.8 4.2 43.9-10.9L120 256.9 120 480c0 17.7 14.3 32 32 32s32-14.3 32-32z"
                          />
                        </svg>
                      </div>
                      <div class="col-6 text-size16 pt-2">Docente</div>
                    </div>
                  </div>
                  <div
                    class="col border rounded py-md-2 px-md-1 my-1 btn-iframe-click"
                    data-src="horario.php"
                  >
                    <div class="row">
                      <div class="col-3">
                        <svg
                          width="40px"
                          height="40px"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 640 512"
                          class="ps-2"
                        >
                          <path
                            fill="currentColor"
                            d="M128 0c17.7 0 32 14.3 32 32l0 32 128 0 0-32c0-17.7 14.3-32 32-32s32 14.3 32 32l0 32 48 0c26.5 0 48 21.5 48 48l0 48L0 160l0-48C0 85.5 21.5 64 48 64l48 0 0-32c0-17.7 14.3-32 32-32zM0 192l448 0 0 272c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 192zm64 80l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm128 0l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zM64 400l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zm112 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16z"
                          />
                        </svg>
                      </div>
                      <div class="col-6 text-size16 pt-2">Horario</div>
                    </div>
                  </div>
                  <div
                    class="col border rounded py-md-2 px-md-1 my-1 btn-iframe-click"
                    data-src="clase.php"
                  >
                    <div class="row">
                      <div class="col-3">
                      <svg  width="40px"
                      height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2.5 4C2.22386 4 2 4.22386 2 4.5C2 4.77614 2.22386 5 2.5 5V4ZM21.5 5C21.7761 5 22 4.77614 22 4.5C22 4.22386 21.7761 4 21.5 4V5ZM4.5 4.5V4H4V4.5H4.5ZM19.5 4.5H20V4H19.5V4.5ZM5.31901 19.3365L5.09202 19.782L5.31901 19.3365ZM4.66349 18.681L4.21799 18.908L4.66349 18.681ZM19.3365 18.681L19.782 18.908L19.3365 18.681ZM18.681 19.3365L18.908 19.782L18.681 19.3365ZM2.5 5H21.5V4H2.5V5ZM4.5 5H19.5V4H4.5V5ZM19 4.5V17.1H20V4.5H19ZM17.1 19H6.9V20H17.1V19ZM5 17.1V4.5H4V17.1H5ZM6.9 19C6.47171 19 6.18056 18.9996 5.95552 18.9812C5.73631 18.9633 5.62421 18.9309 5.54601 18.891L5.09202 19.782C5.33469 19.9057 5.59304 19.9549 5.87409 19.9779C6.1493 20.0004 6.48821 20 6.9 20V19ZM4 17.1C4 17.5118 3.99961 17.8507 4.0221 18.1259C4.04506 18.407 4.09434 18.6653 4.21799 18.908L5.10899 18.454C5.06915 18.3758 5.03669 18.2637 5.01878 18.0445C5.00039 17.8194 5 17.5283 5 17.1H4ZM5.54601 18.891C5.35785 18.7951 5.20487 18.6422 5.10899 18.454L4.21799 18.908C4.40973 19.2843 4.71569 19.5903 5.09202 19.782L5.54601 18.891ZM19 17.1C19 17.5283 18.9996 17.8194 18.9812 18.0445C18.9633 18.2637 18.9309 18.3758 18.891 18.454L19.782 18.908C19.9057 18.6653 19.9549 18.407 19.9779 18.1259C20.0004 17.8507 20 17.5118 20 17.1H19ZM17.1 20C17.5118 20 17.8507 20.0004 18.1259 19.9779C18.407 19.9549 18.6653 19.9057 18.908 19.782L18.454 18.891C18.3758 18.9309 18.2637 18.9633 18.0445 18.9812C17.8194 18.9996 17.5283 19 17.1 19V20ZM18.891 18.454C18.7951 18.6422 18.6422 18.7951 18.454 18.891L18.908 19.782C19.2843 19.5903 19.5903 19.2843 19.782 18.908L18.891 18.454Z" fill="#2A4157" fill-opacity="0.24"/>
<path fill="currentColor" d="M12 15.5V10" stroke="#222222" stroke-linecap="round"/>
<path fill="currentColor" d="M9.5 11.5L11.9063 9.57496C11.9611 9.53114 12.0389 9.53114 12.0937 9.57496L14.5 11.5" stroke="#222222" stroke-linecap="round"/>
</svg>
                      </div>
                      <div class="col-6 text-size16 pt-2">Clases</div>
                    </div>
                  </div>
                  <div
                    class="col border rounded py-md-2 px-md-1 my-1 btn-iframe-click"
                    data-src="loadFile.php"
                  >
                    <div class="row">
                      <div class="col-3">
                        <svg
                          width="40px"
                          height="40px"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 640 512"
                          class="ps-2"
                        >
                          <path
                            fill="currentColor"
                            d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z"
                          />
                        </svg>
                      </div>
                      <div class="col-6 text-size16 pt-2">Muti Carga</div>
                    </div>
                  </div>
                </div>

                <div class="col align-self-end">
                  <div
                    id="logoutButton"
                    class="col border rounded py-md-2 px-md-1 my-1"
                  >
                    <div class="row">
                      <div class="col-3">
                        <svg
                          width="40px"
                          height="40px"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 640 512"
                          class="ps-2"
                        >
                          <path
                            fill="currentColor"
                            d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"
                          />
                        </svg>
                      </div>
                      <div class="col-6 text-size16 pt-2">Cerrar Sesión</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </section>
        </div>
      </div>
           
            <!-- Menú tipo top Tab -->
            <div class="container-none-web fixed-top py-2 shadow-lg"
            style="background:#388253;"
            >
                <div class="d-flex justify-content-around">
                <div class="row mp-2">
              <h5 class="text-center text-white">UPClass</h5>
            </div>
            <div class="row mp-2">
              <h6 class="text-center text-white mt-1">Director</h6>
            </div>
                </div>
            </div>

            <!-- Menú tipo Bottom Tab en móviles -->
            <div class="container-none-web fixed-bottom py-2 shadow-lg"
            style="background:#388253;"
            >
                <div class="d-flex justify-content-around">
                <button
                  class="btn-iframe-click border-0 bg-transparent active"
                  data-src="dashboard.php"
                >
                <svg
                          viewBox="0 0 15 15"
                          width="30px"
                          height="30px"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            fill="currentColor"
                            d="M7.8254 0.120372C7.63815 -0.0401239 7.36185 -0.0401239 7.1746 0.120372L0 6.27003V13.5C0 14.3284 0.671573 15 1.5 15H5.5C5.77614 15 6 14.7761 6 14.5V11.5C6 10.6716 6.67157 10 7.5 10C8.32843 10 9 10.6716 9 11.5V14.5C9 14.7761 9.22386 15 9.5 15H13.5C14.3284 15 15 14.3284 15 13.5V6.27003L7.8254 0.120372Z"
                          />
                        </svg>
                </button>
                <button
                  class="btn-iframe-click border-0 bg-transparent"
                  data-src="supervisor.php"
                >
                <svg
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 640 512"
                          class="ps-2"
                          width="40px"
                          height="40px"
                        >
                          <path
                          
                            fill="currentColor"
                            d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"
                            />
                        </svg>
                </button>
                <button
                  class="btn-iframe-click border-0 bg-transparent"
                  data-src="docente.php"
                >
                <svg
                          width="40px"
                          height="40px"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 640 512"
                          class="ps-2"
                        >
                          <path
                            fill="currentColor"
                            d="M192 96a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm-8 384l0-128 16 0 0 128c0 17.7 14.3 32 32 32s32-14.3 32-32l0-288 56 0 64 0 16 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-16 0 0-64 192 0 0 192-192 0 0-32-64 0 0 48c0 26.5 21.5 48 48 48l224 0c26.5 0 48-21.5 48-48l0-224c0-26.5-21.5-48-48-48L368 0c-26.5 0-48 21.5-48 48l0 80-76.9 0-65.9 0c-33.7 0-64.9 17.7-82.3 46.6l-58.3 97c-9.1 15.1-4.2 34.8 10.9 43.9s34.8 4.2 43.9-10.9L120 256.9 120 480c0 17.7 14.3 32 32 32s32-14.3 32-32z"
                          />
                </button>
                <button
                  class="btn-iframe-click border-0 bg-transparent"
                  data-src="horario.php"
                >
                <svg
                          width="40px"
                          height="40px"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 640 512"
                          class="ps-2"
                        >
                          <path
                            fill="currentColor"
                            d="M128 0c17.7 0 32 14.3 32 32l0 32 128 0 0-32c0-17.7 14.3-32 32-32s32 14.3 32 32l0 32 48 0c26.5 0 48 21.5 48 48l0 48L0 160l0-48C0 85.5 21.5 64 48 64l48 0 0-32c0-17.7 14.3-32 32-32zM0 192l448 0 0 272c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 192zm64 80l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm128 0l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zM64 400l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zm112 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16z"
                          />
                        </svg>
                </button>
                </div>
            </div>
      <div class="style-media-scree">
        <iframe
          id="mainFrame"
          src="dashboard.php"
          frameborder="0"
          class="min-vh-100"
          style="width: 100%"
        >
        </iframe>
      </div>
    </div>
  </div>
 <!-- Modal de confirmación para cerrar sesión -->
 <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">Confirmar cierre de sesión</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          ¿Está seguro de que desea cerrar la sesión?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="confirmLogout">Cerrar Sesión</button>
        </div>
      </div>
    </div>
  </div>
  <?php echo constant("BOOTSTRAP_CDN_JS") ?>

  <script>
  const PUBLIC_BASE_URL = "<?php echo constant('PUBLIC_BASE_URL'); ?>";
  document.addEventListener("DOMContentLoaded", function () {
    const logoutButton = document.getElementById("logoutButton");
    const confirmLogoutBtn = document.getElementById("confirmLogout");
    const logoutModalEl = document.getElementById("logoutModal");
    const logoutModal = new bootstrap.Modal(logoutModalEl, {});
    
    logoutButton.addEventListener("click", function () {
      logoutModal.show();
    });
    
    confirmLogoutBtn.addEventListener("click", function () {
      window.location.href = PUBLIC_BASE_URL + "/index?logout=true";
    });
  });
</script>
</body>
</html>