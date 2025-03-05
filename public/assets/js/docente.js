const API_BASE_URL =
  "https://appsalones-production-106a.up.railway.app/api/docente";
const tbody = document.getElementById("tbody");
const registerForm = document.getElementById("registerForm");
const editForm = document.getElementById("editForm");
const editButtons = document.querySelectorAll(".edit");
const deleteButtons = document.querySelectorAll(".delete");

function getAuthToken() {
  const token = document.cookie
    .split("; ")
    .find((row) => row.startsWith("access_token="))
    ?.split("=")[1];
  return token || "";
}

const useToastify = (messsage, status) => {
  let background;
  if (status === "success") {
    background = "linear-gradient(to right, #f10909, #5b0b0b)";
  } else if (status === "error") {
    background = "linear-gradient(to right, rgb(46, 184, 11), rgb(62, 135, 6))";
  }
  return Toastify({
    text: messsage,
    className: "info",
    style: {
      background: background || "gray",
    },
  }).showToast();
};

function deleteButtonClick(element) {
  const token = getAuthToken();
  const children = element.parentElement.parentElement.parentElement.children;
  let cedula = parseInt(children[3].innerText);
  let confirm = prompt(
    "Escribe la cédula del registro para confirmar la eliminación de la base de datos: "
  );
  if (parseInt(confirm) == cedula) {
    fetch(`${API_BASE_URL}/delete/${cedula}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
      credentials: "same-origin",
    })
      .then((response) => response.json())
      .then((response) => {
        useToastify(response.message, "success");
        window.location.reload();
      });
  } else {
    useToastify(
      "Usted ha introducido mal el id, por lo tanto no se ha eliminado el registro.",
      "error"
    );
  }
}

function editButtonClick(element) {
  const children = element.parentElement.parentElement.parentElement.children;
  let nombre = children[1].innerText;
  let apellido = children[2].innerText;
  let cedula = parseInt(children[3].innerText);
  let correo = children[4].innerText;

  const edit_name = document.getElementById("edit-name");
  const edit_lname = document.getElementById("edit-lname");
  const edit_dni = document.getElementById("edit-dni");
  const edit_email = document.getElementById("edit-email");

  edit_name.value = nombre;
  edit_lname.value = apellido;
  edit_dni.value = cedula;
  edit_email.value = correo;

  editForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const token = getAuthToken();
    if (edit_name.value == "" || edit_name.value == undefined) {
      useToastify("El campo nombre no puede estar vacío.", "error");
    } else if (edit_lname.value == "" || edit_lname.value == undefined) {
      useToastify("El campo apellido no puede estar vacío.", "error");
    } else if (edit_dni.value == "" || edit_dni.value == undefined) {
      useToastify(
        "El campo cédula no puede estar vacío o contiene caracteres que no son números.",
        "error"
      );
    } else if (edit_email.value == "" || edit_email.value == undefined) {
      useToastify("El campo email no puede estar vacío.", "error");
    } else {
      let response = confirm("Confirme la acción: Actualizar datos.");

      if (response) {
        fetch(`${API_BASE_URL}/update/${cedula}`, {
          method: "PATCH",
          body: JSON.stringify({
            nombre: edit_name.value,
            apellido: edit_lname.value,
            cedula: parseInt(edit_dni.value),
            correo: edit_email.value,
          }),
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
          credentials: "same-origin",
        })
          .then((response) => response.json())
          .then((response) => {
            useToastify(response.message, "success");
            window.location.reload();
          });
      }
    }
  });
}

registerForm.addEventListener("submit", (e) => {
  e.preventDefault();
  const token = getAuthToken();
  const name_input = document.getElementById("name");
  const lname_input = document.getElementById("lname");
  const dni_input = document.getElementById("dni");
  const email_input = document.getElementById("email");
  const password_input = document.getElementById("password");
  const cpassword_input = document.getElementById("cpassword");

  if (name_input.value == "" || name_input.value == undefined) {
    useToastify("El campo nombre no puede estar vacío.", "error");
  } else if (lname_input.value == "" || lname_input.value == undefined) {
    useToastify("El campo apellido no puede estar vacío.", "error");
  } else if (dni_input.value == "" || dni_input.value == undefined) {
    useToastify(
      "El campo cédula no puede estar vacío o contiene caracteres que no son números.",
      "error"
    );
  } else if (email_input.value == "" || email_input.value == undefined) {
    useToastify("El campo email no puede estar vacío.", "error");
  } else if (password_input.value == "" || password_input.value == undefined) {
    useToastify("El campo contraseña no puede estar vacío.", "error");
  } else if (
    cpassword_input.value == "" ||
    cpassword_input.value == undefined
  ) {
    useToastify("El campo confirmar contraseña no puede estar vacío.", "error");
  } else if (password_input.value != cpassword_input.value) {
    useToastify("Las contaseñas no coínciden.", "error");
  } else {
    fetch(`${API_BASE_URL}/save`, {
      method: "POST",
      body: JSON.stringify({
        nombre: name_input.value,
        apellido: lname_input.value,
        cedula: parseInt(dni_input.value),
        correo: email_input.value,
        contrasena: password_input.value,
      }),
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
      credentials: "same-origin",
    })
      .then((response) => response.json())
      .then((response) => {
        useToastify(response.message, "success");
        window.location.reload();
      });
  }
});

const token_ = document.cookie.replace("access_token=", "").split("; ")[0];
console.log("token_ :", token_);
let loadData = fetch(`${API_BASE_URL}/`, {
  headers: {
    "Content-Type": "application/json",
    Authorization: `Bearer ${
      document.cookie.replace("access_token=", "").split("; ")[0]
    }`,
  },
  credentials: "same-origin",
})
  .then((response) => response.json())
  .then((response) => {
    let tableData = [];
    response.forEach((element) => {
      tableData.push([
        element.docente_id,
        element.nombre,
        element.apellido,
        element.cedula,
        element.correo,
      ]);
    });
    console.log(tableData);
    return tableData;
  });

function main() {
  const loadingData = loadData.then((result) => {
    console.log(" loadin data: ", loadingData);
    let table = new DataTable("#myTable", {
      dom: "Bfrtip",
      paging: true,
      columns: [
        { title: "ID" },
        { title: "Nombre" },
        { title: "Apellido" },
        { title: "Cédula" },
        { title: "Correo" },
        {
          title: "Acciones",
          defaultContent: `<div class="col d-flex flex-row notexport">
    <button class="btn btn-warning my-3 mx-1" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editButtonClick(this)">Editar</button>
    <button class="btn btn-danger my-3 mx-1" onclick="deleteButtonClick(this)">Eliminar</button>
</div>`,
        },
      ],
      data: result,
      buttons: [
        {
          extend: "copyHtml5",
          text: "Copiar",
          titleAttr: "Copiar",
          className: "btn btn-primary my-3 mx-1",
          exportOptions: {
            columns: 'th:not(:last-child)'
        }
        },
        {
          extend: "excelHtml5",
          text: "Excel",
          titleAttr: "Excel",
          className: "btn btn-success my-3 mx-1",
          exportOptions: {
            columns: 'th:not(:last-child)'
        }
        },
        {
          extend: "csvHtml5",
          text: "CSV",
          titleAttr: "CSV",
          className: "btn btn-secondary my-3 mx-1",
          exportOptions: {
            columns: 'th:not(:last-child)'
        }
        },
        {
          extend: "pdfHtml5",
          text: "PDF",
          titleAttr: "PDF",
          className: "btn btn-danger my-3 mx-1",
          exportOptions: {
            columns: 'th:not(:last-child)'
        }
        },
        {
          extend: "print",
          text: "Imprimir",
          titleAttr: "Imprimir",
          className: "btn btn-info my-3 mx-1",
          exportOptions: {
            columns: 'th:not(:last-child)'
        }
        },
      ],
    });
  });
}
main();
