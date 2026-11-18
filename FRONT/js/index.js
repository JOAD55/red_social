var txtCorreo = document.getElementById("txtCorreo");
var txtContrasena = document.getElementById("txtContrasena");

function consultar() {
    try {
        const usuario = {
            correo: txtCorreo.value,
            contrasena: txtContrasena.value
        }

        const opciones = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(usuario)
        }

        fetch("http://localhost:81/usuario/correo", opciones)
            .then(data => {
                if (data.ok) {
                    alert("Usuario Encontrado");
                }
                else if (data.status == 404) {
                    alert("Correo no existe");
                }
                else if (data.status == 401) {
                    alert("Contraseña incorrecta")
                }
            })
            .catch(e => alert(e));
    } catch (error) {
        alert(error);
    }

}