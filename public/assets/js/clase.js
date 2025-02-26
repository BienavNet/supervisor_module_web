const API_BASE = "http://localhost:5000/api"
const API_BASE_URL = "http://localhost:5000/api/clase"
const tbody = document.getElementById("tbody")
const registerForm = document.getElementById("registerForm")
const editForm = document.getElementById("editForm")
const editButtons = document.querySelectorAll('.edit')
const deleteButtons = document.querySelectorAll('.delete')


const registerBtn = document.getElementById("registerBtn")

registerBtn.addEventListener('click', (e) => {
    const select = document.getElementById("horario-select")
    const select2 = document.getElementById("salon-select")
    const select3 = document.getElementById("supervisor-select")

    fetch(`${API_BASE}/horarios/`, {
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
        },
        credentials: "same-origin"
    })
        .then(result => result.json())
        .then(result => {
            select.innerHTML = ''
            result.forEach(element => {
                let option = document.createElement('option')
                option.value = element.id
                option.innerHTML = `${element.asignatura} ${element.hora_inicio} - ${element.hora_fin} ${element.apellido} ${element.cedula}`.toUpperCase()
                select.appendChild(option)

            });
        })

    fetch(`${API_BASE}/salon/`, {
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
        },
        credentials: "same-origin"
    })
        .then(result => result.json())
        .then(result => {
            select2.innerHTML = ''
            result.forEach(element => {
                let option = document.createElement('option')
                option.value = element.id
                option.innerHTML = `${element.numero_salon} ${element.nombre} - ${element.capacidad}`.toUpperCase()
                select2.appendChild(option)

            });
        })

    fetch(`${API_BASE}/supervisor/`, {
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
        },
        credentials: "same-origin"
    })
        .then(result => result.json())
        .then(result => {
            select3.innerHTML = ''
            result.forEach(element => {
                let option = document.createElement('option')
                option.value = element.supervisor_id
                option.innerHTML = `${element.cedula} - ${element.nombre} ${element.apellido}`.toUpperCase()
                select3.appendChild(option)

            });
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

    const horario_select = document.getElementById("edit-horario-select")
    const salon = document.getElementById("edit-salon-select")
    const supervisor = document.getElementById("edit-supervisor-select")
    const newDate = document.getElementById("edit-date")
    const status = document.getElementById("edit-status")

    let claseId = children[0].innerText
    let horario_id = children[6].innerText
    let salon_number = children[4].innerText
    let supervisor_cedula = children[5].innerText.toString().split(" ")[0]
    let fecha = children[1].innerText
    let estado = children[7].innerText

    newDate.value = fecha
    status.value = estado



    fetch(`${API_BASE}/horarios/`, {
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
        },
        credentials: "same-origin"
    })
        .then(result => result.json())
        .then(result => {
            horario_select.innerHTML = ''
            result.forEach(element => {
                let option = document.createElement('option')
                option.value = element.id
                option.innerHTML = `${element.asignatura} ${element.hora_inicio} - ${element.hora_fin} ${element.apellido} ${element.cedula}`.toUpperCase()

                if (element.id == horario_id) {
                    option.selected = true
                }
                horario_select.appendChild(option)

            });
        })

    fetch(`${API_BASE}/salon/`, {
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
        },
        credentials: "same-origin"
    })
        .then(result => result.json())
        .then(result => {
            salon.innerHTML = ''
            result.forEach(element => {
                let option = document.createElement('option')
                option.value = element.id
                option.innerHTML = `${element.numero_salon} ${element.nombre} - ${element.capacidad}`.toUpperCase()
                if (element.numero_salon == salon_number) {
                    option.selected = true
                }
                salon.appendChild(option)

            });
        })


    fetch(`${API_BASE}/supervisor/`, {
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
        },
        credentials: "same-origin"
    })
        .then(result => result.json())
        .then(result => {
            supervisor.innerHTML = ''
            result.forEach(element => {
                let option = document.createElement('option')
                option.value = element.supervisor_id
                option.innerHTML = `${element.cedula} - ${element.nombre} ${element.apellido}`.toUpperCase()
                if (element.cedula == supervisor_cedula) {
                    option.selected = true
                }
                supervisor.appendChild(option)

            });
        })


    editForm.addEventListener("submit", e => {
        e.preventDefault()

        if (horario_select.value == undefined) {
            alert("El campo nombre no puede estar vacío.")
        } else if (salon.value == undefined) {
            alert("El campo apellido no puede estar vacío.")
        } else if (supervisor.value == undefined) {
            alert("El campo cédula no puede estar vacío o contiene caracteres que no son números.")
        } else if (newDate.value == '' || newDate.value == undefined) {
            alert("El campo email no puede estar vacío.")
        } else if (status.value == '' || status.value == undefined) {
            alert("El campo email no puede estar vacío.")
        }else {

            let response = confirm("Confirme la acción: Actualizar datos.")

            if (response) {
                fetch(`${API_BASE_URL}/update/${claseId}`, {
                    method: "PATCH",
                    body: JSON.stringify({
                        "horario": parseInt(horario_select.value),
                        "salon": parseInt(salon.value),
                        "supervisor": parseInt(supervisor.value),
                        "estado": status.value,
                        "fecha": newDate.value
                    }),
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
                    },
                    credentials: "same-origin"
                }).then(response => response.json())
                    .then(response => {
                        alert(`Respuesta del servidor: ${response.message}`)
                        window.location.reload()
                    })
            }
        }
    })
}

registerForm.addEventListener("submit", e => {
    e.preventDefault()

    const horario_select = document.getElementById("horario-select")
    const room_select = document.getElementById("salon-select")
    const supervisor_select = document.getElementById("supervisor-select")
    const tstart = document.getElementById("dstart")
    const tend = document.getElementById("dend")

    if (horario_select.value == undefined) {
        alert("Tiene que seleccionar a un docente.")
    } else if (room_select.value == undefined) {
        alert("Tiene que escribir el nombre de la asignatura.")
    } else if (supervisor_select.value == undefined) {
        alert("Tiene que seleccionar un día.")
    } else if (tstart.value == undefined || tstart.value == "") {
        alert("Tiene que estipular una hora de inicio de clases.")
    } else if (tend.value == undefined || tend.value == "") {
        alert("Tiene que estipular una hora de fin de clases.")
    } else {

        let my_date = new Date(tstart.value)
        let end_date = new Date(tend.value)

        let updated_date_foramtted = `${my_date.getFullYear()}-${my_date.getMonth()}-${my_date.getDay()}`

        do {
            fetch(`${API_BASE_URL}/register`, {
                method: "POST",
                body: JSON.stringify({
                    "horario": horario_select.value,
                    "salon": room_select.value,
                    "supervisor": supervisor_select.value,
                    "estado": "pendiente",
                    "fecha": updated_date_foramtted
                }),
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${document.cookie.replace("access_token=", "").split("; ")[0]}`
                },
                credentials: "same-origin"
            })
                .then(response => response.json())
                .then(response => {
                    console.log(response)
                })

            my_date = new Date(my_date.setDate(my_date.getDate() + 7))
        } while (my_date < end_date);

        alert("Se ha registrado las clases correctamente.")
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
            tableData.push([element.id, element.fecha.substr(0, element.fecha.indexOf('T')), element.asignatura, `${element.docente_id} ${element.docente_nombre} ${element.docente_apellido}`, element.numero_salon, `${element.supervisor_id} ${element.supervisor_nombre} ${element.supervisor_apellido} ${element.supervisor_apellido}`, element.horario_id, element.estado])
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
                { title: "Fecha" },
                { title: "Asignatura" },
                { title: "Docente" },
                { title: "Salon Número" },
                { title: "Supervisor (id)" },
                { title: "Horario (id)" },
                { title: "Estado" },
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



