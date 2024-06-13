<?php
$mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
$cons = $mysql->query("SELECT * FROM plataformas");
?>
<header class="p-3 text-bg-dark">
    <?php
    if (isset($_SESSION["id"])) {
        ?>
        <div class="offcanvas offcanvas-end" id="carro">
            <div class="offcanvas-header">
                <h1 class="offcanvas-title">Su carrito</h1>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <?php
                $carritoV = $mysql->query("SELECT * from compra_video where id_usu =" . $_SESSION["id"]);
                $carritoP = $mysql->query("SELECT * from compra_equipo where id_usu =" . $_SESSION["id"]);
                $carritoC = $mysql->query("SELECT * from compra_compo where id_usu =" . $_SESSION["id"]);
                if ($carritoV->num_rows == 0 and $carritoP->num_rows == 0 and $carritoC->num_rows == 0) {
                    ?>
                    <img class="img-fluid" src="../imagenes/carritoVacio.png" alt="Vacio">
                    <p class="display-5 text-center">Carrito vacio</p>
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
                        <img class="rounded" src="<?php echo $vj["portada"] ?>" alt="portada" width="100%" height="200px">
                        <div class="mb-3">
                            <p><?php echo $vj["titulo"] ?></p>
                            <span><?php echo $vprecio["precio"] ?>€</span>
                            <span>x <?php echo $carro["cantidad"] ?></span>
                            <p>Total: <?php
                            $tmp = $vprecio["precio"] * $carro["cantidad"];
                            echo $tmp;
                            ?>€</p>
                        </div>
                        <?php
                        $total = $total + $carro["cantidad"];
                        $precioT = $precioT + $tmp;
                    }
                    while ($carro = $carritoP->fetch_assoc()) {
                        $pt = $mysql->query("SELECT * from plataformas where id =" . $carro["id_plat"]);
                        $pt = $pt->fetch_assoc();
                        ?>
                        <img class="rounded" src="<?php echo $pt["imagen"] ?>" alt="portada" width="100%" height="200px">
                        <div class="mb-3">
                            <p><?php echo $pt["nombre"] ?></p>
                            <span><?php echo $pt["precio"] ?>€</span>
                            <span>x <?php echo $carro["cantidad"] ?></span>
                            <p>Total: <?php
                            $tmp = $carro["cantidad"] * $pt["precio"];
                            echo $tmp ?>€</p>
                        </div>
                        <?php
                        $total = $total + $carro["cantidad"];
                        $precioT = $precioT + $tmp;
                    }
                    while ($carro = $carritoC->fetch_assoc()) {
                        $cp = $mysql->query("SELECT * from componentes where id =" . $carro["id_compo"]);
                        $cp = $cp->fetch_assoc();
                        ?>
                        <img class="rounded" src="<?php echo $cp["imagen"] ?>" alt="portada" width="100%" height="200px">
                        <div class="mb-3">
                            <p><?php echo $cp["nombre"] ?></p>
                            <span><?php echo $cp["precio"] ?>€</span>
                            <span>x <?php echo $carro["cantidad"] ?></span>
                            <p>Total: <?php
                            $tmp = $carro["cantidad"] * $cp["precio"];
                            echo $tmp ?>€</p>
                        </div>
                        <?php
                        $total = $total + $carro["cantidad"];
                        $precioT = $precioT + $tmp;
                    }
                    ?>
                    <p class="h2 mb-5">Nº de productos: <?php echo $total ?></p>
                    <p class="h2 mb-5">Precio: <?php echo $precioT ?>€</p>
                    <div class="btn-group">
                        <a href="../php/carrito.php"><button type="button" class="btn btn-outline-success">Confirmar
                                carrito</button></a>
                        <a href="../check/checkConfirmar.php?confirmar=no"><button type="button"
                                class="btn btn-outline-danger">Borrar carrito</button></a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="../php/index.php"><img src="../imagenes/videowebo.png" alt="" width="50px" height="50px"></a>
            <span class="display-5"><a class="text-decoration-none text-light"
                    href="../php/index.php">IDEOWEBOS</a></span>
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="../Header/Home.php" class="nav-link px-2 text-secondary">Home</a></li>
                <li><a href="../Header/Features.php" class="nav-link px-2 text-white">Features</a></li>
                <li><a href="../Header/Pricing.php" class="nav-link px-2 text-white">Pricing</a></li>
                <li><a href="../Header/FAQ.php" class="nav-link px-2 text-white">FAQs</a></li>
                <li><a href="../Header/About.php" class="nav-link px-2 text-white">About</a></li>
            </ul>
            <div class="row">
                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" method="POST">
                    <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..."
                        aria-label="Search" name="busqueda">
                </form>
                <div class="col-3 d-inline-flex flex-column search-input bg-dark">
                    <?php
                    if (isset($_POST["busqueda"])) {
                        $busqueda = $_POST["busqueda"];
                        $selectV = $mysql->query("SELECT * from videojuegos where titulo rlike '$busqueda'");
                        $selectP = $mysql->query("SELECT * from plataformas where nombre rlike '$busqueda'");
                        $selectC = $mysql->query("SELECT * from componentes where nombre rlike '$busqueda'");
                        ?>

                        <?php
                        while ($fila = $selectV->fetch_assoc()) {
                            ?>
                            <a class="dropdown-item text-decoration-none"
                                href="../php/vista.php?tipo=juegos&id=<?php echo $fila["id"] ?>"><?php echo $fila["titulo"] ?></a>
                            <?php
                        }
                        while ($fila = $selectP->fetch_assoc()) {
                            ?>
                            <a class="dropdown-item text-decoration-none"
                                href="../php/vista.php?tipo=consolas&id=<?php echo $fila["id"] ?>"><?php echo $fila["nombre"] ?></a>
                            <?php
                        }
                        while ($fila = $selectC->fetch_assoc()) {
                            ?>
                            <a class="dropdown-item text-decoration-none"
                                href="../php/vista.php?tipo=componentes&id=<?php echo $fila["id"] ?>"><?php echo $fila["nombre"] ?></a>
                            <?php
                        }
                        ?>

                        <?php
                    }
                    ?>
                </div>
            </div>

            <?php
            if (isset($_SESSION["id"])) {
                $usu = $mysql->query("SELECT * from usuarios where id =" . $_SESSION["id"]);
                $usu = $usu->fetch_assoc();
                ?>
                <div class="text-end">
                    <?php
                    if ($usu["tipo"] == "empelado") {
                        ?>
                        <a href="../php/admin.php"><button type="button" class="btn btn-outline-light me-2"><?php
                        echo $usu["nombre"] . " (Zona " . $usu["tipo"] . ")";
                        ?></button></a>
                        <a href="../php/logout.php"><button type="button" class="btn btn-danger"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-power" viewBox="0 0 16 16">
                                    <path d="M7.5 1v7h1V1z" />
                                    <path
                                        d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812" />
                                </svg></button></a>
                        <?php
                    } elseif ($usu["tipo"] == "admin") {
                        ?>
                        <div class="dropdown" data-bs-theme="dark">
                            <button type="button" class="btn  btn-outline-success  dropdown-toggle text-decoration-none"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"><?php echo $usu["nombre"] . " (" . $usu["tipo"] . ")" ?></button>
                            <ul class="dropdown-menu">
                                <li><a class="text-decoration-none" href="../php/admin.php"><button
                                            class="dropdown-item btn">ZONA ADMIN</button></a></li>
                                <li><a class="text-decoration-none" href="../php/usuarios.php"><button
                                            class="dropdown-item btn">ZONA USUARIOS</button></a></li>
                                <li class="d-grid gap-2">
                                    <a class="text-decoration-none text-light" href="../php/logout.php"><button type="button"
                                            class="btn btn-danger "><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                                                <path d="M7.5 1v7h1V1z" />
                                                <path
                                                    d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812" />
                                            </svg></a>
                                </li>
                            </ul>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="dropdown" data-bs-theme="dark">
                            <button type="button" class="btn  btn-outline-success  dropdown-toggle text-decoration-none"
                                data-bs-toggle="dropdown" aria-expanded="false"><?php echo $usu["nombre"] ?></button>
                            <ul class="dropdown-menu">
                                <li><button class="dropdown-item btn" data-bs-toggle="offcanvas"
                                        data-bs-target="#carro">Carrito</button></li>
                                <li class="d-grid gap-2">
                                    <a class="text-decoration-none text-light" href="../php/logout.php"><button type="button"
                                            class="btn btn-danger "><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                                                <path d="M7.5 1v7h1V1z" />
                                                <path
                                                    d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812" />
                                            </svg></a>
                                </li>
                            </ul>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            } else {
                ?>
                <div class="text-end">
                    <a href="../php/login.php"><button type="button" class="btn btn-outline-light me-2">Login</button></a>
                    <a href="../php/registro.php"><button type="button" class="btn btn-success">Sign-up</button></a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</header>
<nav class="navbar navbar-expand-lg bg-body-tertiary rounded mb-3" data-bs-theme="dark"
    aria-label="Eleventh navbar example">
    <div class="container-fluid ">
        <a class="navbar-brand" href="../php/index.php">HOME</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample09"
            aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExample09">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="../php/consolas.php">Plataformas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../php/componentes.php">Componentes</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="../php/juegos.php" data-bs-toggle="dropdown"
                        aria-expanded="false">Videojuegos</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../php/juegos.php">Todas</a></li>
                        <?php
                        while ($li = $cons->fetch_assoc()) {
                            ?>
                            <li><a class="dropdown-item"
                                    href="../php/juegos.php?plataforma=<?php echo $li["nombre"] ?>"><?php echo $li["nombre"] ?></a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>