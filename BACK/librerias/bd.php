<?php
include_once '../conexion.php';

class DATABASE
{
    public static function obtenerConexion()
    {
        return mysqli_connect(SERVIDOR, USUARIO, CONTRASENA, BD, PUERTO);
    }
}
?>