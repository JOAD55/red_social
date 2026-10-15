<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

header("Access-Control-Max-Age: 3600");

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH); // obtiene la url que se escribio en yaak
$uri = explode("/", $uri); // explode separa la url en partes como se muestra abajo

// $uri[posicion] se cambia de acuerdo con la url utilizada
// http://localhost/red_social/BACK/rutas/rutas.ph/usuario
//            0    |    1    |  2 |  3  |   4    |   5
// localhost/usuario
//     0   |    1
if ($uri[1] == "usuario") {
    include_once "../controladores/usuarios.php";
}
?>