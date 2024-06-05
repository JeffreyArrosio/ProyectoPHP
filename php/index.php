<?php
    session_start();
    include "../include/html.php";
?>

<?php
$mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
$juegos = $mysql->query("SELECT * FROM videojuegos");
$plat = $mysql->query("SELECT * FROM plataformas");
$compo = $mysql->query("SELECT * FROM componentes");
?>
<body>
    <?php include '../include/cabeza.php';?>
    <?php
        if(isset($_GET["compra"])){
            ?>
            <div class="alert alert-success alert-dismissible mt-5">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Producto añadido al carrito</strong>
            </div>
            <?php
        }
    ?>
    <main class="container-fluid">
        <section class="row justify-content-center">
            <h2 class="display-5 text-center">Videojuegos</h2>
            <div class="container carrusel">
                <?php
                $temp = 0;
                while ($row = $juegos->fetch_assoc() and $temp < 4) {
                    $temp++;
                    if ($temp == 1) {
                        ?>
                        <a href="vista.php?tipo=juegos&id=<?php echo $row["id"] ?>"><img class="rounded-start-4" src="<?php echo $row["portada"] ?>" alt="<?php echo $row < ["titulo"] ?>"></a>
                        <?php
                    } elseif ($temp == 4) {
                        ?>
                        <a href="vista.php?tipo=juegos&id=<?php echo $row["id"] ?>"><img class="rounded-end-4" src="<?php echo $row["portada"] ?>" alt="<?php echo $row < ["titulo"] ?>"></a>
                        <?php
                    } else {
                        ?>
                        <a href="vista.php?tipo=juegos&id=<?php echo $row["id"] ?>"><img class="rounded-0" src="<?php echo $row["portada"] ?>" alt="<?php echo $row < ["titulo"] ?>"></a>
                        <?php
                    }
                    ?>
                    <?php
                }
                ?>
            </div>
        </section>
        <section class="row justify-content-center">
            <h2 class="display-5 text-center">Plataformas</h2>
            <div class="container carrusel">
                <?php
                $temp = 0;
                while ($row = $plat->fetch_assoc() and $temp < 4) {
                    $temp++;
                    if ($temp == 1) {
                        ?>
                        <a href="vista.php?tipo=consolas&id=<?php echo $row["id"] ?>"><img class="rounded-start-4" src="<?php echo $row["imagen"] ?>" alt="<?php echo $row < ["nombre"] ?>"></a>
                        <?php
                    } elseif ($temp == 4) {
                        ?>
                        <a href="vista.php?tipo=consolas&id=<?php echo $row["id"] ?>"><img class="rounded-end-4" src="<?php echo $row["imagen"] ?>" alt="<?php echo $row < ["nombre"] ?>"></a>
                        <?php
                    } else {
                        ?>
                        <a href="vista.php?tipo=consolas&id=<?php echo $row["id"] ?>"><img class="rounded-0" src="<?php echo $row["imagen"] ?>" alt="<?php echo $row < ["nombre"] ?>"></a>
                        <?php
                    }
                    ?>
                    <?php
                }
                ?>
            </div>
        </section>
        <section class="row justify-content-center">
            <h2 class="display-5 text-center">Componentes</h2>
            <div class="container carrusel">
                <?php
                $temp = 0;
                while ($row = $compo->fetch_assoc() and $temp < 4) {
                    $temp++;
                    if ($temp == 1) {
                        ?>
                        <a href="vista.php?tipo=componentes&id=<?php echo $row["id"] ?>"><img class="rounded-start-4" src="<?php echo $row["imagen"] ?>" alt="<?php echo $row < ["nombre"] ?>"></a>
                        <?php
                    } elseif ($temp == 4) {
                        ?>
                        <a href="vista.php?tipo=componentes&id=<?php echo $row["id"] ?>"><img class="rounded-end-4" src="<?php echo $row["imagen"] ?>" alt="<?php echo $row < ["nombre"] ?>"></a>
                        <?php
                    } else {
                        ?>
                        <a href="vista.php?tipo=componentes&id=<?php echo $row["id"] ?>"><img class="rounded-0" src="<?php echo $row["imagen"] ?>" alt="<?php echo $row < ["nombre"] ?>"></a>
                        <?php
                    }
                    ?>
                    <?php
                }
                ?>
            </div>
        </section>
    </main>
    <?php include "../include/pie.php" ?>
</body>

</html>