
<?php
// revisar el nombre del archivo que coincida
include_once "../librerias/bd.php";

// configurar la zona horaria para el registro de mensajes
// --------------------------------------------------
date_default_timezone_set("America/Mexico_City");
// --------------------------------------------------

class Foto
{
    public $id;
    public $correo;
    public $foto;
    public $descripcion;
    public $fecha_hora;

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
        $this->instruccion = "INSERT INTO fotos (correo, foto, descripcion, fecha_hora)
            VALUES ('$this->correo', '$this->foto', '$this->descripcion', '$this->fecha_hora')";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
        return $this->resultado;
    }

    public function actualizar()
    {
        $this->instruccion = "UPDATE fotos
                                SET correo = '$this->correo',
                                    foto = '$this->foto',
                                    descripcion = '$this->descripcion'
                                WHERE id = $this->id";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
        return $this->resultado;
    }

    public function buscar(int $fotoId)
    {
        $this->instruccion = "SELECT *
                                FROM fotos
                                WHERE id = $fotoId";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
        return $this->resultado;
    }

    public function listar()
    {
        $this->instruccion = "SELECT *
                                FROM fotos
                                ORDER BY fecha_hora DESC";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
        return $this->resultado;
    }

    public function borrar(int $fotoId)
    {
        $this->instruccion = "DELETE FROM fotos
                                WHERE id = $fotoId";

        $this->resultado = mysqli_query($this->conexion, $this->instruccion);
        return $this->resultado;
    }
}

?>
