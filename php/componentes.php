<?php
session_start();
include "../include/html.php";
include "../include/ordenCompo.php"
?>

<body>
    <?php include '../include/cabeza.php'; ?>
    <main class="container-fluid" data-bs-theme="dark">
        <div class="nav-item dropdown text-center">
            <button class="dropdown-toggle btn text-light" href="juegos.php" data-bs-toggle="dropdown"
                aria-expanded="false">Ordenar por: </button>
            <ul class="dropdown-menu">
                <?php
                if (isset($_GET["familia"])) {
                    ?>
                    <li><a class="dropdown-item" href="componentes.php?filtro=nombreA&familia=<?php echo $familia ?>">Nombre
                            (a-z)</a></li>
                    <li><a class="dropdown-item" href="componentes.php?filtro=nombreZ&familia=<?php echo $familia ?>">Nombre
                            (z-a)</a></li>
                    <li><a class="dropdown-item" href="componentes.php?filtro=menor&familia=<?php echo $familia ?>">Precio
                            (menor a mayor)</a></li>
                    <li><a class="dropdown-item" href="componentes.php?filtro=mayor&familia=<?php echo $familia ?>">Precio
                            (mayor a menor)</a></li>
                    <?php
                } else {
                    ?>
                    <li><a class="dropdown-item" href="componentes.php?filtro=nombreA">Nombre (a-z)</a></li>
                    <li><a class="dropdown-item" href="componentes.php?filtro=nombreZ">Nombre (z-a)</a></li>
                    <li><a class="dropdown-item" href="componentes.php?filtro=menor">Precio (menor a mayor)</a></li>
                    <li><a class="dropdown-item" href="componentes.php?filtro=mayor">Precio (mayor a menor)</a></li>
                    <?php
                }
                ?>

            </ul>
            <button class="btn dropdown-toggle text-light" href="juegos.php" data-bs-toggle="dropdown"
                aria-expanded="false">Filtrar familia: </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="componentes.php">Todas</a></li>
                <li><a class="dropdown-item" href="componentes.php?familia=GPU">GPU</a></li>
                <li><a class="dropdown-item" href="componentes.php?familia=CPU">CPU</a></li>
                <li><a class="dropdown-item" href="componentes.php?familia=Alimentacion">Alimentacion</a></li>
                <li><a class="dropdown-item" href="componentes.php?familia=Almacenamiento">Almacenamiento</a></li>
                <li><a class="dropdown-item" href="componentes.php?familia=RAM">RAM</a></li>
                <li><a class="dropdown-item" href="componentes.php?familia=Mando">Mando</a></li>
                <li><a class="dropdown-item" href="componentes.php?familia=Teclado">Teclado</a></li>
                <li><a class="dropdown-item" href="componentes.php?familia=eaton">Raton</a></li>
            </ul>

        </div>
        <section class="row justify-content-center">
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
                        <p class="card-text">Precio: <?php echo $row["precio"] ?></p>
                        <p class="card-text">Familia: <?php echo $row["tipo"] ?></p>
                    </div>
                </span>
                <?php
            }
            ?>
        </section>
        <?php include "../include/pie.php" ?>
    </main>
</body>

</html>