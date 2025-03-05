<?php
include 'db-conexion.php';





$sqlactualizarBase="SELECT * FROM poderes ORDER by fecha,ID ASC ";

$sqlActualizacion=mysqli_query($conexion,$sqlactualizarBase);

while ($row = mysqli_fetch_array($sqlActualizacion)) {
$ccsocio=$row['ccAccionista'];
$ccApoderado=$row['ccApoderado'];
$nmApoderado=$row['nmApoderado'];

$sqlactualizar="UPDATE base SET Poder=1 ,Apoderado='$ccApoderado',nmApoderado='$nmApoderado' WHERE Cedula ='$ccsocio'";
$eject=mysqli_query($conexion,$sqlactualizar);



}

header('Location: http://votaringolte.online/admin.php');
          exit;


?>