<?php
// el try - catch es para atrapar algun error al
// momento de ejecutar una instruccion
try {

    // revisar el nombre del archivo que coincida
    require_once '../modelos/mensaje.php';

    $mensaje = new Mensaje();

    $request = $_SERVER["REQUEST_METHOD"];

    switch ($request) {
        case 'GET':
            // revisar el numero de $uri[] como ejemplo en el archivo /rutas/rutas.php
            if ($uri[2] != null) {
                $mensajeId = $uri[2];
                $datos = $mensaje->buscar($mensajeId);
                $resultado = mysqli_fetch_assoc($datos); // assoc separa los campos del objeto
                $respuesta['datos'] = array(
                    "id" => $resultado['id'],
                    "texto" => $resultado['texto'],
                    "fecha_hora" => $resultado['fecha_hora'],
                    "remitente" => $resultado['remitente'],
                    "destinatario" => $resultado['destinatario']
                );

                http_response_code(200);
                echo json_encode($respuesta);
            } else {
                $datos = $mensaje->listar();
                $respuesta = array("datos" => array());
                while ($resultado = mysqli_fetch_assoc($datos)) {
                    $respuesta['datos'][] = array(
                        "id" => $resultado['id'],
                        "texto" => $resultado['texto'],
                        "fecha_hora" => $resultado['fecha_hora'],
                        "remitente" => $resultado['remitente'],
                        "destinatario" => $resultado['destinatario']
                    );
                }

                http_response_code(200);
                echo json_encode($respuesta);
            }
            break;
        case 'POST':
            $datos = json_decode(file_get_contents("php://input"));

            if (empty($datos->texto) || empty($datos->remitente || empty($datos->destinatario))) {
                http_response_code(400);
                echo json_encode(["mensaje" => "todos los campos son obligatorios"]);
                break;
            }

            $mensaje->texto = trim($datos->texto);
            $mensaje->remitente = trim($datos->remitente);
            $mensaje->destinatario = trim($datos->destinatario);

            if ($mensaje->guardar()) {
                http_response_code(200);
                echo json_encode(array("mensaje" => "Mensaje registrado con exito"));
            } else {
                http_response_code(400);
                echo json_encode(array("mensaje" => "No se pudo registrar el mensaje"));
            }
            break;
        case 'PUT':
            $datos = json_decode(file_get_contents("php://input"));

            if (empty($datos->id) || empty($datos->texto) || empty($datos->remitente) || empty($datos->destinatario)) {
                http_response_code(400);
                echo json_encode(["mensaje" => "todos los campos son obligatorios"]);
                break;
            }

            $mensaje->id = $datos->id;
            $mensaje->texto = trim($datos->texto);
            // $mensaje->fecha_hora = trim($datos->fecha_hora);
            $mensaje->remitente = trim($datos->remitente);
            $mensaje->destinatario = trim($datos->destinatario);

            if ($mensaje->actualizar()) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
            break;
        case 'DELETE':
            if ($uri[2] == null) {
                http_response_code(400);
                echo json_encode(["mensaje" => "el id es obligatorio"]);
                break;
            }
            // revisar el numero de $uri[] como ejemplo en el archivo /rutas/rutas.php
            $mensajeId = $uri[2];
            $resultado = $mensaje->borrar($mensajeId);

            http_response_code(200);
            echo json_encode(["mensaje" => "mensaje borrado exitosamente"]);
            break;
    }
} catch (Throwable $error) {
    http_response_code(400);
    echo json_encode(["Error" => $error->getMessage()]);
}
?>