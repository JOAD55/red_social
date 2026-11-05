var txtCorreo = document.getElementById("txtCorreo");
var txtContrasena = document.getElementById("txtContrasena");

function consultar() {
    try {
        const usuario = {
            correo: txtCorreo.value,
            contrasena: txtContrasena.value
        }

        const opciones = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(usuario)
        }

        fetch("http://localhost:81/usuario", opciones)
            .then(data => {
                if (data.ok) {
                    alert("Usuario Registrado");
                }
                else {
                    alert("Error al registrar usuario");
                }
            })
            .catch(() => alert("No se pudo conectar con el servidor"));
    } catch (error) {
        alert(error);
    }

}