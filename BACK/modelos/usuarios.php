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

    public function __construct()
    {
        $this->conexion = Database::obtenerConexion();
    }

    public function guardar()
    {
        if (!filter_var($this->correo, FILTER_VALIDATE_EMAIL)){
            throw new InvalidArgumentException('Correo inválido');
        }

        $cifrada = password_hash($this->contrasena, PASSWORD_DEFAULT);
        $this->instruccion = "INSERT INTO usuarios (nombre, correo, contrasena)
            VALUES ('$this->nombre', '$this->correo', '$cifrada')";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
        return $this->resultado;
    }
}
?>