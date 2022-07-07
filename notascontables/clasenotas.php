<?php
class notascontables
{

    public function obtenerdatoscuenta($cuenta)
    {
        include('../conexion/conexion.php');
        $consultadatos = "select * from         ";
        $query = mysqli_query($link, $consultadatos) or die($consultadatos);
        $ver = mysqli_fetch_row($query);
        if (isset($ver1)) {
            $fecha = $ver1[1];
            $dias = $ver1[2];
            $debe = $ver1[4];
            $ruta = $ver1[5];
            $diasprestamo = $ver1[6];
            $valorultimo = $ver1[0];
            $mod_date = strtotime($fecha . "+" . $dias . " days");
            $fechavence = date("Y-m-d", $mod_date);
            if ($ver1[4] > 0) {
                $activo = 'Si';
            } else {
                $activo = 'No';
            }
        } else {
            $fecha = 0;
            $dias = 0;
            $debe = 0;
            $fechavence = 0;
            $ruta = 0;
            $diasprestamo = 0;
            $valorultimo = 0;
            $activo = 'No';
        }
        $datos = array(
            'nombre' => $ver[0],
            'nota' => $ver[4],
            'prestamos' => $activo,
            'valorultimo' => $valorultimo,
            'fecha' => $fecha,
            'dias' => $dias,
            'debe' => $debe,
            'cierre' => $fechavence,
            'ruta' => $ruta,
            'diasprestamo' => $diasprestamo,
            'telefono' =>  $ver[2],
            'direccion' =>  $ver[3],
        );
        return $datos;
    }
}
