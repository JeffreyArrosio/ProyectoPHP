<?php
session_start();
if (!isset($_SESSION["id"])) {
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
// $usuario = $mysql->query("SELECT * from usuarios where id =" . $_GET["id"]);
// if ($usuario->num_rows == 0) {
//     header("location:index.php");
//     exit();
// }
include "../include/html.php";
?>

<body>
    <main class="container">
        <h2 class="display-3 text-center">Añadir nuevo usuario</h2>
        <form class="mb-5" action="../check/checkUsuario.php?tipo=new" method="post">
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="type" class="form-label">Tipo:</label>
                <select class="form-select" id="type" name="type">
                    <option>Empleado</option>
                    <option>Cliente</option>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="mail" class="form-label">Correo</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="pass" class="form-label">Contraseña</label>
                <input type="text" class="form-control" id="pass" name="pass" required>
            </div>
            <button type="submit" class="btn btn-success mt-5">Submit</button>
        </form>
        <p><a class="btn btn-success" href="usuarios.php">Volver</a></p>

        <?php
        if (isset($_GET["fallo"])) {
            if ($_GET["fallo"] == 1) {
                ?>
                <div class="alert alert-danger alert-dismissible mt-3">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    No se puede crear una cuenta con un correo ya usado
                </div>
                <?php
            } elseif ($_GET["fallo"] == 2) {
                ?>
                <div class="alert alert-danger alert-dismissible mt-3">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    Los campos deben estar rellenados
                </div>
                <?php
            }
        }
        ?>
    </main>
    <?php include "../include/pie.php" ?>
</body>

</html>
<!-- ../check/checkAdd.php?tipo=juegos -->