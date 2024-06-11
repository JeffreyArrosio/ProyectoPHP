<?php
session_start();
if (isset($_GET["confirmar"])) {
    $mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
    if (!isset($_SESSION["id"])) {
        header("location:../php/index.php");
        exit();
    } else {
        $usuario = $mysql->query("SELECT * from usuarios where id = " . $_SESSION["id"]);
        $cliente = $usuario->fetch_assoc();
        if ($cliente["tipo"] != "cliente") {
            header("location:../php/index.php");
            exit();
        }
    }

    if ($_GET["confirmar"] == "si") {
        $carritoV = $mysql->query("SELECT * from compra_video where id_usu =" . $_SESSION["id"]);
        $carritoP = $mysql->query("SELECT * from compra_equipo where id_usu =" . $_SESSION["id"]);
        $carritoC = $mysql->query("SELECT * from compra_compo where id_usu =" . $_SESSION["id"]);
        while ($carro = $carritoV->fetch_assoc()) {
            $update = $mysql->query("UPDATE videojuegos set cantidad = cantidad - " . $carro["cantidad"] . " WHERE id = " . $carro["id_video"]);
        }
        while ($carro = $carritoP->fetch_assoc()) {
            $update = $mysql->query("UPDATE plataformas set cantidad = cantidad - " . $carro["cantidad"] . " WHERE id = " . $carro["id_plat"]);
        }
        while ($carro = $carritoC->fetch_assoc()) {
            $update = $mysql->query("UPDATE componentes set cantidad = cantidad - " . $carro["cantidad"] . " WHERE id = " . $carro["id_compo"]);
        }
        $delV = $mysql->query("DELETE from compra_video where id_usu =" . $_SESSION["id"]);
        $delP = $mysql->query("DELETE from compra_equipo where id_usu =" . $_SESSION["id"]);
        $delC = $mysql->query("DELETE from compra_compo where id_usu =" . $_SESSION["id"]);
        header("location:../php/index.php?carrito=1");
        exit();
    } elseif ($_GET["confirmar"] == "no") {
        $delV = $mysql->query("DELETE from compra_video where id_usu =" . $_SESSION["id"]);
        $delP = $mysql->query("DELETE from compra_equipo where id_usu =" . $_SESSION["id"]);
        $delC = $mysql->query("DELETE from compra_compo where id_usu =" . $_SESSION["id"]);
    }
}
header("location:../php/index.php");
exit();

