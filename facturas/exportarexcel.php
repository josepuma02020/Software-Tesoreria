<?php
include_once('../conexion/conexion.php');

if (isset($_GET['desde'])) {
    $desde = $_GET['desde'];
} else {
    $desde = date("Y-m-01");
}
if (isset($_GET['hasta'])) {
    $hasta = $_GET['hasta'];
} else {
    $hasta = date("Y-m-d");
}
header("Pragma: public");
header("Expires: 0");
$filename = "Facturas(" . $desde . "->" . $hasta . ").xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<meta http-equiv="Content-type" content="text/html;charset=utf-8">
<table style="text-align: center">
    <THEAD>
        <tr style="font-weight: bolder ;">
            <td style="background-color:yellow">Compañia</td>
            <td style="background-color:yellow">Cuenta bancaria</td>
            <td style="background-color:yellow">AN8</td>
            <td style="background-color:yellow">Fecha pago</td>
            <td style="background-color:yellow">Importe cobro</td>
            <td style="background-color:yellow">Obs</td>
            <td style="background-color:yellow">Concepto</td>
            <td style="background-color:yellow">Cuenta</td>
        </tr>
    </THEAD>
    <TBODY>
        <?php
        $consultafacturas = "SELECT a.*,e.codclasificacion,f.tipofactura FROM `facturas` a inner join usuarios b on a.idcreador=b.idusuario inner join procesos c on c.idproceso=b.idproceso inner join equipos d on d.idequipo=c.idequipo inner join areas e on e.idarea=d.idarea inner join tiposfactura f on f.idtipo=a.idtipofactura WHERE a.idrevisador > 0 and a.subido = 'no'";
        $queryfacturas = mysqli_query($link, $consultafacturas) or die($consultafacturas);
        while ($facturas = mysqli_fetch_array($queryfacturas)) {
        ?>
            <TR style="background-color: <?php echo $color ?> ;">
                <?php
                if ($facturas['idrevisador'] > 0) {
                    $revisado = 'checked';
                } else {
                    $revisado = '';
                }
                ?>
                <TD><?php echo $facturas['codclasificacion'] ?> </TD>
                <TD><?php echo $facturas['idcuenta'] ?> </TD>
                <TD><?php echo $facturas['tercero']; ?> </TD>
                <TD><?php echo $facturas['fechafactura']; ?> </TD>
                <TD><?php echo ($facturas['valor']); ?> </TD>
                <TD><?php echo $facturas['comentario']; ?> </TD>
                <TD><?php echo $facturas['tipofactura']; ?> </TD>
                <?php
                switch ($facturas['idtipofactura']) {
                    case '2':
                        $consultacuenta = "select idcuenta from cuentas where descripcion = 'CONTRIBUCIONES'";
                        $querycuenta = mysqli_query($link, $consultacuenta) or die($consultacuenta);
                        $cuentas = mysqli_fetch_array($querycuenta);
                ?>

                        <TD><?php echo $cuentas['idcuenta']; ?> </TD>
                <?php
                        break;
                }
                ?>
            </TR>
        <?php
        }
        ?>
    </TBODY>
</table>
<?php
?>