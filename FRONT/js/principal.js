var txtEmail = document.getElementById("txtEmail");
var txtMensaje = document.getElementById("txtMensaje");
var txtListaMensajes = document.getElementById("txtListaMensajes");

function enviarMensaje() {
  try {
    const usuarioEmail = sessionStorage.getItem("usuarioEmail");
    const mensaje = {
      texto: txtMensaje.value,
      destinatario: txtEmail.value,
      remitente: usuarioEmail,
    };

    const opciones = {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(mensaje),
    };

    fetch("http://localhost:81/mensaje", opciones)
      .then((data) => {
        if (data.ok) {
          alert("Mensaje enviado");
          txtEmail.value = null;
          txtMensaje.value = null;
          leerMensajes();
        } else {
          alert("Error al enviar mensaje");
        }
      })
      .catch(() => alert("No se pudo conectar con el servidor"));
  } catch (error) {
    alert(error);
  }
}

function leerMensajes() {
  fetch("http://localhost:81/mensaje", {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then(function (datos) {
      return datos.json();
    })
    .then(function (data) {
      let mensaje = "";
      for (i = 0; i < data.datos.length; i++) {
        mensaje +=
          "Remitente: " +
          data.datos[i].remitente +
          "  |  Destinatario: " +
          data.datos[i].destinatario +
          "  |  Mensaje: " +
          data.datos[i].texto +
          "  |  Fecha y Hora: " +
          data.datos[i].fecha_hora +
          "<br><br>";
      }
      document.getElementById("mensajes").innerHTML = mensaje;
    })
    .catch(function (error) {
      alert("Ocurrio un error al leer mensajes");
      console.log(error);
    });
}

document.addEventListener("DOMContentLoaded", function () {
  leerMensajes();
});
