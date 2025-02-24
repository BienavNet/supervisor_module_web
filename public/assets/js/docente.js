
const API_BASE_URL = "http://localhost:5000/api/docente"
const tbody = document.getElementById("tbody")
const registerForm = document.getElementById("registerForm")
const editForm = document.getElementById("editForm")
const editButtons = document.querySelectorAll('.edit')
const deleteButtons = document.querySelectorAll('.delete')



function deleteButtonClick(element) {
    const children = element.parentElement.parentElement.parentElement.children
    let cedula = parseInt(children[3].innerText)
    let confirm = prompt("Escribe la cédula del registro para confirmar la eliminación de la base de datos: ")
    if (parseInt(confirm) == cedula) {
        fetch(`${API_BASE_URL}/delete/${cedula}`, {
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
    let nombre = children[1].innerText
    let apellido = children[2].innerText
    let cedula = parseInt(children[3].innerText)
    let correo = children[4].innerText

    const edit_name = document.getElementById("edit-name")
    const edit_lname = document.getElementById("edit-lname")
    const edit_dni = document.getElementById("edit-dni")
    const edit_email = document.getElementById("edit-email")

    edit_name.value = nombre
    edit_lname.value = apellido
    edit_dni.value = cedula
    edit_email.value = correo


    editForm.addEventListener("submit", e => {
        e.preventDefault()

        if (edit_name.value == '' || edit_name.value == undefined) {
            alert("El campo nombre no puede estar vacío.")
        } else if (edit_lname.value == '' || edit_lname.value == undefined) {
            alert("El campo apellido no puede estar vacío.")
        } else if (edit_dni.value == '' || edit_dni.value == undefined) {
            alert("El campo cédula no puede estar vacío o contiene caracteres que no son números.")
        } else if (edit_email.value == '' || edit_email.value == undefined) {
            alert("El campo email no puede estar vacío.")
        } else {

            let response = confirm("Confirme la acción: Actualizar datos.")

            if (response) {
                fetch(`${API_BASE_URL}/update/${cedula}`, {
                    method: "PATCH",
                    body: JSON.stringify({
                        "nombre": edit_name.value,
                        "apellido": edit_lname.value,
                        "cedula": parseInt(edit_dni.value),
                        "correo": edit_email.value,
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
            }
        }
    })
}



registerForm.addEventListener("submit", e => {
    e.preventDefault()

    const name_input = document.getElementById("name")
    const lname_input = document.getElementById("lname")
    const dni_input = document.getElementById("dni")
    const email_input = document.getElementById("email")
    const password_input = document.getElementById("password")
    const cpassword_input = document.getElementById("cpassword")

    if (name_input.value == '' || name_input.value == undefined) {
        alert("El campo nombre no puede estar vacío.")
    } else if (lname_input.value == '' || lname_input.value == undefined) {
        alert("El campo apellido no puede estar vacío.")
    } else if (dni_input.value == '' || dni_input.value == undefined) {
        alert("El campo cédula no puede estar vacío o contiene caracteres que no son números.")
    } else if (email_input.value == '' || email_input.value == undefined) {
        alert("El campo email no puede estar vacío.")
    } else if (password_input.value == '' || password_input.value == undefined) {
        alert("El campo contraseña no puede estar vacío.")
    } else if (cpassword_input.value == '' || cpassword_input.value == undefined) {
        alert("El campo confirmar contraseña no puede estar vacío.")
    } else if (password_input.value != cpassword_input.value) {
        alert("Las contaseñas no coínciden.")
    } else {
        fetch(`${API_BASE_URL}/save`, {
            method: "POST",
            body: JSON.stringify({
                "nombre": name_input.value,
                "apellido": lname_input.value,
                "cedula": parseInt(dni_input.value),
                "correo": email_input.value,
                "contrasena": password_input.value
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

            tableData.push([element.id, element.nombre, element.apellido, element.cedula, element.correo])
        });
        // console.log(tableData)
        return tableData
    })



function main() {

    const loadingData = loadData.then(result => {
        let table = new DataTable('#myTable', {
            dom: 'Bfrtip',
            paging: true,
            columns: [
                { title: "Id" },
                { title: "Nombre" },
                { title: "Apellido" },
                { title: "Cédula" },
                { title: "Correo" },
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



