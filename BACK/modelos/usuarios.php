<?php
// revisar el nombre del archivo que coincida
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

    // -- VERIFICAR EL NOMBRE DE TU TABLA EN MYSQL --

    public function guardar()
    {
        if (!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Correo inválido');
        }

        $cifrada = password_hash($this->contrasena, PASSWORD_DEFAULT);
        $this->instruccion = "INSERT INTO usuarios (nombre, correo, contrasena)
            VALUES ('$this->nombre', '$this->correo', '$cifrada')";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
        return $this->resultado;
    }

    public function actualizar()
    {
        if (!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Correo invalido');
        }
        $cifrada = password_hash($this->contrasena, PASSWORD_DEFAULT);
        $this->instruccion = "UPDATE usuarios
                                SET nombre = '$this->nombre',
                                    correo = '$this->correo',
                                    contrasena = '$cifrada'
                                WHERE id = $this->id";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
        return $this->resultado;
    }

    public function buscar(int $usuarioId)
    {
        $this->instruccion = "SELECT *
                                FROM usuarios
                                WHERE id = $usuarioId";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
        return $this->resultado;
    }
}
?>