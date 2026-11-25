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
        } else {
          alert("Error al enviar mensaje");
        }
      })
      .catch(() => alert("No se pudo conectar con el servidor"));
  } catch (error) {
    alert(error);
  }
}

let listaMensajes = [];

async function listarMensajes() {
  try {
    const opciones = {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      }
    };

    const response = await fetch("http://localhost:81/mensaje", opciones);

    if (response.ok) {
      const resultado = await response.json();
      listaMensajes = resultado.datos;

      let textoMensajes = "";

      listaMensajes.forEach((m) => {
        textoMensajes += "Remitente: " + m.remitente + "  |  Destinatario: " + m.destinatario + "  |  Mensaje: " + m.texto + "\n";
      });

      txtListaMensajes.value = textoMensajes;
    } else {
      alert("Error al listar mensajes");
    }
  } catch (error) {
    alert("No se pudo conectar con el servidor: " + error.message);
  }
}
