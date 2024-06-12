<?php
session_start();
include "../include/html.php";
?>

<body>
    <?php include '../include/cabeza.php'; ?>
    <main class="container">
        <h1 class="display-1 mb-5">Preguntas Frecuentes</h1>
        <ul class="h2">¿Cómo realizo una compra?
            <li>Selecciona el producto que deseas y agrégalo al carrito. Sigue las instrucciones para completar tu compra.</li>
        </ul>
        <ul class="h2">¿Cuáles son las opciones de pago?
            <li>Aceptamos tarjetas de crédito, PayPal y transferencias bancarias.</li>
        </ul>
        <ul class="h2">¿Ofrecen envíos internacionales?
            <li>Sí, realizamos envíos a varios países. Consulta nuestra página de envíos para más detalles.</li>
        </ul>
        <ul class="h2">¿Puedo devolver un producto?
            <li>Sí, aceptamos devoluciones dentro de los 30 días posteriores a la compra. Consulta nuestra política de devoluciones para más información.
            </li>
        </ul>
        <ul class="h2">¿Cómo puedo contactar al soporte al cliente?
            <li>Puedes enviarnos un correo electrónico a soporte@[nombre de la tienda].com o llamarnos al [número de teléfono].</li>
        </ul>

    </main>
    <?php include "../include/pie.php" ?>
</body>