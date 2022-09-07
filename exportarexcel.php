<?php
include_once('conexion/conexion.php');

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
$filename = "Registroscontables(" . $desde . "->" . $hasta . ").xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<table style="text-align: center">
    <tbody>

        <tr style="font-weight:100 ;">
            <td>
                <?php
                $consultabatch = "select distinct(batch) from notascontables where  fecha between '$desde' and '$hasta' and batch >0";
                $querybatch = mysqli_query($link, $consultabatch) or die($consultabatch);
                while ($batchs = mysqli_fetch_array($querybatch)) {
                    $a = 0;
                    $consultanotas = "select * from notascontables where batch = '$batchs[batch]'";
                    $querynotas = mysqli_query($link, $consultanotas) or die($consultanotas);
                    while ($notas = mysqli_fetch_array($querynotas)) {
                        if ($a == 0) {
                ?>
        <tr style="font-weight: bolder ;">
            <td style="background-color:coral">Batch</td>
            <td style="background-color:coral">Fecha</td>
            <td style="background-color:coral">Cuenta</td>
            <td style="background-color:coral">Importe</td>
            <td style="background-color:coral">A</td>
            <td style="background-color:coral">AN8</td>
            <td style="background-color:coral">#Direccion</td>
            <td style="background-color:coral">Comentario</td>
        </tr>
    <?php
                        } else {
    ?>
        <tr style="font-weight: bolder ;">
            <td></td>
            <td>Fecha</td>
            <td>Cuenta</td>
            <td>Importe</td>
            <td>A</td>
            <td>AN8</td>
            <td>#Direccion</td>
            <td>Comentario</td>
        </tr>
    <?php
                        }
                        $consultaregistros = "select * from registrosdenota where idnota = '$notas[idnota]'";
                        $queryregistros = mysqli_query($link, $consultaregistros) or die($consultaregistros);
                        while ($registros = mysqli_fetch_array($queryregistros)) {
    ?>
        <tr>
            <td style="font-weight: bolder ;">
                <?php
                            if ($a == 0) {
                                echo $batchs['batch'];
                                $a = 1;
                ?>

                <?php
                            }
                ?>
            </td>
            <td> <?php echo $registros['fecha']; ?> </td>
            <td><?php echo $registros['idcuenta']; ?> </td>
            <td>
                <?php
                            if ($registros['debe'] > 0) {
                                echo number_format($registros['debe']);
                            } else {
                                echo "-" . number_format($registros['haber']);
                            } ?>
            </td>
            <td><?php echo $registros['tipolm']; ?> </td>
            <td><?php echo $registros['lm']; ?> </td>
            <td><?php echo $registros['an']; ?> </td>
            <td><?php echo $notas['comentario']; ?> </td>
        </tr>
    <?php   }
    ?>
    <tr>

    </tr>

<?php
                    }
?>
<?php }
?>
</td>
</tr>
    </tbody>
</table>
<?php
?>