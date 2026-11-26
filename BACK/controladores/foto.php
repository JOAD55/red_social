<?php
// el try - catch es para atrapar algun error al
// momento de ejecutar una instruccion
try {
    // revisar el nombre del archivo que coincida
    require_once "../modelos/foto.php";

    $foto = new Foto();

    $request = $_SERVER["REQUEST_METHOD"];

    switch ($request) {
        case "GET":
            // revisar el numero de $uri[] como ejemplo en el archivo /rutas/rutas.php
            if ($uri[2] != null) {
                $fotoId = $uri[2];
                $datos = $foto->buscar($fotoId);
                $resultado = mysqli_fetch_assoc($datos); // assoc separa los campos del objeto
                $respuesta["datos"] = [
                    "id" => $resultado["id"],
                    "correo" => $resultado["correo"],
                    "foto" => $resultado["foto"],
                    "descripcion" => $resultado["descripcion"],
                    "fecha_hora" => $resultado["fecha_hora"],
                ];

                http_response_code(200);
                echo json_encode($respuesta);
            } else {
                $datos = $foto->listar();
                $respuesta = ["datos" => []];
                while ($resultado = mysqli_fetch_assoc($datos)) {
                    $respuesta["datos"] = [
                        "id" => $resultado["id"],
                        "correo" => $resultado["correo"],
                        "foto" => $resultado["foto"],
                        "descripcion" => $resultado["descripcion"],
                        "fecha_hora" => $resultado["fecha_hora"],
                    ];
                }

                http_response_code(200);
                echo json_encode($respuesta);
            }
            break;
        case "POST":
            $datos = json_decode(file_get_contents("php://input"));

            if (
                empty($datos->texto) ||
                empty($datos->remitente) ||
                empty($datos->destinatario)
            ) {
                http_response_code(400);
                echo json_encode([
                    "mensaje" => "todos los campos son obligatorios",
                ]);
                break;
            }

            $foto->correo = trim($datos->correo);
            $foto->foto = trim($datos->foto);
            $foto->descripcion = trim($datos->descripcion);

            if ($foto->guardar()) {
                http_response_code(201);
                echo json_encode(["mensaje" => "Foto subida con exito"]);
            } else {
                http_response_code(400);
                echo json_encode(["mensaje" => "No se pudo subir la foto"]);
            }
            break;
        case "PUT":
            $datos = json_decode(file_get_contents("php://input"));

            if (
                empty($datos->id) ||
                empty($datos->texto) ||
                empty($datos->remitente) ||
                empty($datos->destinatario)
            ) {
                http_response_code(400);
                echo json_encode([
                    "mensaje" => "todos los campos son obligatorios",
                ]);
                break;
            }

            $foto->id = $datos->id;
            $foto->correo = trim($datos->correo);
            $foto->foto = trim($datos->foto);
            $foto->descripcion = trim($datos->descripcion);

            if ($foto->actualizar()) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
            break;
        case "DELETE":
            if ($uri[2] == null) {
                http_response_code(400);
                echo json_encode(["mensaje" => "el id es obligatorio"]);
                break;
            }
            // revisar el numero de $uri[] como ejemplo en el archivo /rutas/rutas.php
            $fotoId = $uri[2];
            $resultado = $foto->borrar($fotoId);

            http_response_code(200);
            echo json_encode(["mensaje" => "Foto borrada exitosamente"]);
            break;
    }
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(["Error" => $error->getMessage()]);
}
?>
