var txtCorreo = document.getElementById("txtCorreo");
var txtContrasena = document.getElementById("txtContrasena");

function consultar() {
    try {
        const usuario = {
            correo: txtCorreo.value
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
                else {
                    alert("Usuario no encontrado");
                }
            })
            .catch(e => alert(e));
    } catch (error) {
        alert(error);
    }

}