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
    <main class="container">
        <?php
        switch ($tipo) {
            case 'juegos':
                ?>
                <h2 class="display-3 text-center">Modificar videojuego</h2>
                <form action="../check/checkMod.php?tipo=juegos&id=<?php echo $registro["id"] ?>" method="post">
                    <div class="nav-item dropdown">
                        <button class="dropdown-toggle btn bg-success text-light" data-bs-toggle="dropdown"
                            aria-expanded="false">Plataforma</button>
                        <ul class="dropdown-menu">
                            <?php
                            while ($rowDD = $plataforma->fetch_assoc()) {
                                ?>
                                <li class="dropdown-item">
                                <input type="checkbox" id="<?php echo $rowDD["nombre"] ?>"
                                        name="consolas[]" value="<?php echo $rowDD["id"] ?>"<?php 
                                        $consulta = $mysql->query("SELECT * from tiene where id_video =".$registro["id"]." AND id_plat=".$rowDD["id"]);
                                        if($consulta->num_rows != 0){
                                            ?> checked="checked" <?php
                                        }
                                        ?>>
                                    <label for="<?php echo $rowDD["nombre"] ?>"><?php echo $rowDD["nombre"] ?></label><br>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">Titulo</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $registro["titulo"] ?>"
                            required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="cant" class="form-label">Cantidad:</label>
                        <input type="number" class="form-control" id="cant" name="cant"
                            value="<?php echo $registro["cantidad"] ?>" placeholder=0>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="img" class="form-label">Portada (URL):</label>
                        <input type="text" class="form-control" id="img" name="img" value="<?php echo $registro["portada"] ?>">
                    </div>
                    <button type="submit" class="btn btn-success mt-5">Submit</button>
                </form>
                <?php
                break;
            case 'plataformas':
                ?>
                <h2 class="display-3 text-center">Modificar plataforma</h2>
                <form class="mb-3" action="../check/checkMod.php?tipo=plataformas&id=<?php echo $registro["id"] ?>"
                    method="post">
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $registro["nombre"] ?>"
                            required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="price" class="form-label">Precio:</label>
                        <input type="text" class="form-control" id="price" name="price"
                            value="<?php echo $registro["precio"] ?>" placeholder=0>
                    </div>
                    <div class=" mb-3 mt-3">
                        <label for="cant" class="form-label">Cantidad:</label>
                        <input type="number" class="form-control" id="cant" name="cant"
                            value="<?php echo $registro["cantidad"] ?>" placeholder=0>
                    </div>
                    <div class=" mb-3 mt-3">
                        <label for="img" class="form-label">Imagen (URL):</label>
                        <input type="text" class="form-control" id="img" name="img" value="<?php echo $registro["imagen"] ?>">
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
                <?php
                break;
            case 'componentes':
                ?>
                <h2 class="display-3 text-center">Modificar componente</h2>
                <form action="../check/checkMod.php?tipo=componentes&id=<?php echo $registro["id"] ?>" method="post">
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $registro["nombre"] ?>"
                            required>
                    </div>
                    <label for=" type" class="form-label">Tipo:</label>
                    <select class="form-select" id="type" name="type">
                        <option>GPU</option>
                        <option <?php
                        if ($registro["tipo"] == "CPU") {
                            echo "selected";
                        }
                        ?>>CPU</option>
                        <option <?php
                        if ($registro["tipo"] == "Alimentacion") {
                            echo "selected";
                        }
                        ?>>Alimentacion</option>
                        <option <?php
                        if ($registro["tipo"] == "Almacenamiento") {
                            echo "selected";
                        }
                        ?>>Almacenamiento</option>
                        <option <?php
                        if ($registro["tipo"] == "RAM") {
                            echo "selected";
                        }
                        ?>>RAM</option>
                        <option <?php
                        if ($registro["tipo"] == "Mando") {
                            echo "selected";
                        }
                        ?>>Mando</option>
                        <option <?php
                        if ($registro["tipo"] == "Teclado") {
                            echo "selected";
                        }
                        ?>>Teclado</option>
                        <option <?php
                        if ($registro["tipo"] == "Raton") {
                            echo "selected";
                        }
                        ?>>Raton</option>
                    </select>
                    <div class="mb-3 mt-3">
                        <label for="price" class="form-label">Precio:</label>
                        <input type="text" class="form-control" id="price" name="price"
                            value="<?php echo $registro["precio"] ?>" placeholder=0>
                    </div>
                    <div class=" mb-3 mt-3">
                        <label for="cant" class="form-label">Cantidad:</label>
                        <input type="number" class="form-control" id="cant" name="cant"
                            value="<?php echo $registro["cantidad"] ?>" placeholder=0>
                    </div>
                    <div class=" mb-3 mt-3">
                        <label for="img" class="form-label">Imagen (URL):</label>
                        <input type="text" class="form-control" id="img" name="img" value="<?php echo $registro["imagen"] ?>">
                    </div>
                    <button type=" submit" class="btn btn-success">Submit</button>
                </form>
                <?php
                break;
        }
        if (isset($_GET["exito"])) {
            if ($_GET["exito"] == "juegos") {
                ?>
                <div class="alert alert-success alert-dismissible mt-5">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>JUEGO MODIFICADO</strong>
                </div>
                <?php
            } else if ($_GET["exito"] == "plataformas") {
                ?>
                    <div class="alert alert-success alert-dismissible mt-5">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>CONSOLA MODIFICADA</strong>
                    </div>
                <?php
            } else if ($_GET["exito"] == "componentes") {
                ?>
                        <div class="alert alert-success alert-dismissible mt-5">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <strong>COMPONENTE MODIFICADO</strong>
                        </div>
                <?php
            }

        }
        ?>
    </main>
    <?php include "../include/pie.php" ?>
</body>

</html>