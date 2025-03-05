<?php
include 'db-conexion.php';



$ccSocio = $_POST['ccSocio'] ?? null;
$Apoderado = $_POST['ccApoderado'] ?? null;
$nm = $_POST['nm'] ?? null;
$cantidadAccionesApoderado = 0;
$accionesPermiso = 0;
$fecha = $_POST['fecha'] ?? null;


if ($ccSocio != null) {

  $sqlApoderadoPermitido = "SELECT sum(Acciones) AS permiso FROM base WHERE Apoderado='$Apoderado'";
  $permiso = mysqli_query($conexion, $sqlApoderadoPermitido);

  $sqlAlerta = "SELECT Nombre, Acciones FROM base WHERE Cedula='$ccSocio'";
  $alerta = mysqli_query($conexion, $sqlAlerta);


  if ($row1 = $alerta->fetch_assoc()) {

    $name = $row1['Nombre'];
    $accionescant = $row1['Acciones'];

    if ($row2 = $permiso->fetch_assoc()) {

      $accionesPermiso = intval($row2['permiso'])+intval($accionescant);

      if ($accionesPermiso < 250) {

        $nm = strtoupper($nm);

        $sqlSocio = "UPDATE base SET Poder = 1, Apoderado='$Apoderado', nmApoderado='$nm' WHERE Cedula='$ccSocio'";

        $ejecutar = mysqli_query($conexion, $sqlSocio);

      

        if (!$ejecutar) {

          echo '<script>
          alert("NO SE ENCONTRO AL ACCIONISTA EN LA BASE DE DATOS");
          </script>';

        } else {

          $sqlPoder = "INSERT INTO poderes (ccAccionista,nmAccionista,ccApoderado,nmApoderado,nAcciones,
          fecha) VALUES($ccSocio,'$name',$Apoderado,'$nm',$accionescant,'$fecha') ";

          $queryPoderes = mysqli_query($conexion, $sqlPoder);

          
            echo '<script>
            alert("EL ACCIONISTA  ' . $name . '  DIO UN PODER DE  ' . $accionescant . '  ACCIONES AL APODERADO  ' . $nm . '");
            </script>';
          

        } 

      }else{
        
        echo '<script>
        alert("EL APODERADO SUPERARIA EL MAXIMO DE 250 ACCIONES '.$accionesPermiso.'");
        </script>';
        
      }
    }else {

      echo '<script>
      alert("ERROR INESPERADO CON LA BASE DE DATOS");
      </script>';
    }
  }else{
    echo '<script>
    alert("NO SE ENCONTRO SOCIO CON ESA CEDULA");
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
       


      </ul>
    </nav>

  </header>
  <br>
  <div>

    <h1>ENTREGAR PODER</h1>

    <form method="post" class="formulario">
      <p>el Accionista le confiere sus acciones al apoderado
      </p>
      <input type="text" name="ccSocio" placeholder="Cédula Socio" required="required" />
      <input type="text" name="ccApoderado" placeholder="Cédula Apoderado" required="required" />

      <input type="date" name="fecha" value="2023-10-31" min="2023-10-01" max="2023-11-01" />

      <button type="submit" class="btn btn-primary btn-block btn-large">Confirmar</button>
    </form>
    <form action="impresAccionistas.php" class="botonbajito">
      <button type="submit" class="btn btn-primary btn-large">Reporte</button>
    </form>
  </div>

  <div>

  </div>


  <footer>

    <?php

    $sqlSocioActual = "SELECT  count(*) as tconteo,sum(Acciones) as tacciones,sum(Poder) as tPoder  FROM base";
    $ejecucionConteo = mysqli_query($conexion, $sqlSocioActual);
    $sqlconsultaApoderado = "SELECT sum(Acciones) as tPoderes FROM base WHERE Poder=1";
    $ejecucionConteoApoderado = mysqli_query($conexion, $sqlconsultaApoderado);

    if ($row = $ejecucionConteoApoderado->fetch_assoc()) {

      $cantidadAccionesApoderado += $row['tPoderes'];
    }


    if ($row = $ejecucionConteo->fetch_assoc()) {


      echo '<p> ACCIONISTAS :  ' . number_format($row['tconteo']) . '&emsp;&emsp;&emsp;  acciones:  ' . number_format($row['tacciones']) . ' </p>
        <p> Apoderados: ' . number_format($row['tPoder']) . '&emsp;&emsp;&emsp;  Acciones: ' . number_format($cantidadAccionesApoderado) . '</p>';


    }
    ?>

  </footer>

</body>