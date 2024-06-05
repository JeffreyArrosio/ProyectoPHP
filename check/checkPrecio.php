<?php
session_start();
$mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
if (!isset($_SESSION["id"]) or !isset($_GET["id"]) OR !isset($_GET["plataforma"])) {
    header("location:../php/index.php");
    exit();
} else {
    $usuario = $mysql->query("SELECT * from usuarios where id = " . $_SESSION["id"]);
    $admin = $usuario->fetch_assoc();
    if ($admin["tipo"] != "admin") {
        header("location:../php/index.php");
        exit();
    }
}
$plataforma = $_GET["plataforma"];
$id = $_GET["id"];
$consulta = $mysql->query("SELECT * from tiene where id_video = '$id' AND id_plat = '$plataforma'");
if($consulta->num_rows != 0){
    if ($_POST["price"] == "" OR !is_numeric($_POST["price"])) {
        $cant = 0;
    } else {
        $cant = $_POST["price"];
    }
    $update = $mysql->query("UPDATE tiene set precio = '$cant' where id_video = '$id' AND id_plat = '$plataforma'");
    header("location:../php/compra.php?tipo=juegos&id=".$id."&plataforma=".$plataforma);
    exit();
}
header("location:../php/index.php");
exit();