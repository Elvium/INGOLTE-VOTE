<?php

$usuario = "root";
$password = "";
$servidor = "localhost";
$basededatos = "voteingolte";


$conexion = mysqli_connect($servidor, $usuario,$password, $basededatos);

if($conexion){
    //echo "Conectado con éxito a la base de datos";
}else{
    echo "Error al conectar con la base de datos";
}


?>