<?php
session_start();
$mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
if (!isset($_SESSION["id"]) and !isset($_GET["tipo"]) and !isset($_GET["id"])) {
    header("location:index.php");
    exit();
} else {
    $usuario = $mysql->query("SELECT * from usuarios where id = " . $_SESSION["id"]);
    $admin = $usuario->fetch_assoc();
    if ($admin["tipo"] != "admin") {
        header("location:index.php");
        exit();
    }
}
$tipo = $_GET["tipo"];
$id = $_GET["id"];
$plataforma = $mysql->query("SELECT * from plataformas");
if ($tipo == "juegos") {
    $juegos = $mysql->query("SELECT * from videojuegos where id = '$id'");
    $registro = $juegos->fetch_assoc();
} else if ($tipo == "plataformas") {
    $plat = $mysql->query("SELECT * from plataformas where id = '$id'");
    $registro = $plat->fetch_assoc();
} else if ($tipo == "componentes") {
    $compo = $mysql->query("SELECT * from componentes where id = '$id'");
    $registro = $compo->fetch_assoc();
} else {
    header("location:index.php");
    exit();
}
include "../include/html.php";
?>

<body>
    <?php include '../include/cabeza.php'; ?>
    <main class="container text-center">
        <h1 class="display-1 mb-3">¿Estás seguro de borrar el siguiente elemento: <?php 
        if($tipo== "juegos"){
            echo $registro["titulo"];
        }else{
            echo $registro["nombre"];
        }
        ?>?</h1>
        <div class="d-flex justify-content-evenly mb-5">
            <a href="../check/checkDel.php?tipo=<?php echo $tipo?>&id=<?php echo $id?>"><button class="btn btn-success btn-lg">Si</button></a>
            <a href="admin.php"><button class="btn btn-danger btn-lg">No</button></a>
        </div>
    </main>
    <?php include "../include/pie.php" ?>  
</body>


</html>