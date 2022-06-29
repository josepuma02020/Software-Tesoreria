<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/home/desktop.css">
    <title>Home</title>
    <?php
    session_start();
    ?>
</head>

<body>
    <header>
        <?php include($_SESSION['menu']) ?>
    </header>
    <main>
        <?php
        include('./vistas/notascontables.php');
        ?>
    </main>
</body>

</html>
<script>

</script>