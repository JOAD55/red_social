<?php
include_once '../librerias/bd.php';

class usuario
{
    public $id;
    public $nombre;
    public $correo;
    public $contrasena;

    private $conexion;
    private $instruccion;
    private $resultado;
    private $arreglo_resultado;

    public function __construct()
    {
        $this->conexion = Database::obtenerConexion();
    }

    public function guardar()
    {
        $this->nombre = filter_var($this->nombre, FILTER_SANITIZE_ADD_STRING);
        $this->correo = filter_var($this->correo, FILTER_SANITIZE_ADD_STRING);

        $cifrada = password_hash($this->contrasena, PASSWORD_DEFAULT);

        $this->instruccion = "INSERT INTO usuarios (nombre, correo, contrasena)
            VALUES ('$this->nombre', '$this->correo', '$cifrada')";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
    }
}
?>