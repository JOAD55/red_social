var txtEmail = document.getElementById("txtEmail");
var tglFoto = document.getElementById("foto");
var txtDescripcion = document.getElementById("txtDescripcion");
const usuarioEmail = sessionStorage.getItem("usuarioEmail");

function enviarFoto() {
  try {
    var foto = {
      correo: txtEmail.value,
      foto: tglFoto.value,
      descripcion: txtDescripcion.value,
    };

    const opciones = {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(foto),
    };

    fetch("http://localhost:81/foto", opciones)
      .then((data) => {
        if (data.ok) {
          alert("Foto subida");
          txtEmail.value = null;
          foto.value = null;
          txtDescripcion.value = null;
        } else {
          alert("Error al subir la foto");
        }
      })
      .catch(function (error) {
        alert(error);
      });
  } catch (error) {
    alert(error);
  }
}
