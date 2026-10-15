<?php
require_once '../modelos/usuarios.php';

$usuario = new Usuario();

$request = $_SERVER["REQUEST_METHOD"];

// el try - catch es para atrapar algun error al
// momento de ejecutar una instruccion
try {
    switch ($request) {
        case 'GET':
            // revisar el numero de $uri[] como ejemplo en el archivo /rutas/rutas.php
            $usuarioId = $uri[2];
            $datos = $usuario->buscar($usuarioId);
            $resultado = mysqli_fetch_assoc($datos); // assoc separa los campos del objeto
            $respuesta['datos'] = array(
                "id" => $resultado['id'],
                "nombre" => $resultado['nombre'],
                "correo" => $resultado['correo'],
                "contrasena" => $resultado['contrasena']
            );

            http_response_code(200);
            echo json_encode($respuesta);
            break;
        case 'POST':
            $datos = json_decode(file_get_contents("php://input"));

            if (empty($datos->nombre) || empty($datos->correo) || empty($datos->contrasena)) {
                http_response_code(400);
                echo json_encode(["mensaje" => "todos los campos son obligatorios"]);
                break;
            }

            $usuario->nombre = trim($datos->nombre);
            $usuario->correo = trim($datos->correo);
            $usuario->contrasena = trim($datos->contrasena);

            if ($usuario->guardar()) {
                http_response_code(200);
                echo json_encode(array("mensaje" => "Usuario registrado con exito"));
            } else {
                http_response_code(400);
                echo json_encode(array("mensaje" => "No se pudo registrar el usuario"));
            }
            break;
        case 'PUT':
            $datos = json_decode(file_get_contents("php://input"));

            if (empty($datos->id) || empty($datos->nombre) || empty($datos->correo) || empty($datos->contrasena)) {
                http_response_code(400);
                echo json_encode(["mensaje" => "todos los campos son obligatorios"]);
                break;
            }

            $usuario->id = $datos->id;
            $usuario->nombre = trim($datos->nombre);
            $usuario->correo = trim($datos->correo);
            $usuario->contrasena = trim($datos->contrasena);

            if ($usuario->actualizar()) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
            break;
        case 'DELETE':

            break;
    }
} catch (Throwable $error) {
    http_response_code(400);
    echo json_encode(["Error" => $error->getMessage()]);
}
?>