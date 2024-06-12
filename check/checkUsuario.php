<?php
session_start();
if (!isset($_GET["tipo"])) {
    header("location:../php/index.php");
    exit();
}
if (isset($_POST["name"]) and isset($_POST["email"]) and isset($_POST["type"])) {
    $email = addslashes($_POST["email"]);
    $type = $_POST["type"];
    $user = $_POST["name"];
}
$mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
$tipo = $_GET["tipo"];
if ($tipo == "new") {
    if (!isset($_POST["pass"])) {
        header("location:../php/index.php");
        exit();
    }
    $pass = sha1($_POST["pass"]);
    if ($email == "" or $pass == "") {
        header("location:../php/newUser.php?fallo=2");
        exit();
    }
    $log = $mysql->query("SELECT * FROM usuarios WHERE email = '$email' AND pass = '$pass'");
    if ($log->num_rows != 0) {
        header("location:../php/newUser.php?fallo=1");
        exit();
    } else {
        $insert = $mysql->query("INSERT INTO usuarios (nombre,email,pass,tipo) values ('$user','$email','$pass','$type')");
        header("location:../php/usuarios.php");
        exit();
    }
} else if ($tipo == 'update') {
    if (!isset($_GET["id"])) {
        header("location:../php/index.php");
        exit();
    } else {
        $update = $mysql->query("UPDATE usuarios set nombre = '$user', email = '$email', tipo = '$type' where id = " . $_GET["id"]);
        header("location:../php/usuarios.php");
        exit();
    }
} else if ($tipo == 'delete') {
    if (!isset($_GET["id"])) {
        header("location:../php/index.php");
        exit();
    } else {
        $delete = $mysql->query("DELETE from usuarios where id = " . $_GET["id"]);
        header("location:../php/usuarios.php");
        exit();
    }

} else {
    header("location:../php/index.php");
    exit();
}
