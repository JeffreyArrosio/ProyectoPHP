<?php
session_start();
if (!isset($_SESSION["id"]) and !isset($_GET["id"])) {
    header("location:index.php");
    exit();
} else {
    $mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
    $usuario = $mysql->query("SELECT * from usuarios where id = " . $_SESSION["id"]);
    $admin = $usuario->fetch_assoc();
    if ($admin["tipo"] != "admin") {
        header("location:index.php");
        exit();
    }
}
$usuario = $mysql->query("SELECT * from usuarios where id =" . $_GET["id"]);
if ($usuario->num_rows == 0) {
    header("location:index.php");
    exit();
}
$usuario = $usuario->fetch_assoc();
include "../include/html.php";
?>

<body>
    <main class="w-75 m-auto container">
        <h1 class="display-1 mb-3">¿Estás seguro de borrar el siguiente usuario (<?php echo $usuario["tipo"]?>): <?php echo $usuario["nombre"]?>?</h1>
        <div class="d-flex justify-content-evenly mb-5">
            <a href="../check/checkUsuario.php?tipo=delete&id=<?php echo $usuario["id"]?>"><button
                    class="btn btn-success btn-lg">Si</button></a>
            <a href="usuarios.php"><button class="btn btn-danger btn-lg">No</button></a>
        </div>
    </main>
    <?php include "../include/pie.php" ?>
</body>

</html>