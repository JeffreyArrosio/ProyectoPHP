<?php
session_start();
$mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
if (!isset($_SESSION["id"]) and !isset($_GET["tipo"])) {
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
$plataforma = $mysql->query("SELECT * from plataformas");
if ($tipo != "juegos" and $tipo != "plataformas" and $tipo != "componentes") {
    header("location:index.php");
    exit();
}
include "../include/html.php";
?>

<body>
    <?php include '../include/cabeza.php'; ?>
    <main class="container">
        <?php
        switch ($tipo) {
            case 'juegos':
                ?>
                <h2 class="display-3 text-center">Añadir videojuego</h2>
                <form action="../check/checkAdd.php?tipo=juegos" method="post">
                    <div class="nav-item dropdown">
                        <button class="dropdown-toggle btn bg-success text-light" data-bs-toggle="dropdown"
                            aria-expanded="false">Plataforma</button>
                        <ul class="dropdown-menu">
                            <?php
                            while ($rowDD = $plataforma->fetch_assoc()) {
                                ?>
                                <li class="dropdown-item">
                                    <input type="checkbox" id="<?php echo $rowDD["nombre"] ?>"
                                        name="consolas[]" value="<?php echo $rowDD["id"] ?>">
                                    <label for="<?php echo $rowDD["nombre"] ?>"><?php echo $rowDD["nombre"] ?></label><br>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">Titulo</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="cant" class="form-label">Cantidad:</label>
                        <input type="number" class="form-control" id="cant" name="cant" value=0 placeholder=0>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="img" class="form-label">Portada (URL):</label>
                        <input type="text" class="form-control" id="img" name="img">
                    </div>
                    <button type="submit" class="btn btn-success mt-5">Submit</button>
                </form>
                <?php
                break;
            case 'plataformas':
                ?>
                <h2 class="display-3 text-center">Añadir plataforma</h2>
                <form class="mb-3" action="../check/checkAdd.php?tipo=plataformas" method="post">
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="price" class="form-label">Precio:</label>
                        <input type="text" class="form-control" id="price" name="price" value=0 placeholder=0>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="cant" class="form-label">Cantidad:</label>
                        <input type="number" class="form-control" id="cant" name="cant" value=0 placeholder=0>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="img" class="form-label">Imagen (URL):</label>
                        <input type="text" class="form-control" id="img" name="img">
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
                <?php
                break;
            case 'componentes':
                ?>
                <h2 class="display-3 text-center">Añadir componente</h2>
                <form action="../check/checkAdd.php?tipo=componentes" method="post">
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <label for="type" class="form-label">Tipo:</label>
                    <select class="form-select" id="type" name="type">
                        <option>GPU</option>
                        <option>CPU</option>
                        <option>Alimentacion</option>
                        <option>Almacenamiento</option>
                        <option>RAM</option>
                        <option>Mando</option>
                        <option>Teclado</option>
                        <option>Raton</option>
                    </select>
                    <div class="mb-3 mt-3">
                        <label for="price" class="form-label">Precio:</label>
                        <input type="text" class="form-control" id="price" name="price" value=0 placeholder=0>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="cant" class="form-label">Cantidad:</label>
                        <input type="number" class="form-control" id="cant" name="cant" value=0 placeholder=0>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="img" class="form-label">Imagen (URL):</label>
                        <input type="text" class="form-control" id="img" name="img">
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
                <?php
                break;
        }
        if (isset($_GET["exito"])) {
            if ($_GET["exito"] == "juegos") {
                ?>
                <div class="alert alert-success alert-dismissible mt-5">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>JUEGO AÑADIDO</strong>
                </div>
                <?php
            } else if ($_GET["exito"] == "plataformas") {
                ?>
                    <div class="alert alert-success alert-dismissible mt-5">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>CONSOLA AÑADIDA</strong>
                    </div>
                <?php
            } else if ($_GET["exito"] == "componentes") {
                ?>
                        <div class="alert alert-success alert-dismissible mt-5">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <strong>COMPONENTE AÑADIDO</strong>
                        </div>
                <?php
            }

        }
        ?>
    </main>
    <?php include "../include/pie.php" ?>
</body>

</html>