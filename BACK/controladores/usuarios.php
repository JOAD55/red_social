<?php
require_once '../modelos/usuarios.php';

$usuario = new Usuario();

$request = $_SERVER["REQUEST_METHOD"];

switch ($request) {
    case 'GET':
        
        break;
    case 'POST':
        $datos = json_decode(file_get_contents("php://input"));
        $usuario->nombre = trim($datos->nombre);
        $usuario->correo = trim($datos->correo);
        $usuario->contrasena = trim($datos->contrasena);
        $usuario->guardar();
        break;
    case 'PUT':
        
        break;
    case 'DELETE':
        
        break;
}
?>
