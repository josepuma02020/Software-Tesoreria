<?php
class usuarios
{

    public function obtenerdatosusuario($id)
    {
        include('../conexion/conexion.php');
        $consultadatos = "select a.*,b.proceso from usuarios a inner join procesos b on a.idproceso=b.idproceso where idusuario = $id";
        $query = mysqli_query($link, $consultadatos) or die($consultadatos);
        $ver = mysqli_fetch_row($query);
        switch ($ver[5]) {
            case 1:
                $rol = 'Administrador';
                break;
            case 2:
                $rol = 'Verificador';
                break;
            case 3:
                $rol = 'Registrador';
                break;
            case 5:
                $rol = 'Aprobador';
                break;
            case 4:
                $rol = 'Inactivo';
                break;
        }
        $datos = array(
            'id' => $id,
            'nombre' => $ver[1],
            'ultconexion' => $ver[7],
            'usuario' => $ver[3],
            'Rol' => $rol,
            'Correo' => $ver[2],
            'proceso' => $ver[9],
        );
        return $datos;
    }
}
