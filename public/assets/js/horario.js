const API_BASE = "http://localhost:5000/api";
const API_BASE_URL = "http://localhost:5000/api/horarios";
const tbody = document.getElementById("tbody");
const registerForm = document.getElementById("registerForm");
const editForm = document.getElementById("editForm");
const editButtons = document.querySelectorAll(".edit");
const deleteButtons = document.querySelectorAll(".delete");

const registerBtn = document.getElementById("registerBtn");
const useToastify = (messsage, status) => {
  let background;
  if (status === "success") {
    background = "linear-gradient(to right, rgb(46, 184, 11), rgb(62, 135, 6))";
  } else if (status === "error") {
    background = "linear-gradient(to right, #f10909, #5b0b0b)";
  }
  return Toastify({
    text: messsage,
    className: "info",
    style: {
      background: background || "gray",
    },
  }).showToast();
};
registerBtn.addEventListener("click", (e) => {
  const select = document.getElementById("docentes-select");
  const select2 = document.getElementById("asignatura-select");

  select.innerHTML = "";
  select2.innerHTML = "";

  fetch(`${API_BASE}/docente/`, {
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${
        document.cookie.replace("access_token=", "").split("; ")[0]
      }`,
    },
    credentials: "same-origin",
  })
    .then((result) => result.json())
    .then((result) => {
      if (result.length === 0) {
        let option = document.createElement("option");
        option.textContent = "No hay docentes disponible";
        option.disabled = true;
        option.selected = true;
        select.appendChild(option);
      } else {
        result.forEach((element) => {
          let option = document.createElement("option");
          option.value = element.docente_id;
          option.innerHTML =
            `${element.nombre} ${element.apellido} ${element.cedula}`.toUpperCase();
          select.appendChild(option);
        });
      }
    });

  fetch("../json/asignaturas.json")
    .then((result) => result.json())
    .then((result) => {
      result.forEach((result) => {
        let option = document.createElement("option");
        option.value = result.asignatura;
        option.innerHTML = `${result.asignatura}`.toUpperCase();
        select2.appendChild(option);
      });
    });
});

function deleteButtonClick(element) {
  const children = element.parentElement.parentElement.parentElement.children;
  let id = parseInt(children[0].innerText);
  let confirm = prompt(
    "Escribe el id del registro para confirmar la eliminación de la base de datos: "
  );
  if (parseInt(confirm) == id) {
    fetch(`${API_BASE_URL}/delete/${id}`, {
      method: "DELETE",
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

  const doc_select = document.getElementById("edit-docentes-select");
  const subject = document.getElementById("edit-subject-select");
  const day_select = document.getElementById("edit-day-select");
  const tstart = document.getElementById("edit-tstart");
  const tend = document.getElementById("edit-tend");

  let doc_id = children[1].innerText.toString().split(" ")[2];
  let asignatura = children[2].innerText;
  let dia = children[3].innerText;
  let inicio = children[4].innerText;
  let fin = children[5].innerText;
  let id = parseInt(children[0].innerText);

  fetch(`${API_BASE}/docente/`, {
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${
        document.cookie.replace("access_token=", "").split("; ")[0]
      }`,
    },
    credentials: "same-origin",
  })
    .then((result) => result.json())
    .then((element) => {
      doc_select.innerHTML = "";
      element.forEach((element) => {
        let option = document.createElement("option");
        option.value = element.docente_id;
        option.innerHTML =
          `${element.nombre} ${element.apellido} ${element.cedula}`.toUpperCase();
        if (element.cedula == doc_id) {
          option.selected = true;
        }
        doc_select.appendChild(option);
      });
    });

  fetch("../json/asignaturas.json")
    .then((result) => result.json())
    .then((result) => {
      subject.innerHTML = "";
      result.forEach((result) => {
        let option = document.createElement("option");
        option.value = result.asignatura;
        option.innerHTML = `${result.asignatura}`.toUpperCase();

        if (result.asignatura == asignatura) {
          option.selected = true;
        }

        subject.appendChild(option);
      });
    });

  day_select.value = dia;
  tstart.value = inicio;
  tend.value = fin;

  editForm.addEventListener("submit", (e) => {
    e.preventDefault();

    if (subject.value == undefined) {
      useToastify("El campo nombre no puede estar vacío.", "error");
    } else if (day_select.value == "" || day_select.value == undefined) {
      useToastify("El campo apellido no puede estar vacío.", "error");
    } else if (tstart.value == "" || tstart.value == undefined) {
      useToastify(
        "El campo cédula no puede estar vacío o contiene caracteres que no son números.",
        "error"
      );
    } else if (tend.value == "" || tend.value == undefined) {
      useToastify("El campo email no puede estar vacío.", "error");
    } else {
      let response = confirm("Confirme la acción: Actualizar datos.");

      if (response) {
        fetch(`${API_BASE_URL}/update/${id}`, {
          method: "PATCH",
          body: JSON.stringify({
            docente: doc_select.value,
            asignatura: subject.value,
          }),
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
            if (response.status == "ok") {
              fetch(`${API_BASE}/horarios/detalles/update/horario/${id}`, {
                method: "PATCH",
                body: JSON.stringify({
                  horario: id,
                  dia: dia,
                  hora_inicio: inicio,
                  hora_fin: hora_fin,
                }),
                headers: {
                  "Content-Type": "application/json",
                  Authorization: `Bearer ${
                    document.cookie.replace("access_token=", "").split("; ")[0]
                  }`,
                },
                credentials: "same-origin",
              }).then((response) => response.json());
              then((response) => {
                useToastify(response.message, "success");
              });

              window.location.reload();
            } else {
              useToastify(response.message, "error");
            }
          });
      }
    }
  });
}

registerForm.addEventListener("submit", (e) => {
  e.preventDefault();

  const doc_select = document.getElementById("docentes-select");
  const subject = document.getElementById("asignatura-select");
  const day_select = document.getElementById("day-select");
  const tstart = document.getElementById("tstart");
  const tend = document.getElementById("tend");

  if (doc_select.value == undefined) {
    useToastify("Tiene que seleccionar a un docente.", "error");
  } else if (subject.value == undefined) {
    useToastify("Tiene que escribir el nombre de la asignatura.", "error");
  } else if (day_select.value == undefined) {
    useToastify("Tiene que seleccionar un día.", "error");
  } else if (tstart.value == undefined || tstart.value == "") {
    useToastify("Tiene que estipular una hora de inicio de clases.", "error");
  } else if (tend.value == undefined || tend.value == "") {
    useToastify("Tiene que estipular una hora de fin de clases.", "error");
  } else {
    fetch(`${API_BASE_URL}/save`, {
      method: "POST",
      body: JSON.stringify({
        docente: parseInt(doc_select.value),
        asignatura: subject.value,
      }),
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
        if (response.status == "ok") {
          fetch(`${API_BASE}/horarios/detalles/save`, {
            method: "POST",
            body: JSON.stringify({
              horario: response.id,
              dia: day_select.value,
              hora_inicio: tstart.value,
              hora_fin: tend.value,
            }),
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
              useToastify(response.message, "success");
              window.location.reload();
            });
        } else {
          useToastify(response.message, "error");
        }
      });
  }
});

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
    if (response.message === "not found schedules.") {
      console.log("No hay horarios disponibles.");
      return (response = []);
    }
    // if (!response.data || response.data.length === 0) {
    //   console.log("No hay horarios disponibles.");
    //   return (response = 0);
    // }

    let tableData = response.data.map((element) => [
      element.id,
      `${element.nombre} ${element.apellido} ${element.cedula}`,
      element.asignatura,
      element.dia,
      element.hora_inicio,
      element.hora_fin,
    ]);

    return tableData;
  })
  .catch((error) => {
    console.error("Error al obtener los datos:", error);
    return [];
  });

function main() {
  loadData.then((result) => {
    new DataTable("#myTable", {
      dom: "Bfrtip",
      paging: true,
      scrollX: true,
      scrollY: true,
      columns: [
        { title: "Id" },
        { title: "Docente" },
        // { title: "Apellido" },
        // { title: "Cédula" },
        { title: "Asignatura" },
        { title: "Dia" },
        { title: "Hora: Inicio" },
        { title: "Hora: Fin" },
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
            columns: "th:not(:last-child)",
          },
        },
        {
          extend: "excelHtml5",
          text: "Excel",
          titleAttr: "Excel",
          className: "btn btn-success my-3 mx-1",
          exportOptions: {
            columns: "th:not(:last-child)",
          },
        },
        {
          extend: "csvHtml5",
          text: "CSV",
          titleAttr: "CSV",
          className: "btn btn-secondary my-3 mx-1",
          exportOptions: {
            columns: "th:not(:last-child)",
          },
        },
        {
          extend: "pdfHtml5",
          text: "PDF",
          titleAttr: "PDF",
          className: "btn btn-danger my-3 mx-1",
          exportOptions: {
            columns: "th:not(:last-child)",
          },
        },
        {
          extend: "print",
          text: "Imprimir",
          titleAttr: "Imprimir",
          className: "btn btn-info my-3 mx-1",
          exportOptions: {
            columns: "th:not(:last-child)",
          },
        },
      ],
    });
  });
}
main();
