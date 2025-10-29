<?php

class Titular extends Conexion
{
    //Atributos
    public $id, $tipo, $nombre, $email, $telefono, $fecha_inicio, $cuit, $celular, $web, $calle, $numero, $piso, $localidad, $provincia, $cod_postal, $observaciones, $estado, $fecha_creacion, $fecha_actualizacion;

    public function crear()
    {

        $this->conectar();
        $preparacion = mysqli_prepare($this->conexion, "INSERT INTO titulares (tipo, nombre, email, telefono, fecha_inicio, cuit, celular, web, calle, numero, piso, localidad, provincia, cod_postal, observaciones, estado) VALUES (?, ?, ?, ?, ?, ? ,
    , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $preparacion->bind_param(
            "sssssssssssssssi",
            $this->tipo,
            $this->nombre,
            $this->email,
            $this->telefono,
            $this->fecha_inicio,
            $this->cuit,
            $this->celular,
            $this->web,
            $this->calle,
            $this->numero,
            $this->piso,
            $this->localidad,
            $this->provincia,
            $this->cod_postal,
            $this->observaciones,
            $this->estado
        );
        $preparacion->execute();

        // echo "Cliente creado exitosamente.<br>";
    }

    public function actualizar()
    {
        $this->conectar();
        $preparacion = mysqli_prepare($this->conexion, "UPDATE Titular SET tipo=?, nombre=?, email=?, telefono=?, fecha_inicio=?, cuit=?, celular=?, web=?, calle=?, numero=?, piso=?, localidad=?, provincia=?, cod_postal=?, observaciones=?, estado=? WHERE id=?");
        $preparacion->bind_param(
            "sssssssssssssssii",
            $this->tipo,
            $this->nombre,
            $this->email,
            $this->telefono,
            $this->fecha_inicio,
            $this->cuit,
            $this->celular,
            $this->web,
            $this->calle,
            $this->numero,
            $this->piso,
            $this->localidad,
            $this->provincia,
            $this->cod_postal,
            $this->observaciones,
            $this->estado,
            $this->id
        );
        $preparacion->execute();
    }

    public function eliminar()
    {
        $this->conectar();
        $pre = mysqli_prepare($this->conexion, "DELETE FROM Titutlar WHERE id = ?");
        $pre->bind_param("i", $this->id);
        $pre->execute();
    }
};
