<?php
session_start();
include "../include/html.php";
?>

<body>
    <?php include '../include/cabeza.php'; ?>
    <main class="container">
        <h1 class="display-1 mb-5">Encuentra el mejor precio para tu próximo juego o consola
        </h1>
        <ul class="h2">Videojuegos:
            <li>Títulos recientes: Desde 40.00€</li>
            <li>Clásicos y retro: Desde 10.00€
            </li>
        </ul>
        <ul class="h2">Consolas:
            <li>Última generación: Desde 249.99€</li>
            <li>Generación anterior: Desde 149.99€</li>
        </ul>
        <ul class="h2">Componentes:
            <li>Tarjetas gráficas: Desde $XX.XX</li>
            <li>Procesadores: Desde $XX.XX</li>
            <li>Otros periféricos: Desde $XX.XX</li>
        </ul>
    </main>
    <?php include "../include/pie.php" ?>
</body>