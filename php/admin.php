<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location:index.php");
    exit();
} else {
    $mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
    $usuario = $mysql->query("SELECT * from usuarios where id = " . $_SESSION["id"]);
    $admin = $usuario->fetch_assoc();
    if ($admin["tipo"] == "cliente") {
        header("location:index.php");
        exit();
    }
}
include "../include/html.php";
?>

<?php
$juegos = $mysql->query("SELECT v.id as v_id, v.titulo, v.portada, v.cantidad , t.precio, p.id as p_id, p.nombre FROM videojuegos v left JOIN tiene t ON t.id_video = v.id left JOIN plataformas p ON t.id_plat = p.id GROUP BY v.id, t.precio,p.id, p.nombre");
$plat = $mysql->query("SELECT * FROM plataformas");
$compo = $mysql->query("SELECT * FROM componentes");
?>

<body>
    <?php include '../include/cabeza.php'; ?>
    <?php
    if (isset($_GET["borrar"])) {
        if ($_GET["borrar"] == "juegos") {
            ?>
            <div class="alert alert-danger alert-dismissible mt-5">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>JUEGO BORRADO</strong>
            </div>
            <?php
        } else if ($_GET["borrar"] == "plataformas") {
            ?>
                <div class="alert alert-danger alert-dismissible mt-5">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>CONSOLA BORRADO</strong>
                </div>
            <?php
        } else if ($_GET["borrar"] == "componentes") {
            ?>
                    <div class="alert alert-danger alert-dismissible mt-5">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>COMPONENTE BORRADO</strong>
                    </div>
            <?php
        }
    }
    ?>
    <main class="container-fluid">
        <section class="row justify-content-center">
            <div class="text-center mb-3 mt-3">
                <h2 class="display-5 text-center">Videojuegos</h2>
                <?php
                if ($admin["tipo"] == "admin") {
                    ?>
                    <a href="nuevo.php?tipo=juegos"><button class="btn btn-primary">+ Añadir</button></a>
                    <?php
                }
                ?>
            </div>
            <?php
            while ($row = $juegos->fetch_assoc()) {
                ?>
                <span class="card" style="width:400px">
                    <a href="compra.php?tipo=juegos&id=<?php echo $row["v_id"] ?>&plataforma=<?php echo $row["p_id"] ?>">
                        <img class="card-img-top" src="<?php if ($row["portada"] == "") {
                            echo "https://www.stargeek.es/2798-large_default/sudadera-super-mario-bros-bloque-interrogante-.jpg";
                        } else {
                            echo $row["portada"];
                        }
                        ?>" alt="" style="width:100%;height:400px">
                    </a>
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $row["titulo"] ?></h4>
                        <p class="card-text">Plataforma: <?php echo $row["nombre"] ?></p>
                        <p class="card-text">Precio: <?php echo $row["precio"] ?></p>
                        <p class="card-text">Cantidad: <?php echo $row["cantidad"] ?></p>
                        <?php
                        if ($admin["tipo"] == "admin") {
                            ?>
                            <div class="btn-group d-flex justify-content-center">
                                <a href="vista.php?tipo=juegos&id=<?php echo $row["v_id"] ?>"><button type="button"
                                        class="btn btn-success">Ver</button></a>
                                <a href="modificar.php?tipo=juegos&id=<?php echo $row["v_id"] ?>"><button type="button" class="btn btn-warning">Modificar</button></a>
                                <a href="borrar.php?tipo=juegos&id=<?php echo $row["v_id"] ?>"><button type="button"
                                        class="btn btn-danger">Borrar</button></a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </span>
                <?php
            }
            ?>
        </section>
        <section class="row justify-content-center">
            <div class="text-center mb-3 mt-3">
                <h2 class="display-5 text-center">Consolas</h2>
                <?php
                if ($admin["tipo"] == "admin") {
                    ?>
                    <a href="nuevo.php?tipo=plataformas"><button class="btn btn-primary">+ Añadir</button></a>
                    <?php
                }
                ?>
            </div>
            <?php
            while ($row = $plat->fetch_assoc()) {
                ?>
                <span class="card" style="width:400px">
                    <a href="vista.php?tipo=consolas&id=<?php echo $row["id"] ?>">
                        <img class="card-img-top" src="<?php if ($row["imagen"] == "") {
                            echo "https://www.stargeek.es/2798-large_default/sudadera-super-mario-bros-bloque-interrogante-.jpg";
                        } else {
                            echo $row["imagen"];
                        }
                        ?>" alt="" style="width:100%;height:400px">
                    </a>
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $row["nombre"] ?></h4>
                        <p class="card-text">Precio: <?php echo $row["precio"] ?></p>
                        <p class="card-text">Cantidad: <?php echo $row["cantidad"] ?></p>
                        <?php
                        if ($admin["tipo"] == "admin") {
                            ?>
                            <div class="btn-group d-flex justify-content-center">
                                <a href="vista.php?tipo=consolas&id=<?php echo $row["id"] ?>"><button type="button"
                                        class="btn btn-success">Ver</button></a>
                                <a href="modificar.php?tipo=plataformas&id=<?php echo $row["id"] ?>"><button type="button"
                                        class="btn btn-warning">Modificar</button></a>
                                <a href="borrar.php?tipo=plataformas&id=<?php echo $row["id"] ?>"><button type="button"
                                        class="btn btn-danger">Borrar</button></a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </span>
                <?php
            }
            ?>
        </section>
        <section class="row justify-content-center">
            <div class="text-center mb-3 mt-3">
                <h2 class="display-5 text-center">Componentes</h2>
                <?php
                if ($admin["tipo"] == "admin") {
                    ?>
                    <a href="nuevo.php?tipo=componentes"><button class="btn btn-primary">+ Añadir</button></a>
                    <?php
                }
                ?>
            </div>
            <?php
            while ($row = $compo->fetch_assoc()) {
                ?>
                <span class="card" style="width:400px">
                    <a href="vista.php?tipo=componentes&id=<?php echo $row["id"] ?>">
                        <img class="card-img-top" src="<?php if ($row["imagen"] == "") {
                            echo "https://www.stargeek.es/2798-large_default/sudadera-super-mario-bros-bloque-interrogante-.jpg";
                        } else {
                            echo $row["imagen"];
                        }
                        ?>" alt="" style="width:100%;height:400px">
                    </a>
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $row["nombre"] ?></h4>
                        <p class="card-text">Familia: <?php echo $row["tipo"] ?></p>
                        <p class="card-text">Precio: <?php echo $row["precio"] ?></p>
                        <p class="card-text">Cantidad: <?php echo $row["cantidad"] ?></p>
                        <?php
                        if ($admin["tipo"] == "admin") {
                            ?>
                            <div class="btn-group d-flex justify-content-center">
                                <a href="vista.php?tipo=componentes&id=<?php echo $row["id"] ?>"><button type="button"
                                        class="btn btn-success">Ver</button></a>
                                <a href="modificar.php?tipo=componentes&id=<?php echo $row["id"] ?>"><button type="button"
                                        class="btn btn-warning">Modificar</button></a>
                                <a href="borrar.php?tipo=componentes&id=<?php echo $row["id"] ?>"><button type="button"
                                        class="btn btn-danger">Borrar</button></a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </span>
                <?php
            }
            ?>
        </section>
    </main>
    <?php include "../include/pie.php" ?>
</body>

</html>