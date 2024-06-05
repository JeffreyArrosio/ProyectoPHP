<?php
session_start();
include "../include/html.php";
?>

<?php
$mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
$conso = $mysql->query("SELECT * FROM plataformas");
?>
<?php include "../include/ordenJuego.php" ?>

<body>
    <?php include '../include/cabeza.php'; ?>
    <main class="container-fluid" data-bs-theme="dark">
        <div class="nav-item dropdown text-center">
            <button class="dropdown-toggle btn text-light" href="juegos.php" data-bs-toggle="dropdown"
                aria-expanded="false">Ordenar por: </button>
            <ul class="dropdown-menu">
                <?php
                if (isset($_GET["plataforma"])) {
                    ?>
                    <li><a class="dropdown-item" href="juegos.php?plataforma=<?php echo $plataforma ?>&filtro=nombreA">Nombre (a-z)</a></li>
                    <li><a class="dropdown-item" href="juegos.php?plataforma=<?php echo $plataforma ?>&filtro=nombreZ">Nombre (z-a)</a></li>
                    <li><a class="dropdown-item" href="juegos.php?plataforma=<?php echo $plataforma ?>&filtro=menor">Precio (menor a mayor)</a></li>
                    <li><a class="dropdown-item" href="juegos.php?plataforma=<?php echo $plataforma ?>&filtro=mayor">Precio (mayor a menor)</a></li>
                    <?php
                } else {
                    ?>
                    <li><a class="dropdown-item" href="juegos.php?filtro=nombreA">Nombre (a-z)</a></li>
                    <li><a class="dropdown-item" href="juegos.php?filtro=nombreZ">Nombre (z-a)</a></li>
                    <li><a class="dropdown-item" href="juegos.php?filtro=platA">Nombre Plataforma (z-a)</a></li>
                    <li><a class="dropdown-item" href="juegos.php?filtro=platZ">Nombre Plataforma (z-a)</a></li>
                    <li><a class="dropdown-item" href="juegos.php?filtro=menor">Precio (menor a mayor)</a></li>
                    <li><a class="dropdown-item" href="juegos.php?filtro=mayor">Precio (mayor a menor)</a></li>
                    <?php
                }
                ?>
            </ul>
            <button class="dropdown-toggle btn text-light" href="juegos.php" data-bs-toggle="dropdown"
                aria-expanded="false">Flitrar plataforma: </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="juegos.php">Todas</a></li>
                <?php
                while ($dd = $conso->fetch_assoc()) {
                    ?>
                    <li><a class="dropdown-item"
                            href="juegos.php?plataforma=<?php echo $dd["nombre"] ?>"><?php echo $dd["nombre"] ?></a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <section class="row justify-content-center">
            <?php
            if ((!isset($_GET["filtro"]) and !isset($_GET["plataforma"])) or (isset($_GET["filtro"]) and ($_GET["filtro"] == "nombreA" or $_GET["filtro"] == "nombreZ")) and !isset($_GET["plataforma"])) {
                while ($row = $juegos->fetch_assoc()) {
                    $precio = $mysql->query("SELECT precio from tiene inner join videojuegos on id_video = id where id_video =" . $row["id"]);
                    $console = $mysql->query("SELECT p.nombre from videojuegos v inner join tiene t on t.id_video = v.id inner join plataformas p on t.id_plat = p.id where t.id_video =" . $row["id"]);
                    ?>
                    <span class="card" style="width:400px">
                        <a href="vista.php?tipo=juegos&id=<?php echo $row["id"] ?>">
                            <img class="card-img-top" src="<?php if ($row["portada"] == "") {
                                echo "https://www.stargeek.es/2798-large_default/sudadera-super-mario-bros-bloque-interrogante-.jpg";
                            } else {
                                echo $row["portada"];
                            }
                            ?>" alt="" style="width:100%;height:400px">
                        </a>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $row["titulo"] ?></h4>
                            <p class="card-text">Plataforma: <?php
                            $cadena = "";
                            if ($console->num_rows == 0) {
                                echo "No disponible";
                            } else {
                                while ($rowC = $console->fetch_assoc()) {
                                    $cadena .= $rowC["nombre"] . ", ";
                                }
                                echo substr($cadena, 0, -2);
                            }
                            ?>
                            <p class="card-text">Precio: <?php
                            if ($precio->num_rows == 0) {
                                echo "No disponible";
                            } elseif ($precio->num_rows == 1) {
                                $rowP = $precio->fetch_assoc();
                                echo $rowP["precio"];
                            } else {
                                echo "Ver precios";
                            }
                            ?></p>
                            </p>
                        </div>
                    </span>
                    <?php
                }
            } else {
                while ($row = $juegos->fetch_assoc()) {
                    $precio = $mysql->query("SELECT precio from tiene inner join videojuegos on id_video = id where id_video =" . $row["v_id"]);
                    $console = $mysql->query("SELECT p.nombre from videojuegos v inner join tiene t on t.id_video = v.id inner join plataformas p on t.id_plat = p.id where t.id_video =" . $row["v_id"]);
                    ?>
                    <span class="card" style="width:400px">
                        <a href="compra.php?tipo=juegos&id=<?php echo $row["v_id"]?>&plataforma=<?php echo $row["p_id"]?>">
                            <img class="card-img-top" src="<?php if ($row["portada"] == "") {
                                echo "https://www.stargeek.es/2798-large_default/sudadera-super-mario-bros-bloque-interrogante-.jpg";
                            } else {
                                echo $row["portada"];
                            }
                            ?>" alt="" style="width:100%;height:400px">
                        </a>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $row["titulo"] ?></h4>
                            <p class="card-text">Plataforma: <?php
                            if ($console->num_rows == 0) {
                                echo "No disponible";
                            } else {
                                echo $row["nombre"];
                            }
                            ?></p>
                            <p class="card-text">Precio: <?php
                            if ($precio->num_rows == 0) {
                                echo "No disponible";
                            } else {
                                echo $row["precio"];
                            }
                            ?></p>
                        </div>
                    </span>
                    <?php
                }
            }
            ?>
        </section>
    </main>
    <?php include "../include/pie.php" ?>
</body>

</html>