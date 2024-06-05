<?php
session_start();
if (isset($_GET["tipo"])) {
    $mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
    if (!isset($_SESSION["id"]) or !isset($_GET["id"])) {
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
    $tipo = $_GET["tipo"];
    $id = $_GET["id"];
    $usu = $cliente["id"];
    if (!is_numeric($_POST["cant"]) or $_POST["cant"] < 1) {
        $cantidad = 1;
    } else {
        $cantidad = $_POST["cant"];
    }
    switch ($tipo) {
        case 'juegos':
            if (!isset($_GET["plataforma"])) {
                header("location:../php/index.php");
                exit();
            }
            $plat = $_GET["plataforma"];
            $consulta = $mysql->query("SELECT * from compra_video where id_video = '$id' AND id_usu = '$usu' AND id_plat = '$plat'");
            if ($consulta->num_rows == 0) {
                $insert = $mysql->query("INSERT into compra_video (id_video,id_plat,id_usu,cantidad) values ('$id','$plat','$usu','$cantidad')");
            } else {
                $consulta = $consulta->fetch_assoc();
                $consultaC = $mysql->query("SELECT cantidad from videojuegos where id = '$id'");
                $consultaC = $consultaC->fetch_assoc();
                if ($consulta["cantidad"] + $cantidad > $consultaC["cantidad"]) {
                    $update = $mysql->query("UPDATE compra_video set cantidad = " . $consultaC["cantidad"]);
                } else {
                    $update = $mysql->query("UPDATE compra_video set cantidad = cantidad + '$cantidad'");
                }
            }
            header("location:../php/index.php?compra=1");
            exit();
        case 'plataformas':
            $consulta = $mysql->query("SELECT * from compra_equipo where id_plat = '$id' AND id_usu = '$usu'");
            if ($consulta->num_rows == 0) {
                $insert = $mysql->query("INSERT into compra_equipo (id_plat,id_usu,cantidad) values ('$id','$usu','$cantidad')");
            } else {
                $consulta = $consulta->fetch_assoc();
                $consultaC = $mysql->query("SELECT cantidad from plataformas where id = '$id'");
                $consultaC = $consultaC->fetch_assoc();
                if ($consulta["cantidad"] + $cantidad > $consultaC["cantidad"]) {
                    $update = $mysql->query("UPDATE compra_equipo set cantidad = " . $consultaC["cantidad"]);
                } else {
                    $update = $mysql->query("UPDATE compra_equipo set cantidad = cantidad + '$cantidad'");
                }
            }
            header("location:../php/index.php?compra=1");
            exit();
        case 'componentes':
            $consulta = $mysql->query("SELECT * from compra_compo where id_compo = '$id' AND id_usu = '$usu'");
            if ($consulta->num_rows == 0) {
                $insert = $mysql->query("INSERT into compra_compo (id_compo,id_usu,cantidad) values ('$id','$usu','$cantidad')");
            } else {
                $consulta = $consulta->fetch_assoc();
                $consultaC = $mysql->query("SELECT cantidad from componentes where id = '$id'");
                $consultaC = $consultaC->fetch_assoc();
                if ($consulta["cantidad"] + $cantidad > $consultaC["cantidad"]) {
                    $update = $mysql->query("UPDATE compra_compo set cantidad = " . $consultaC["cantidad"]);
                } else {
                    $update = $mysql->query("UPDATE compra_compo set cantidad = cantidad + '$cantidad'");
                }
            }
            header("location:../php/index.php?compra=1");
            exit();
    }
}
header("location:../php/index.php");
exit();