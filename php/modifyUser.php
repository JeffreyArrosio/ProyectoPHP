<?php
session_start();
if (!isset($_SESSION["id"]) AND !isset($_GET["id"])) {
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
    <main class="container">
        <h2 class="display-3 text-center">Modificar usuario</h2>
        <form class="mb-5" action="../check/checkUsuario.php?tipo=update&id=<?php echo $usuario["id"]?>" method="post">
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" required value="<?php echo $usuario["nombre"]?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="type" class="form-label">Tipo:</label>
                <select class="form-select" id="type" name="type">
                    <option>Empleado</option>
                    <option <?php 
                    if($usuario["tipo"] == "cliente"){
                        echo "selected";
                    }
                    ?>>Cliente</option>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="mail" class="form-label">Correo</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario["email"]?>">
            </div>
            <button type="submit" class="btn btn-success mt-5">Submit</button>
        </form>
        <p><a class="btn btn-success" href="usuarios.php">Volver</a></p>
    </main>
    <?php include "../include/pie.php" ?>
</body>

</html>