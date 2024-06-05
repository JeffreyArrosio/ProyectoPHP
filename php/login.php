<?php
    session_start();
    if(isset($_SESSION["id"])){
        header("location:index.php");
        exit();
    }
    include "../include/html.php";    
?>


<body>
    <main class="form-signin w-50 m-auto container">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <form class="text-body" action="../check/check.php?tipo=login" method="post">
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                <label for="email">Email</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="pass" name="pass" placeholder="Password">
                <label for="pass">Contraseña</label>
            </div>

            <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label text-light" for="flexCheckDefault">
                    Remember me
                </label>
            </div>
            <button class="btn btn-primary w-50 py-2" type="submit">Log In</button>
            
        </form>
        <a href="index.php"><button class="btn btn-success w-50 py-2 mt-3">Volver</button></a>
        <?php
        if (isset($_GET["fallo"])) {
            if ($_GET["fallo"] == 1) {
                ?>
                <div class="alert alert-danger alert-dismissible mt-3">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    El email o la constraseña son incorrectas
                </div>
                <?php
            } elseif ($_GET["fallo"] == 2) {
                ?>
                <div class="alert alert-danger alert-dismissible mt-3">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    No puede haber campos vacios
                </div>
                <?php
            }
        }
        ?>
    </main>
    <?php include "../include/pie.php" ?>
    <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>