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
$users = $mysql->query("SELECT * from usuarios");
include "../include/html.php";
?>

<body>
    <?php include '../include/cabeza.php'; ?>
    <main class=" w-75 m-auto container">
        <a class="btn btn-success mb-3" href="newUser.php">Añadir usuario</a>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th colspan="3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($registro = $users->fetch_assoc()) {
                    ?>
                    <tr>
                        <?php
                        foreach ($registro as $campo => $valor) {
                            if ($campo != "pass") {
                                ?>
                                <td><?php echo "$valor"; ?></td>
                                <?php
                            }
                        }
                        ?>
                        <?php
                        if ($registro["tipo"] != "admin") {
                            ?>
                            <td><a class="btn btn-success" href="ver.php?id=<?php echo $registro["id"] ?>">Ver</a></td>
                            <td><a class="btn btn-warning" href="modifyUser.php?id=<?php echo $registro["id"] ?>">Editar</a>
                            </td>
                            <td><a class="btn btn-danger" href="deleteUser.php?id=<?php echo $registro["id"] ?>">Borrar</a></td>
                            <?php
                        } else {
                            ?>
                            <td colspan="3"></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </main>
    <?php include "../include/pie.php" ?>
</body>

</html>
<!-- tablaCAM.php?borrar=1&id=<?php echo $registro["id"] ?> -->