<?php
session_start();
if (!isset($_GET["id"]) or !isset($_GET["tipo"])) {
    header("location:index.php");
    exit();
} else {
    $tipo = $_GET["tipo"];
    $id = $_GET["id"];
    $mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
    if ($tipo == "juegos") {
        $juegos = $mysql->query("SELECT * from videojuegos WHERE id = '$id'");
        if ($juegos->num_rows == 0) {
            header("location:index.php");
            exit();
        }
        $row = $juegos->fetch_assoc();
    } elseif ($tipo == "consolas") {
        $consola = $mysql->query("SELECT * from plataformas WHERE id = '$id'");
        if ($consola->num_rows == 0) {
            header("location:index.php");
            exit();
        }
        $row = $consola->fetch_assoc();
    } elseif ($tipo == "componentes") {
        $compo = $mysql->query("SELECT * FROM componentes WHERE id = '$id'");
        if ($compo->num_rows == 0) {
            header("location:index.php");
            exit();
        }
        $row = $compo->fetch_assoc();
    } else {
        header("location:index.php");
        exit();
    }
}
if (isset($_SESSION["id"])) {
    $persona = $mysql->query("SELECT * from usuarios where id =" . $_SESSION["id"]);
    $persona = $persona->fetch_assoc();
}
include "../include/html.php";
?>


<body>
    <?php include '../include/cabeza.php'; ?>
    <main class="container-fluid">
        <section class="row justify-content-center">
            <?php
            switch ($tipo) {
                case 'juegos':
                    $precio = $mysql->query("SELECT precio from tiene inner join videojuegos on id_video = id where id_video =" . $_GET["id"]);
                    $console = $mysql->query("SELECT p.nombre,p.id as p_id,v.id as v_id from videojuegos v inner join tiene t on t.id_video = v.id inner join plataformas p on t.id_plat = p.id where t.id_video = " . $_GET["id"]);
                    ?>
                    <h2 class="display-1 text-center"><?php echo $row["titulo"] ?></h2>
                    <span class="card" style="width:1000px">
                        <img class="card-img-top" src="<?php if ($row["portada"] == "") {
                            echo "https://www.stargeek.es/2798-large_default/sudadera-super-mario-bros-bloque-interrogante-.jpg";
                        } else {
                            echo $row["portada"];
                        }
                        ?>" alt="" style="width:100%;height:1200px">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $row["titulo"] ?></h4>
                            <span class="card-text">Plataforma: </span>
                            <?php
                            if ($console->num_rows == 0) {
                                ?><span>No disponible</span><?php
                            } else {
                                while ($rowC = $console->fetch_assoc()) {
                                    ?><span><a class="text-decoration-none text-success"
                                            href="compra.php?tipo=juegos&id=<?php echo $rowC["v_id"] ?>&plataforma=<?php echo $rowC["p_id"] ?>"><?php
                                                  echo $rowC["nombre"] . "&nbsp";
                                                  ?></a></span>
                                    <?php
                                }
                            }
                            ?>
                            <p class="card-text">Precio: <?php
                            if ($precio->num_rows == 0) {
                                echo "No disponible";
                            } elseif ($precio->num_rows == 1) {
                                $rowP = $precio->fetch_assoc();
                                echo $rowP["precio"];
                            } else {
                                $cantidad = "";
                                $console->data_seek(0);
                                echo "<br>";
                                while ($rowP = $precio->fetch_assoc() and $rowC = $console->fetch_assoc()) {
                                    $cantidad .= $rowC["nombre"] . ": " . $rowP["precio"] . "€ <br>";
                                }
                                echo $cantidad;
                            }
                            ?></p>
                            <p class="card-text">Stock: <?php
                            if ($row["cantidad"] > 0) {
                                echo "En stock";
                            } else {
                                echo "No disponible";
                            }
                            ?></p>
                        </div>
                        <?php
                        if (isset($_SESSION["id"]) and $persona["tipo"] == "admin") {
                            ?>
                            <div class="btn-group d-flex justify-content-center mt-3 mb-3">
                                <a href="modificar.php?tipo=juegos&id=<?php echo $id ?>"><button type="button"
                                        class="btn btn-warning">Modificar</button></a>
                                <a href="borrar.php?tipo=juegos&id=<?php echo $id ?>"><button type="button"
                                        class="btn btn-danger">Borrar</button></a>
                            </div>
                            <?php
                        } elseif (isset($_SESSION["id"]) and $persona["tipo"] == "cliente") {
                            ?>
                            <div class="d-flex flex-row-reverse mb-3">
                                <form action="" method="post">
                                    <button type="sumbit" class="btn btn-success">Añadir al carro +</button>
                                </form>
                            </div>
                            <?php
                        }
                        ?>
                    </span>
                    <?php
                    break;
                case 'consolas':
                    ?>
                    <h2 class="display-1 text-center"><?php echo $row["nombre"] ?></h2>
                    <span class="card" style="width:1000px">
                        <img class="card-img-top" src="<?php if ($row["imagen"] == "") {
                            echo "https://www.stargeek.es/2798-large_default/sudadera-super-mario-bros-bloque-interrogante-.jpg";
                        } else {
                            echo $row["imagen"];
                        }
                        ?>" alt="" style="width:100%;height:1200px">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $row["nombre"] ?></h4>
                            <p class="card-text">Precio: <?php echo $row["precio"] ?> €</p>
                            <p class="card-text">Stock: <?php
                            if ($row["cantidad"] > 0) {
                                echo "En stock";
                            } else {
                                echo "No disponible";
                            }
                            ?></p>
                        </div>
                        <?php
                        if (isset($_SESSION["id"]) and $persona["tipo"] == "admin") {
                            ?>
                            <div class="btn-group d-flex justify-content-center mt-3 mb-3">
                                <a href="modificar.php?tipo=plataformas&id=<?php echo $id ?>"><button type="button"
                                        class="btn btn-warning">Modificar</button></a>
                                <a href="borrar.php?tipo=plataformas&id=<?php echo $id ?>"><button type="button"
                                        class="btn btn-danger">Borrar</button></a>
                            </div>
                            <?php
                        } elseif (isset($_SESSION["id"]) and $persona["tipo"] == "cliente") {
                            ?>
                            <div class="d-flex flex-row-reverse mb-3">
                                <form action="../check/checkCompra.php?tipo=plataformas&id=<?php echo $row["id"]?>" method="post">
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
                        ?>
                    </span>
                    <?php
                    break;
                case 'componentes':
                    ?>
                    <h2 class="display-1 text-center"><?php echo $row["nombre"] ?></h2>
                    <span class="card" style="width:1000px">
                        <img class="card-img-top" src="<?php if ($row["imagen"] == "") {
                            echo "https://www.stargeek.es/2798-large_default/sudadera-super-mario-bros-bloque-interrogante-.jpg";
                        } else {
                            echo $row["imagen"];
                        }
                        ?>" alt="" style="width:100%;height:1200px">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $row["nombre"] ?></h4>
                            <p class="card-text">Familia: <?php echo $row["tipo"] ?></p>
                            <p class="card-text">Precio: <?php echo $row["precio"] ?> €</p>
                            <p class="card-text">Stock: <?php
                            if ($row["cantidad"] > 0) {
                                echo "En stock";
                            } else {
                                echo "No disponible";
                            }
                            ?></p>
                        </div>
                        <?php
                        if (isset($_SESSION["id"]) and $persona["tipo"] == "admin") {
                            ?>
                            <div class="btn-group d-flex justify-content-center mt-3 mb-3">
                                <a href="modificar.php?tipo=componentes&id=<?php echo $id ?>"><button type="button"
                                        class="btn btn-warning">Modificar</button></a>
                                <a href="borrar.php?tipo=componentes&id=<?php echo $id ?>"><button type="button"
                                        class="btn btn-danger">Borrar</button></a>
                            </div>
                            <?php
                        } elseif (isset($_SESSION["id"]) and $persona["tipo"] == "cliente") {
                            ?>
                            <div class="d-flex flex-row-reverse mb-3">
                                <form action="../check/checkCompra.php?tipo=componentes&id=<?php echo $row["id"]?>" method="post">
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
                        ?>
                    </span>
                    <?php
                    break;
            }
            ?>
        </section>
    </main>
    <?php include "../include/pie.php" ?>
</body>

</html>