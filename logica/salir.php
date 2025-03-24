<?php
session_start();

if(isset($_SESSION['usuario'])){
    session_destroy();
    header('Location: ../index.php');
    exit();
}else{
    echo '<script> alert ("No existe la sesión"); </script>';
    header('Location: ../index.php');
    exit();
}
?>