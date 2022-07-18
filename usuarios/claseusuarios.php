<?php
class usuarios
{

    public function obtenerdatosusuario($id)
    {

        include('../conexion/conexion.php');
        $consultadatos = "select * from usuarios where idusuario = $id";
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
        }
        $datos = array(
            'id' => $id,
            'nombre' => $ver[1],
            'ultconexion' => $ver[7],
            'usuario' => $ver[3],
            'Rol' => $rol,
            'Correo' => $ver[2],
        );
        return $datos;
    }
}
