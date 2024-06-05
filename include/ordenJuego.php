<?php

if (isset($_GET["plataforma"])) {
    $plataforma = $_GET["plataforma"];
    if(($mysql->query("SELECT * FROM plataformas WHERE nombre = '$plataforma'"))->num_rows == 0){
        header("location:juegos.php");
        exit();
    }
    $consulta = "SELECT v.id as v_id, v.titulo, v.portada, v.cantidad, t.precio, p.nombre,p.id as p_id FROM videojuegos v INNER JOIN tiene t ON t.id_video = v.id INNER JOIN plataformas p ON t.id_plat = p.id WHERE p.nombre = '$plataforma' GROUP BY v.id, t.precio,p.id, p.nombre";
    if (!isset($_GET["filtro"])) {
        $juegos = $mysql->query($consulta);
    } elseif ($_GET["filtro"] == "nombreA") {
        $juegos = $mysql->query($consulta. " ORDER BY titulo");
    } elseif ($_GET["filtro"] == "nombreZ") {
        $juegos = $mysql->query($consulta. " ORDER BY titulo DESC");
    } elseif ($_GET["filtro"] == "menor") {
        $juegos = $mysql->query($consulta. " order by precio");
    } elseif ($_GET["filtro"] == "mayor") {
        $juegos = $mysql->query($consulta. " order by precio DESC");
    } else {
        header("location:juegos.php");
        exit();
    }

} else {
    $consulta = "SELECT v.id as v_id, v.titulo, v.portada, v.cantidad, t.precio, p.nombre,p.id as p_id FROM videojuegos v INNER JOIN tiene t ON t.id_video = v.id INNER JOIN plataformas p ON t.id_plat = p.id GROUP BY v.id, t.precio,p.id, p.nombre";
    if (!isset($_GET["filtro"])) {
        $juegos = $mysql->query("SELECT * FROM videojuegos");
    } elseif ($_GET["filtro"] == "nombreA") {
        $juegos = $mysql->query("SELECT * FROM videojuegos ORDER BY titulo");
    } elseif ($_GET["filtro"] == "nombreZ") {
        $juegos = $mysql->query("SELECT * FROM videojuegos ORDER BY titulo DESC");
    } elseif ($_GET["filtro"] == "menor") {
        $juegos = $mysql->query($consulta. " order by precio");
    } elseif ($_GET["filtro"] == "mayor") {
        $juegos = $mysql->query($consulta. " order by precio DESC");
    } elseif ($_GET["filtro"] == "platA") {
        $juegos = $mysql->query($consulta. " order by nombre");
    } elseif ($_GET["filtro"] == "platZ") {
        $juegos = $mysql->query($consulta. " order by nombre DESC");
    } else {
        header("location:juegos.php");
        exit();
    }
}
