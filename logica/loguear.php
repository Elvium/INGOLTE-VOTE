<?php
require './db-conexion.php';
session_start();

$usuario = $_POST['cc'] ?? null;
$pass = $_POST['p'] ?? null;
$sentencia = $conexion -> prepare("SELECT usuario, clave, id_rol FROM usuarios WHERE usuario = ?");

$sentencia -> bind_param("s", $usuario);
$sentencia -> execute();
$resultado = $sentencia -> get_result();

if($resultado -> num_rows > 0){
    $fila = $resultado -> fetch_assoc();
    $hash_clave = $fila['clave'];
    if(password_verify($pass, $hash_clave)){
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['rol'] = $fila['id_rol'];
        header('Location: ../admin.php');
        exit();
    } else {
        header('Location: ../index.php?error=1');
        exit();
    }
}else{
    header('Location: ../index.php?error=1');
        exit();
}

?>