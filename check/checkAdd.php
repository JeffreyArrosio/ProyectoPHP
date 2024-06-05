<?php
if (isset($_GET["tipo"])) {
    $mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
    $tipo = $_GET["tipo"];
    switch ($tipo) {
        case 'juegos':
            if ($_POST["cant"] == "") {
                $cant = 0;
            } else {
                $cant = $_POST["cant"];
            }
            $name = $_POST["name"];
            $img = $_POST["img"];
            $insert = $mysql->query("INSERT INTO videojuegos (titulo,cantidad,portada) values ('$name','$cant','$img')");
            $consolas = $_POST["consolas"];
            foreach ($consolas as $maquina) {
                $insertT = $mysql->query("INSERT INTO tiene (id_video,id_plat) values((SELECT id from videojuegos WHERE titulo = '$name'),'$maquina')");
            }
            header("location:../php/nuevo.php?tipo=juegos&exito=juegos");
            exit();
        case 'plataformas':
            if (!is_numeric($_POST["price"]) or $_POST["price"] == "") {
                $price = 0;
            } else {
                $price = $_POST["price"];
            }
            if ($_POST["cant"] == "") {
                $cant = 0;
            } else {
                $cant = $_POST["cant"];
            }
            $name = $_POST["name"];
            $img = $_POST["img"];
            $insert = $mysql->query("INSERT INTO plataformas (nombre,cantidad,precio,imagen) values ('$name','$cant','$price','$img')");
            header("location:../php/nuevo.php?tipo=plataformas&exito=plataformas");
            exit();
        case 'componentes':
            if (!is_numeric($_POST["price"]) or $_POST["price"] == "") {
                $price = 0;
            } else {
                $price = $_POST["price"];
            }
            if ($_POST["cant"] == "") {
                $cant = 0;
            } else {
                $cant = $_POST["cant"];
            }
            $type = $_POST["type"];
            $name = $_POST["name"];
            $img = $_POST["img"];
            $insert = $mysql->query("INSERT INTO componentes (nombre,tipo,cantidad,precio,imagen) values ('$name','$type','$cant','$price','$img')");
            header("location:../php/nuevo.php?tipo=componentes&exito=componentes");
            exit();
    }
}
header("location:index.php");
exit();