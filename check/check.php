<?php
session_start();
if (!isset($_POST["email"]) and !isset($_POST["pass"]) and !isset($_GET["tipo"])) {
    header("location:../php/index.php");
    exit();
}
$email = $_POST["email"];
$pass = $_POST["pass"];
$tipo = $_GET["tipo"];
if ($tipo == "login") {
    if ($email == "" or $pass == "") {
        header("location:../php/login.php?fallo=2");
        exit();
    }
    $mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
    $log = $mysql->query("SELECT * FROM usuarios WHERE email = '$email' AND pass = '$pass'");
    if ($log->num_rows == 0) {
        header("location:../php/login.php?fallo=1");
        exit();
    } else {
        $_SESSION["id"] = $log->fetch_assoc()["id"];
        header("location:../php/index.php");
        exit();
    }
} else if ($tipo == 'signin') {
    $user = $_POST["usuario"];
    $mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
    $log = $mysql->query("SELECT * FROM usuarios WHERE email = '$email' AND pass = '$pass'");
    if ($log->num_rows == 0) {
        $insert = $mysql->query("INSERT INTO usuarios (nombre,email,pass,tipo) values ('$user','$email','$pass','cliente')");
        header("location:../php/exito.php");
    } else {
        header("location:../php/registro.php?fallo=1");
        exit();
    }
}
header("location:../php/index.php");
exit();

