const form = document.getElementById("login-form")
const email = document.getElementById("email")
const password = document.getElementById("password")
const showpass = document.getElementById("showpassword")

const URL_BASE = 'http://localhost:5000/api'
const URL_BASE_SERVER = "http://localhost/supervisor_module"
const URL_SESSION = `${URL_BASE_SERVER}/config/session.php?access_token=`


form.addEventListener("submit", (e) => {
    e.preventDefault()
    if (email.value == '' || email.value == undefined){
        alert("No puedes dejar el espacio del correo en blanco")
    }else if (password.value == '' || password.value == undefined){
        alert("No puedes dejar el espacio de la contraseña en blanco")
    }else {
        fetch(`${URL_BASE}/login`, {
            method: "POST",
            body: JSON.stringify({
                "correo": email.value,
                "contrasena": password.value,
                "rol": "director"
            }),
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(response => {
            if (response.status == "error"){
                alert(response.message)
    
            }else{
                
                fetch(`${URL_SESSION}${response.access_token}`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json"
                    }
                })

                window.location.href = `${URL_BASE_SERVER}/public/dashboard`
            }
        })
    }
})

showpass.addEventListener("click", (e) => {
    if (showpass.checked == true){
        password.setAttribute("type", "text")
    }else {
        password.setAttribute("type", "password")
    }
})
