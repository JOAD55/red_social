var txtNombre = document.getElementById("txtNombre");
var txtCorreo = document.getElementById("txtCorreo");
var txtContrasena = document.getElementById("txtContrasena");

function registro() {
    const usuario = {
        nombre: txtNombre.value,
        correo: txtCorreo.value,
        contrasena: txtContrasena.value
    }

    const opciones = {
        method: 'POST',
        headers: {
            'Contetn-Type': 'application/json'
        },
        body: JSON.stringify(usuario)
    }

    fetch("http:localhost:81/usuario", opciones)
        .then(data => {
            if (data.ok) {
                alert("Usuario Registrado");
            }
            else{
                alert("Error al registrar usuario")
            }
        });
}