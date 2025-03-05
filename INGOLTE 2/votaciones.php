<?php

include 'db-conexion.php';

$ccSocio = $_POST['ccSocio'] ?? null;
$plancha = $_POST['plancha'] ?? null;

$votantesActuales=0;




if ($ccSocio != null) {

  $sqlestaAsistencia = "SELECT Nombre, Voto, Acciones FROM asistencia Where Cedula = '$ccSocio'";
  $comprobadorAsistencia = mysqli_query($conexion, $sqlestaAsistencia);


  if ($row = $comprobadorAsistencia->fetch_assoc()) {
    $comprobador = $row['Nombre'];
    $voto = $row['Voto'];
    $cantAcciones = $row['Acciones'];

    if ($voto == 0 && $cantAcciones != 0) {


      $sqlVotacion = "INSERT INTO votaciones (Cedula,Nombre,Plancha,Acciones) VALUES ('$ccSocio','$comprobador','$plancha','$cantAcciones')";
      $Ejecutar2 = mysqli_query($conexion, $sqlVotacion);

      if (!$Ejecutar2) {

        echo '<script>
        alert("Error inesperado, contactar con tecnico");
        </script>';

      } else {

        $sqlSiVoto = "UPDATE asistencia SET Voto = 1 WHERE Cedula='$ccSocio'";
        $Ejecutar1 = mysqli_query($conexion, $sqlSiVoto);

        if (!$Ejecutar1) {

        } else {
          $sqlcalcularVotacion = "UPDATE plancha SET TotalAcciones= TotalAcciones + $cantAcciones WHERE ID ='$plancha'";
          echo '<script>
          alert("ACCIONES  : ' . $cantAcciones . '");
          </script>';
          $ejecutar3 = mysqli_query($conexion, $sqlcalcularVotacion);

          if (!$ejecutar3) {
            echo '<script>
            alert("Inconveniente al registrar su voto, avise al encargado mas cercano");
            </script>';

          } else {

            echo '<script>
            alert("Su voto ha sido registrado");
            </script>';
          }
        }


      }


    } else {

      echo '<script>
      alert("El Accionista ya voto o esta imposibilitado para votar");
      </script>';
    }

  } else {

    echo '<script>
    alert("El Accionista puede no estar registrado en Asistencia, Consultar con el asistente mas cercano");
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
  <div class="radiobutton">

    <h1>Votación</h1>
    <p> </p>
    <form method="post">
      <input type="text" class="texto" name="ccSocio" placeholder="Cedula del Votante" required="required" />


      
      <div class="radiobutton">

     
        <div class="grid-container">
          <?php

          $sqlcandidatos = "SELECT  * FROM plancha ";
          $ejecucionCandidatos = mysqli_query($conexion, $sqlcandidatos);


          while ($row = mysqli_fetch_array($ejecucionCandidatos)) {

            echo '<div class="grid-item"> <label>' . $row['Nombre'] . '</label><br> <input type="radio" name="plancha" value="' . $row['ID'] . '"></div>';

          }
          ?>

        </div>

        <div class="botonbajo">
          <button type="submit" class="btn btn-primary btn-block btn-large">Votar</button>

        </div>
    </form>
  </div>
  <footer>
<?php
$sqlcantVotantes = "SELECT  count(*) as vot FROM votaciones";
$ejectvota = mysqli_query($conexion, $sqlcantVotantes);

echo '<p>  &emsp;  </p>';

if ($row = mysqli_fetch_array($ejectvota)) {
$votantesActuales= $row['vot'];

}
echo'<p>VOTANTES ACTUALES : &emsp;'.$votantesActuales.' </p>';



?>


  </footer>

</body>