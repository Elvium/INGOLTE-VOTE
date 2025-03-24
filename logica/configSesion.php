<?php

error_reporting(0);
session_start();

$id_rol = $_SESSION['rol'] ?? null;
$usuario = $_SESSION['usuario'] ?? null;

if(!isset($_SESSION['usuario'])){
    echo '<script> alert ("No estas logueado"); </script>';
    header('Location: ../index.php');
    exit();
}

?>