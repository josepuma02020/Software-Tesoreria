<?php
class usuarios
{

    public function obtenerdatosusuario($id)
    {
        include('../conexion/conexion.php');
        $consultadatos = "select a.*,b.proceso from usuarios a inner join procesos b on a.idproceso=b.idproceso where idusuario = $id";
        $query = mysqli_query($link, $consultadatos) or die($consultadatos);
        $ver = mysqli_fetch_row($query);
        $datos = array(
            'id' => $id,
            'nombre' => $ver[1],
            'ultconexion' => $ver[7],
            'usuario' => $ver[3],
            'Correo' => $ver[2],
            'proceso' => $ver[14],
            'creacion' => $ver[9],
            'verificacion' => $ver[10],
            'aprobacion' => $ver[11],
            'autorizacion' => $ver[12],
            'configuracion' => $ver[13],
        );
        return $datos;
    }
}
