<?php
if (isset($_GET["tipo"])) {
    $mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
    $tipo = $_GET["tipo"];
    $id = $_GET["id"];
    switch ($tipo) {
        case 'juegos':
            if ($_POST["cant"] == "") {
                $cant = 0;
            } else {
                $cant = $_POST["cant"];
            }
            $name = $_POST["name"];
            $img = $_POST["img"];
            $insert = $mysql->query("UPDATE videojuegos set titulo = '$name',cantidad= '$cant',portada='$img' where id = '$id'");
            if (isset($_POST["consolas"])) {
                $consolas = $_POST["consolas"];
                $in = "";
                foreach ($consolas as $maquina) {
                    $in .= $maquina . ",";
                }
                $in = substr($in, 0, -1);
                $delete = $mysql->query("DELETE from tiene where id_plat not in($in) AND id_video = '$id'");
                foreach ($consolas as $maquina) {
                    $select = $mysql->query("SELECT * from tiene where id_video = '$id' AND id_plat = '$maquina'");
                    if ($select->num_rows == 0) {
                        $insertT = $mysql->query("INSERT INTO tiene (id_video,id_plat) values('$id','$maquina')");
                    }
                }
            }
            header("location:../php/modificar.php?tipo=juegos&exito=juegos&id=" . $id);
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
            $insert = $mysql->query("UPDATE plataformas set nombre = '$name',cantidad= '$cant',precio = '$price',imagen='$img' where id = '$id'");
            header("location:../php/modificar.php?tipo=plataformas&exito=plataformas&id=" . $id);
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

            $insert = $mysql->query("UPDATE componentes set nombre = '$name',tipo = '$type', cantidad= '$cant',precio = '$price',imagen='$img' where id = '$id'");
            header("location:../php/modificar.php?tipo=componentes&exito=componentes&id=" . $id);
            exit();
    }
}
header("location:index.php");
exit();