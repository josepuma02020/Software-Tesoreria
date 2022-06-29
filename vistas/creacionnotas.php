<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/notas/desktop.css">
    <title>Notas Contables</title>
    <?php
    include('../NotasdePago/conexion/conexion.php');
    ?>
</head>

<body>
    <header>
        <form action="" method="post">
            <div class="form-row formulario">
                <div class="form-group mediano">
                    <label for="user">Usuario:</label>
                    <input class="form-control " id="user" name="user" type="text" disabled value="<?php echo $_SESSION['nombre']; ?>">
                </div>
                <div class="form-group mediano">
                    <label for="type">Tipo de Documento</label>
                    <select id="type" class="form-control col-md-8 ">
                        <?php
                        $consultausuarios = "select * from tiposdocumento order by documento";
                        $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                        ?> <option value="0"></option>
                        <?php
                        while ($filas1 = mysqli_fetch_array($query)) {
                        ?>
                            <option value="<?php echo $filas1['idtipo'] ?>"><?php echo $filas1['documento'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group mediano">
                    <label for="type">Clasificación de Documento</label>
                    <select id="type" class="form-control col-md-8 ">
                        <?php
                        $consultausuarios = "select * from clasificacionesnotas order by clasificacion";
                        $query = mysqli_query($link, $consultausuarios) or die($consultausuarios);
                        ?> <option value="0"></option>
                        <?php
                        while ($filas1 = mysqli_fetch_array($query)) {
                        ?>
                            <option value="<?php echo $filas1['idclasificacion'] ?>"><?php echo $filas1['clasificacion'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mediano">
                    <label for="batch">Batch:</label>
                    <input class="form-control " id="batch" name="batch" type="number">
                </div>
            </div>
            <div class="form-row formulario">
                <div class="form-group completo ">
                    <label for="comment">Comentario:</label>
                    <input class="form-control " id="comment" name="comment" type="text">
                </div>
            </div>
        </form>
    </header>
    <main>

    </main>
    <footer>

    </footer>
</body>

</html>