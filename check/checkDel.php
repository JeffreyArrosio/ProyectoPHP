<?php
session_start();
if (isset($_GET["tipo"])) {
    $mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
    if (!isset($_SESSION["id"]) OR !isset($_GET["id"])) {
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
    $tipo = $_GET["tipo"];
    $id = $_GET["id"];
    switch ($tipo) {
        case 'juegos':
            $borrar = $mysql->query("SELECT * from videojuegos where id = '$id'");
            if ($borrar->num_rows == 0) {
                header("location:../php/index.php");
                exit();
            } else {
                $borrar = $mysql->query("DELETE from videojuegos where id = '$id'");
                header("location:../php/admin.php?&borrar=juegos");
                exit();
            }
        case 'plataformas':
            $borrar = $mysql->query("SELECT * from plataformas where id = '$id'");
            if ($borrar->num_rows == 0) {
                header("location:../php/index.php");
                exit();
            } else {
                $borrar = $mysql->query("DELETE from plataformas where id = '$id'");
                header("location:../php/admin.php?&borrar=plataformas");
                exit();
            }
        case 'componentes':
            $borrar = $mysql->query("SELECT * from componentes where id = '$id'");
            if ($borrar->num_rows == 0) {
                header("location:../php/index.php");
                exit();
            } else {
                $borrar = $mysql->query("DELETE from componentes where id = '$id'");
                header("location:../php/admin.php?&borrar=componentes");
                exit();
            }
    }
}
header("location:../php/index.php");
exit();