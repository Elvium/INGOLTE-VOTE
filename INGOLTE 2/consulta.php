<?php

include 'db-conexion.php';

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

        <li><a href="asistencia.php">VOLVER</a></li>


      </ul>
    </nav>

  </header>
  <br>

  <div class="resultados1">

  <?php

$sqlsinvotar = "SELECT Nombre FROM asistencia WHERE Voto = 0 ";
$ejecucionSinVotar = mysqli_query($conexion, $sqlsinvotar);

if ($ejecucionSinVotar) {
  while ($row = mysqli_fetch_array($ejecucionSinVotar)) {

    echo ' <label>' . $row['Nombre'] . '</label>&emsp; ';

  }

} else {

  echo '<h2> YA TODOS VOTARON </h2>';


}


?>




  </div>
</body>