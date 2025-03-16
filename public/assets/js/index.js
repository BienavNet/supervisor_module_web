const form = document.getElementById("login-form");
const email = document.getElementById("email");
const password = document.getElementById("password");
const showpass = document.getElementById("showpassword");

const URL_BASE = "http://localhost:5000/api";
const URL_BASE_SERVER = "http://localhost/supervisor_module_web";
const URL_SESSION = `${URL_BASE_SERVER}/config/session.php?access_token=`;

form.addEventListener("submit", (e) => {
  e.preventDefault();
  if (email.value == "" || email.value == undefined) {
    Toastify({
      text: "No puedes dejar el espacio del correo en blanco",
      className: "info",
      style: {
        background: "linear-gradient(to right, #f10909, #5b0b0b)",
      },
    }).showToast();
  } else if (password.value == "" || password.value == undefined) {
    Toastify({
      text: "No puedes dejar el espacio de la contraseña en blanco",
      className: "info",
      style: {
        background: "linear-gradient(to right, #f10909, #5b0b0b)",
      },
    }).showToast();
  } else {
    fetch(`${URL_BASE}/login`, {
      method: "POST",
      body: JSON.stringify({
        correo: email.value,
        contrasena: password.value,
        rol: "director",
      }),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((response) => {
        if (response.status == "error") {
          Toastify({
            text: response.message,
            className: "info",
            style: {
              background: "linear-gradient(to right, #f10909, #5b0b0b)",
            },
          }).showToast();
        } else {
          Toastify({
            text: "Sesión iniciada correctamente!",
            className: "success",
            style: {
              background:
                "linear-gradient(to right,rgb(46, 184, 11),rgb(62, 135, 6))",
            },
          }).showToast();

          fetch(`${URL_SESSION}${response.access_token}`, {
            method: "GET",
            headers: {
              "Content-Type": "application/json",
            },
          });

          window.location.href = `${URL_BASE_SERVER}/public/dashboard`;
        }
      });
  }
});

showpass.addEventListener("click", (e) => {
  if (showpass.checked == true) {
    password.setAttribute("type", "text");
  } else {
    password.setAttribute("type", "password");
  }
});
