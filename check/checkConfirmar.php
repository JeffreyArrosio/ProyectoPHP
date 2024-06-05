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
    if($_GET["confirmar"] == "si"){
        
    }elseif($_GET["confirmar"] == "no"){
        $delV = $mysql->query("DELETE from compra_video where id_usu =". $_SESSION["id"]);
        $delP = $mysql->query("DELETE from compra_equipo where id_usu =". $_SESSION["id"]);
        $delC = $mysql->query("DELETE from compra_compo where id_usu =". $_SESSION["id"]);
    }
}
header("location:../php/index.php");
exit();