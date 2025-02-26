const API_BASE = "http://localhost:5000/api"
const API_BASE_URL = "http://localhost:5000/api/horarios"
const tbody = document.getElementById("tbody")
const registerForm = document.getElementById("registerForm")
const editForm = document.getElementById("editForm")
const editButtons = document.querySelectorAll('.edit')
const deleteButtons = document.querySelectorAll('.delete')


const registerBtn = document.getElementById("registerBtn")



registerBtn.addEventListener('click', (e) => {
    const select = document.getElementById("docentes-select")
    const select2 = document.getElementById("asignatura-select")

    fetch(`${API_BASE}/docente/`, {
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
        },
        credentials: "same-origin"
    })
        .then(result => result.json())
        .then(result => {
            result.forEach(element => {
                let option = document.createElement('option')
                option.value = element.docente_id
                option.innerHTML = `${element.nombre} ${element.apellido} ${element.cedula}`.toUpperCase()
                select.appendChild(option)

            });
        })

    fetch('../json/asignaturas.json')
        .then(result => result.json())
        .then(result => {
            result.forEach(result => {
                let option = document.createElement('option')
                option.value = result.asignatura
                option.innerHTML = `${result.asignatura}`.toUpperCase()
                select2.appendChild(option)
            })

        })

})


function deleteButtonClick(element) {
    const children = element.parentElement.parentElement.parentElement.children
    let id = parseInt(children[0].innerText)
    let confirm = prompt("Escribe el id del registro para confirmar la eliminación de la base de datos: ")
    if (parseInt(confirm) == id) {
        fetch(`${API_BASE_URL}/delete/${id}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
            },
            credentials: "same-origin"
        })
            .then(response => response.json())
            .then(response => {
                alert(`Respuesta del servidor: ${response.message}`)
                window.location.reload()
            })
    } else {
        alert("Usted ha introducido mal el id, por lo tanto no se ha eliminado el registro.")
    }
}

function editButtonClick(element) {
    const children = element.parentElement.parentElement.parentElement.children

    const doc_select = document.getElementById("edit-docentes-select")
    const subject = document.getElementById("edit-subject-select")
    const day_select = document.getElementById("edit-day-select")
    const tstart = document.getElementById("edit-tstart")
    const tend = document.getElementById("edit-tend")

    let doc_id = children[1].innerText.toString().split(" ")[2]
    let asignatura = children[2].innerText
    let dia = children[3].innerText
    let inicio = children[4].innerText
    let fin = children[5].innerText
    let id = parseInt(children[0].innerText)

    fetch(`${API_BASE}/docente/`, {
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
        },
        credentials: "same-origin"
    })
        .then(result => result.json())
        .then(element => {
            doc_select.innerHTML = ''
            element.forEach(element => {
                let option = document.createElement('option')
                option.value = element.docente_id
                option.innerHTML = `${element.nombre} ${element.apellido} ${element.cedula}`.toUpperCase()
                if (element.cedula == doc_id) {
                    option.selected = true
                }
                doc_select.appendChild(option)
            })
        })


    fetch('../json/asignaturas.json')
        .then(result => result.json())
        .then(result => {
            subject.innerHTML = ''
            result.forEach(result => {
                let option = document.createElement('option')
                option.value = result.asignatura
                option.innerHTML = `${result.asignatura}`.toUpperCase()

                if (result.asignatura == asignatura) {
                    option.selected = true
                }

                subject.appendChild(option)
            })

        })


    day_select.value = dia
    tstart.value = inicio
    tend.value = fin

    editForm.addEventListener("submit", e => {
        e.preventDefault()

        if (subject.value == undefined) {
            alert("El campo nombre no puede estar vacío.")
        } else if (day_select.value == '' || day_select.value == undefined) {
            alert("El campo apellido no puede estar vacío.")
        } else if (tstart.value == '' || tstart.value == undefined) {
            alert("El campo cédula no puede estar vacío o contiene caracteres que no son números.")
        } else if (tend.value == '' || tend.value == undefined) {
            alert("El campo email no puede estar vacío.")
        } else {

            let response = confirm("Confirme la acción: Actualizar datos.")

            if (response) {
                fetch(`${API_BASE_URL}/update/${id}`, {
                    method: "PATCH",
                    body: JSON.stringify({
                        "docente": doc_select.value,
                        "asignatura": subject.value
                    }),
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
                    },
                    credentials: "same-origin"
                })
                    .then(response => response.json())
                    .then(response => {

                        if (response.status == "ok") {

                            fetch(`${API_BASE}/horarios/detalles/update/horario/${id}`, {
                                method: "PATCH",
                                body: JSON.stringify({
                                    "horario": id,
                                    "dia": dia,
                                    "hora_inicio": inicio,
                                    "hora_fin": hora_fin
                                }),
                                headers: {
                                    "Content-Type": "application/json",
                                    "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
                                },
                                credentials: "same-origin"

                            })
                                .then(response => response.json())
                            then(response => {
                                alert(`Respuesta del servidor: ${response.message}`)
                            })

                            window.location.reload()

                        } else {
                            alert(`Respuesta del servidor: ${response.message}`)
                        }

                    })
            }
        }
    })
}



registerForm.addEventListener("submit", e => {
    e.preventDefault()

    const doc_select = document.getElementById("docentes-select")
    const subject = document.getElementById("asignatura-select")
    const day_select = document.getElementById("day-select")
    const tstart = document.getElementById("tstart")
    const tend = document.getElementById("tend")

    if (doc_select.value == undefined) {
        alert("Tiene que seleccionar a un docente.")
    } else if (subject.value == undefined) {
        alert("Tiene que escribir el nombre de la asignatura.")
    } else if (day_select.value == undefined) {
        alert("Tiene que seleccionar un día.")
    } else if (tstart.value == undefined || tstart.value == "") {
        alert("Tiene que estipular una hora de inicio de clases.")
    } else if (tend.value == undefined || tend.value == "") {
        alert("Tiene que estipular una hora de fin de clases.")
    } else {
        fetch(`${API_BASE_URL}/save`, {
            method: "POST",
            body: JSON.stringify({
                "docente": parseInt(doc_select.value),
                "asignatura": subject.value
            }),
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
            },
            credentials: "same-origin"
        })
            .then(response => response.json())
            .then(response => {
                if (response.status == "ok") {
                    fetch(`${API_BASE}/horarios/detalles/save`, {
                        method: "POST",
                        body: JSON.stringify({
                            "horario": response.id,
                            "dia": day_select.value,
                            "hora_inicio": tstart.value,
                            "hora_fin": tend.value
                        }),
                        headers: {
                            "Content-Type": "application/json",
                            "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
                        },
                        credentials: "same-origin"
                    })
                        .then(response => response.json())
                        .then(response => {
                            alert(`Respuesta del servidor: ${response.message}`)
                            window.location.reload()
                        })
                } else {
                    alert(`Respuesta del servidor: ${response.message}`)
                }
            })

    }
})



let loadData = fetch(`${API_BASE_URL}/`, {
    headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
    },
    credentials: "same-origin"
})
    .then(response => response.json())
    .then(response => {
        // console.log(response, typeof response)
        let tableData = []
        response.forEach(element => {
            // console.log(element)

            tableData.push([element.id, `${element.nombre} ${element.apellido} ${element.cedula}`, element.asignatura, element.dia, element.hora_inicio, element.hora_fin])
        });
        // console.log(tableData)
        return tableData
    })



function main() {

    const loadingData = loadData.then(result => {
        let table = new DataTable('#myTable', {
            dom: 'Bfrtip',
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
                    defaultContent: `<div class="col d-flex flex-row">
    <button class="btn btn-warning my-3 mx-1" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editButtonClick(this)">Editar</button>
    <button class="btn btn-danger my-3 mx-1" onclick="deleteButtonClick(this)">Eliminar</button>
</div>`
                }
            ],
            data: result,
            buttons: [
                {
                    extend: "copyHtml5",
                    text: "Copiar",
                    titleAttr: "Copiar",
                    className: "btn btn-primary my-3 mx-1"
                },
                {
                    extend: "excelHtml5",
                    text: 'Excel',
                    titleAttr: "Excel",
                    className: "btn btn-success my-3 mx-1"
                },
                {
                    extend: "csvHtml5",
                    text: "CSV",
                    titleAttr: "CSV",
                    className: "btn btn-secondary my-3 mx-1"
                },
                {
                    extend: "pdfHtml5",
                    text: "PDF",
                    titleAttr: "PDF",
                    className: "btn btn-danger my-3 mx-1"
                },
                {
                    extend: "print",
                    text: "Imprimir",
                    titleAttr: "Imprimir",
                    className: "btn btn-info my-3 mx-1"
                }
            ],

        })

    })
}

// function loadModalForRegister() {

// }


main()



