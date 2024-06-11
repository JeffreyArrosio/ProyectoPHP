<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location:index.php");
    exit();
}
$mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
$cliente = $mysql->query("SELECT * from usuarios where id =" . $_SESSION["id"]);
$cliente = $cliente->fetch_assoc();
if ($cliente["tipo"] != "cliente") {
    header("location:index.php");
    exit();
}
$carritoV = $mysql->query("SELECT * from compra_video where id_usu =" . $_SESSION["id"]);
$carritoP = $mysql->query("SELECT * from compra_equipo where id_usu =" . $_SESSION["id"]);
$carritoC = $mysql->query("SELECT * from compra_compo where id_usu =" . $_SESSION["id"]);
include "../include/html.php";
?>

<body>
    <main class="container mt-3">
        <?php
        if ($carritoV->num_rows == 0 and $carritoP->num_rows == 0 and $carritoC->num_rows == 0) {
            ?>
            <img class="img-fluid" src="../imagenes/carritoVacio.png" alt="Vacio">
            <p class="display-5 text-center">Carrito vacio</p>
            <button class="btn bnt-success"><a href="index.php">Volver al inicio</a></button>
            <?php
        } else {
            $total = 0;
            $precioT = 0;
            while ($carro = $carritoV->fetch_assoc()) {
                $vj = $mysql->query("SELECT * from videojuegos where id =" . $carro["id_video"]);
                $vprecio = $mysql->query("SELECT precio from tiene where id_video =" . $carro["id_video"] . " AND id_plat =" . $carro["id_plat"]);
                $vj = $vj->fetch_assoc();
                $vprecio = $vprecio->fetch_assoc();
                ?>
                <div class="row mb-3">
                    <img class="col-5 rounded" src="<?php echo $vj["portada"] ?>" alt="portada" width="100%" height="200px">
                    <div class="col-7 mb-3 display-6">
                        <p><?php echo $vj["titulo"] ?></p>
                        <span><?php echo $vprecio["precio"] ?>€</span>
                        <span>x <?php echo $carro["cantidad"] ?></span>
                        <p>Total: <?php
                        $tmp = $vprecio["precio"] * $carro["cantidad"];
                        echo $tmp;
                        ?>€</p>
                    </div>
                </div>
                <?php
                $total = $total + $carro["cantidad"];
                $precioT = $precioT + $tmp;
            }
            while ($carro = $carritoP->fetch_assoc()) {
                $pt = $mysql->query("SELECT * from plataformas where id =" . $carro["id_plat"]);
                $pt = $pt->fetch_assoc();
                ?>
                <div class="row mb-3">
                    <img class="col-5 rounded" src="<?php echo $pt["imagen"] ?>" alt="portada" width="100%" height="200px">
                    <div class="col-7 mb-3 display-6">
                        <p><?php echo $pt["nombre"] ?></p>
                        <span><?php echo $pt["precio"] ?>€</span>
                        <span>x <?php echo $carro["cantidad"] ?></span>
                        <p>Total: <?php
                        $tmp = $carro["cantidad"] * $pt["precio"];
                        echo $tmp ?>€</p>
                    </div>
                </div>
                <?php
                $total = $total + $carro["cantidad"];
                $precioT = $precioT + $tmp;
            }
            while ($carro = $carritoC->fetch_assoc()) {
                $cp = $mysql->query("SELECT * from componentes where id =" . $carro["id_compo"]);
                $cp = $cp->fetch_assoc();
                ?>
                <div class="row mb-3">
                    <img class="col-5 rounded" src="<?php echo $cp["imagen"] ?>" alt="portada" width="100%" height="200px">
                    <div class="col-7 mb-3">
                        <p><?php echo $cp["nombre"] ?></p>
                        <span><?php echo $cp["precio"] ?>€</span>
                        <span>x <?php echo $carro["cantidad"] ?></span>
                        <p>Total: <?php
                        $tmp = $carro["cantidad"] * $cp["precio"];
                        echo $tmp ?>€</p>
                    </div>
                </div>
                <?php
                $total = $total + $carro["cantidad"];
                $precioT = $precioT + $tmp;
            }
            ?>
            <p class="h1 mb-5">Nº de productos: <?php echo $total ?></p>
            <p class="h1 mb-5">Precio: <?php echo $precioT ?>€</p>
            <div class="btn-group">
                <a href="../check/checkConfirmar.php?confirmar=si"><button type="button" class="btn btn-outline-success">Comprar</button></a>
                <a href="../check/checkConfirmar.php?confirmar=no"><button type="button"
                        class="btn btn-outline-danger">Cancelar Compra</button></a>
                <a href="factura.php" target="_blank"><button type="button" class="btn btn-outline-primary">Generar Factura</button></a>
            </div>
            <p class="mt-4"><a href="index.php"><button type="button" class="btn btn-outline-primary">Volver al
                        inicio</button></a></p>
            <?php
        }
        ?>
    </main>
    <?php include "../include/pie.php" ?>
    <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>