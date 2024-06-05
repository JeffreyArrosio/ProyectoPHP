<?php
session_start();
include "../include/html.php";
?>

<?php
$mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
if (!isset($_GET["filtro"])) {
    $plat = $mysql->query("SELECT * FROM plataformas");
} elseif ($_GET["filtro"] == "nombreA") {
    $plat = $mysql->query("SELECT * FROM plataformas ORDER BY nombre");
} elseif ($_GET["filtro"] == "nombreZ") {
    $plat = $mysql->query("SELECT * FROM plataformas ORDER BY nombre DESC");
} elseif ($_GET["filtro"] == "menor") {
    $plat = $mysql->query("SELECT * FROM plataformas ORDER BY precio");
} elseif ($_GET["filtro"] == "mayor") {
    $plat = $mysql->query("SELECT * FROM plataformas ORDER BY precio DESC");
}

?>

<body>
    <?php include '../include/cabeza.php'; ?>
    <main class="container-fluid" data-bs-theme="dark">
        <div class="nav-item dropdown text-center">
            <button class="dropdown-toggle btn text-light" href="juegos.php" data-bs-toggle="dropdown"
                aria-expanded="false">Ordenar por: </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="consolas.php?filtro=nombreA">Nombre (a-z)</a></li>
                <li><a class="dropdown-item" href="consolas.php?filtro=nombreZ">Nombre (z-a)</a></li>
                <li><a class="dropdown-item" href="consolas.php?filtro=menor">Precio (menor a mayor)</a></li>
                <li><a class="dropdown-item" href="consolas.php?filtro=mayor">Precio (mayor a menor)</a></li>
            </ul>
        </div>
        <section class="row justify-content-center">
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
                    </div>
                </span>
                <?php
            }
            ?>
        </section>
        <?php include "../include/pie.php" ?>
</body>

</html>