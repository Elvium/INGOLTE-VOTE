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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <style>
    body {
      background: linear-gradient(to right, #d4edda, #a8df8e);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .container-form {
      background: #fff;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 450px;
      margin: auto;
    }
    .form-control {
      border-radius: 10px;
      border: 1px solid #a8df8e;
    }
    .form-control:focus {
      border-color: #28a745;
      box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
    }
    .btn-custom {
      background-color: #28a745;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      padding: 10px;
      transition: background 0.3s ease;
    }
    .btn-custom:hover {
      background-color: #218838;
    }
    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 15px;
      margin-top: 15px;
    }
    .grid-item {
      background: #e9f5e9;
      padding: 15px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .grid-item label {
      font-weight: bold;
    }
    .footer {
      background-color: #28a745;
      color: white;
      padding: 15px;
      border-radius: 10px;
      text-align: center;
      margin-top: auto;
    }
  </style>
</head>
<body>

  <div class="container-form">
    <h2 class="text-center text-success">Votación</h2>
    
    <form method="post">
      <div class="mb-3">
        <input type="text" name="ccSocio" class="form-control" placeholder="Cédula del Votante" required />
      </div>

      <div class="grid-container">
        <?php
          $sqlcandidatos = "SELECT * FROM plancha";
          $ejecucionCandidatos = mysqli_query($conexion, $sqlcandidatos);

          while ($row = mysqli_fetch_array($ejecucionCandidatos)) {
            echo '<div class="grid-item">
                    <label>' . $row['Nombre'] . '</label><br> 
                    <input type="radio" name="plancha" value="' . $row['ID'] . '" required>
                  </div>';
          }
        ?>
      </div>

      <button type="submit" class="btn btn-custom w-100 mt-3">Votar</button>
    </form>
  </div>

  <footer class="footer">
    <?php
      $sqlcantVotantes = "SELECT COUNT(*) as vot FROM votaciones";
      $ejectvota = mysqli_query($conexion, $sqlcantVotantes);
      
      $votantesActuales = 0;
      if ($row = mysqli_fetch_array($ejectvota)) {
        $votantesActuales = $row['vot'];
      }

      echo "<p>Votantes Actuales: <strong>" . number_format($votantesActuales) . "</strong></p>";
    ?>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>