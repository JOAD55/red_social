var txtEmail = document.getElementById("txtEmail");
var txtMensaje = document.getElementById("txtMensaje");

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
        } else {
          alert("Error al enviar mensaje");
        }
      })
      .catch(() => alert("No se pudo conectar con el servidor"));
  } catch (error) {
    alert(error);
  }
}
