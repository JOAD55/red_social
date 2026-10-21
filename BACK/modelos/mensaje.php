<?php
// revisar el nombre del archivo que coincida
include_once '../librerias/bd.php';

// configurar la zona horaria para el registro de mensajes (se puede descomentar)
// date_default_timezone_set("America/Mexico_City");

class Mensaje
{
    public $id;
    public $texto;
    public $fecha_hora;
    public $remitente;
    public $destinatario;

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

        $this->fecha_hora = date("Y-m-d H:i:s");
        $this->instruccion = "INSERT INTO mensaje (texto, fecha_hora, remitente, destinatario)
            VALUES ('$this->texto', '$this->fecha_hora', '$this->remitente', '$this->destinatario')";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
        return $this->resultado;
    }

    public function actualizar()
    {
        $this->instruccion = "UPDATE usuarios
                                SET texto = '$this->texto',
                                    remitente = '$this->remitente',
                                    destinatario = '$this->destinatario'
                                WHERE id = $this->id";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
        return $this->resultado;
    }

    public function buscar(int $usuarioId)
    {
        $this->instruccion = "SELECT *
                                FROM mensaje
                                WHERE id = $usuarioId";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
        return $this->resultado;
    }

    public function listar()
    {
        $this->instruccion = "SELECT *
                                FROM mensaje";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
        return $this->resultado;
    }

    public function borrar(int $usuarioId)
    {
        $this->instruccion = "DELETE FROM mensaje
                                WHERE id = $usuarioId";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
        return $this->resultado;
    }
}
?>