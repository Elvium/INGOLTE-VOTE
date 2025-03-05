<?php
include 'db-conexion.php';



$ccAsistencia = $_POST['cc'] ?? null;

$ccConsulta = $_POST['consulta'] ?? null;
$accion = 0;
$acciones = 0;


if ($ccAsistencia != null) {

  $sqlSociodioPoder = "SELECT Cedula,Nombre, Apoderado, Acciones FROM base WHERE Poder = 1 and CEDULA ='$ccAsistencia'";
  $consultaSocioApoderado = mysqli_query($conexion, $sqlSociodioPoder);

  if ($row = $consultaSocioApoderado->fetch_assoc()) {
    $cc = $row['Cedula'];
    $nombreAsistente = $row['Nombre'];
    $Apoderado = $row['Apoderado'];
    $acc = $row['Acciones'];


    if (!empty($cc)) {

      $sqlactualizarSocio = "UPDATE base SET Poder = 0, Apoderado= NULL, nmApoderado=NULL  WHERE Cedula='$cc'";
      $ejecutar1 = mysqli_query($conexion, $sqlactualizarSocio);
      $sqlactualizarAsistencia = "UPDATE asistencia SET Acciones = Acciones - $acc  WHERE Cedula='$Apoderado'";
      $ejecutar2 = mysqli_query($conexion, $sqlactualizarAsistencia);
    }

  }



  $sqlBusquedaAccionesApoderado = "SELECT SUM(Acciones) as total, nmApoderado as nm FROM base WHERE Apoderado= '$ccAsistencia'";
  $consulta1 = mysqli_query($conexion, $sqlBusquedaAccionesApoderado);

  if ($row = $consulta1->fetch_assoc()) {

    $acciones = $row['total'];
    $nombreAsistente = $row['nm'];
  }


  $sqlBusquedaAccionesSocio = "SELECT Acciones , Nombre FROM base WHERE Cedula = '$ccAsistencia'";
  $consulta2 = mysqli_query($conexion, $sqlBusquedaAccionesSocio);

  if ($row = $consulta2->fetch_assoc()) {
    $acciones += $row['Acciones'];
    $nombreAsistente = $row['Nombre'];
  }



  if ($acciones != 0) {
    $sqlAsistencia = "INSERT INTO asistencia (Cedula,Nombre,Acciones) VALUES ($ccAsistencia,'$nombreAsistente',$acciones)";
    $ejecutar = mysqli_query($conexion, $sqlAsistencia);

    if (!$ejecutar) {
      echo '<script>
      alert("ERROR INESPERADO");
      </script>';

    } else {
      echo '<script>
      alert("BIENVENIDO A LAS VOTACIONES ' . $nombreAsistente . '");
      </script>';

    }

  } else {

    echo '<script>
    alert("ESTE ACCIONISTA NO CUENTA CON ACCIONES");
    </script>';

  }
}elseif($ccConsulta!=null){


  $sqlConsultaAcciones = "SELECT Nombre , Acciones FROM asistencia WHERE Cedula='$ccConsulta'";
  $accionesActuales = mysqli_query($conexion, $sqlConsultaAcciones);

  if ($row = $accionesActuales->fetch_assoc()) {
    
    echo '<script>
    alert("LA CANTIDAD DE ACCIONES DE '.$row['Nombre'].'  SON '.$row['Acciones'].'");
    </script>';

  }else {
    echo '<script>
    alert("EL SOCIO NO SE ENCUENTRA REGISTRADO EN ASISTENCIA");
    </script>';
  }

}

?>

<head>
  <meta charset="UTF-8">
  <title> VOTACIONES </title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
  <header>
    <nav>
      <ul>
        
        <li><a href="asistencia.php">ASISTENCIA</a></li>



      </ul>
    </nav>
  </header>

  <div>
    <br>
    <h1>Asistencia</h1>
    <form class="formulario" method="post">
      
      <input type="text" name="cc" placeholder="Cédula" required="required" />

      <button type="submit" class="btn btn-primary btn-block btn-large">Confirmacion</button>
    </form>
    <form action="impresAsistentes.php" class="normalito">
      <button type="submit" class="btn btn-primary btn-large">Reporte</button>
    </form>
    

  </div>
  
  <div>
    <br>
    <br><br><br><br><br><br>
    <form class="formulario" method="post">
      <p>CONSULTA DE ACCIONES ACTUALES DEL SOCIO
      </p>
      <input type="text" name="consulta" placeholder="Cédula" required="required" />

      <button type="submit" class="btn btn-primary btn-block btn-large">Consulta</button>
    </form>

    

  </div>
  <footer>

    <?php

    $sqlAsistenciaActual = "SELECT  count(*) as tasistencia,sum(Acciones) as tacciones FROM asistencia";
    $ejecucionAsistencia = mysqli_query($conexion, $sqlAsistenciaActual);

    if ($row = $ejecucionAsistencia->fetch_assoc()) {


      $asist = $row['tasistencia'];
      $accion += $row['tacciones']; //un separador
    

    }




    echo '<p>ASISTENTES:    ' . $asist . '                     ACCIONES REPRESENTADAS: ' . number_format($accion) . '<p>';
    ?>

  </footer>


</body>