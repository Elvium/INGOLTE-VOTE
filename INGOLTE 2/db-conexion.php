<?php
$usuario = "root";
$password = "";
$servidor = "localhost";
$basededatos = "voteingolte";


$conexion = mysqli_connect($servidor, $usuario,$password) or die("Error con el servidor de la base de datos");

$bd = mysqli_select_db($conexion, $basededatos) or die("Error conexion al conectarse a la base de datos");

?>