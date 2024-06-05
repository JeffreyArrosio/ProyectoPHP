<?php
$mysql = new mysqli("localhost", "root", "majada", "proyecto3") or die("ERROR MASTODONICO");
if (!isset($_GET["filtro"])) {
    if (isset($_GET["familia"])) {
        $familia = $_GET["familia"];
        $compo = $mysql->query("SELECT * FROM componentes where tipo = '$familia'");
        if ($compo->num_rows == 0) {
            header("location:componentes.php");
            exit();
        }
    } else {
        $compo = $mysql->query("SELECT * FROM componentes");
    }
} else {
    if (isset($_GET["familia"])) {
        $familia = $_GET["familia"];
        $compo = $mysql->query("SELECT * FROM componentes where tipo = '$familia'");
        if ($compo->num_rows == 0) {
            header("location:componentes.php");
            exit();
        }
        if ($_GET["filtro"] == "nombreA") {
            $compo = $mysql->query("SELECT * FROM componentes  where tipo = '$familia' ORDER BY nombre");
        } elseif ($_GET["filtro"] == "nombreZ") {
            $compo = $mysql->query("SELECT * FROM componentes  where tipo = '$familia' ORDER BY nombre DESC");
        } elseif ($_GET["filtro"] == "menor") {
            $compo = $mysql->query("SELECT * FROM componentes  where tipo = '$familia' ORDER BY precio");
        } elseif ($_GET["filtro"] == "mayor") {
            $compo = $mysql->query("SELECT * FROM componentes  where tipo = '$familia' ORDER BY precio DESC");
        } else {
            $compo = $mysql->query("SELECT * FROM componentes  where tipo = '$familia' ORDER BY precio DESC");
        }
    } else {
        if ($_GET["filtro"] == "nombreA") {
            $compo = $mysql->query("SELECT * FROM componentes ORDER BY nombre");
        } elseif ($_GET["filtro"] == "nombreZ") {
            $compo = $mysql->query("SELECT * FROM componentes ORDER BY nombre DESC");
        } elseif ($_GET["filtro"] == "menor") {
            $compo = $mysql->query("SELECT * FROM componentes ORDER BY precio");
        } elseif ($_GET["filtro"] == "mayor") {
            $compo = $mysql->query("SELECT * FROM componentes ORDER BY precio DESC");
        } else {
            $compo = $mysql->query("SELECT * FROM componentes ORDER BY precio DESC");
        }
    }
}

