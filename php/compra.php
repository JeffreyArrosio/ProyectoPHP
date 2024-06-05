<?php
session_start();
if (!isset($_GET["id"]) or !isset($_GET["tipo"]) or !isset($_GET["plataforma"])) {
    header("location:index.php");
    exit();
} else {
    $tipo = $_GET["tipo"];
    $id = $_GET["id"];
    $plataforma = $_GET["plataforma"];
    $mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
    if ($tipo == "juegos") {
        $juegos = $mysql->query("SELECT v.*,p.nombre,t.precio from videojuegos v inner join tiene t on v.id = t.id_video inner join plataformas p on p.id = t.id_plat WHERE t.id_video = '$id' AND t.id_plat = '$plataforma'");
        if ($juegos->num_rows == 0) {
            header("location:index.php");
            exit();
        }
        $row = $juegos->fetch_assoc();
    } else {
        header("location:index.php");
        exit();
    }
}
include "../include/html.php";
?>

<body>
    <?php include '../include/cabeza.php'; ?>
    <main class="container-fluid">
        <section class="row justify-content-center">
            <h2 class="display-1 text-center"><?php echo $row["titulo"] ?></h2>
            <span class="card mb-5" style="width:800px">
                <img class="card-img-top" src="<?php if ($row["portada"] == "") {
                    echo "https://www.stargeek.es/2798-large_default/sudadera-super-mario-bros-bloque-interrogante-.jpg";
                } else {
                    echo $row["portada"];
                }
                ?>" alt="" style="width:100%;height:1000px">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $row["titulo"] ?></h4>
                    <p class="card-text">Plataforma: <?php echo $row["nombre"] ?></p>
                    <p class="card-text">Precio: <?php echo $row["precio"] ?></p>
                </div>
                <div class="d-flex flex-row-reverse mb-3">
                    <?php
                    if (isset($_SESSION["id"])) {
                        $compra = $mysql->query("SELECT * from usuarios where id =" . $_SESSION["id"]);
                        $compra = $compra->fetch_assoc();
                        if ($compra["tipo"] == "admin") {
                            ?>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">
                                Cambiar precio
                            </button>
                            <div class="modal" id="myModal">
                                <div class="modal-dialog">
                                    <div class="modal-content text-body">
                                        <div class="modal-header">
                                            <h4 class="modal-title ">Ponga el nuevo precio</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="../check/checkPrecio.php?id=<?php echo $id ?>&plataforma=<?php echo $plataforma ?>"
                                                method="post">
                                                <div class="mb-3 mt-3">
                                                    <label for="price" class="form-label">Nuevo Precio:</label>
                                                    <input type="text" class="form-control" id="price" name="price"
                                                        value="<?php echo $row["precio"] ?>" placeholder=0>
                                                </div>
                                                <button type=" submit" class="btn btn-success">Submit</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } elseif (isset($_SESSION["id"]) and $compra["tipo"] == "cliente") {
                            ?>
                            <div class="d-flex flex-row-reverse mb-3">
                                <form action="../check/checkCompra.php?tipo=juegos&id=<?php echo $row["id"]?>&plataforma=<?php echo $plataforma?>" method="post">
                                    <label for="cant">Cantidad:</label><br>
                                    <input type="number" id="cant" name="cant" min="1" max="<?php
                                    if ($row["cantidad"] > 0) {
                                        echo $row["cantidad"];
                                    } else {
                                        echo "1";
                                    }
                                    ?>" value="1"><br>
                                    <button type="sumbit" class="btn btn-success" <?php
                                    if ($row["cantidad"] <= 0) {
                                        echo "disabled";
                                    }
                                    ?>>Añadir al carro +</button>
                                </form>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </span>
        </section>
    </main>
    <?php include "../include/pie.php" ?>
</body>

</html>