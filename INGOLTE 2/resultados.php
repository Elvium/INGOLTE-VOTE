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



      </ul>
    </nav>

  </header>
  <br>
  <div class="resultados">
    <div id="current_date">
      <h1>
        <script>
          date = new Date();
          year = date.getFullYear();
          month = date.getMonth() + 1;
          day = date.getDate();
          document.getElementById("current_date").innerHTML = "RESULTADOS  ";
        </script>
      </h1>
    </div>

    <?php

    $sqlcandidatos = "SELECT * FROM plancha WHERE TotalAcciones > 0 ORDER BY TotalAcciones DESC ";
    $ejecucionCandidatos = mysqli_query($conexion, $sqlcandidatos);
    $totales=0;
  
    if ($ejecucionCandidatos) {
      while ($row = mysqli_fetch_array($ejecucionCandidatos)) {

        echo ' <h5>' . $row['Nombre'] . '&emsp;&emsp; TOTAL : '.number_format($row['TotalAcciones']).' </h5> ';
        $totales+= intval($row['TotalAcciones']);
      }

      echo ' <h5> VOTOS TOTALES&emsp; : &emsp;' .number_format($totales).' </h5> ';

    } else {

      echo '<h2> TODAVIA NO SE PUEDEN PRESENTAN RESULTADOS </h2>';
    }


    ?>


  </div>
</body>