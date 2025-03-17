<?php

include 'db-conexion.php';

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
    .container-results {
      background: #fff;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
      margin: auto;
      text-align: center;
    }
    .table {
      margin-top: 20px;
      background: #e9f5e9;
      border-radius: 10px;
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

  <div class="container-results">
    <h2 class="text-success">Resultados de la Votación</h2>
    <p id="current_date"></p>

    <table class="table table-bordered">
      <thead class="table-success">
        <tr>
          <th>Candidato</th>
          <th>Total Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $sqlcandidatos = "SELECT * FROM plancha WHERE TotalAcciones > 0 ORDER BY TotalAcciones DESC";
          $ejecucionCandidatos = mysqli_query($conexion, $sqlcandidatos);
          $totales = 0;

          if ($ejecucionCandidatos) {
            while ($row = mysqli_fetch_array($ejecucionCandidatos)) {
              echo "<tr>
                      <td>" . $row['Nombre'] . "</td>
                      <td>" . number_format($row['TotalAcciones']) . "</td>
                    </tr>";
              $totales += intval($row['TotalAcciones']);
            }
            echo "<tr class='table-secondary'>
                    <td><strong>Total de Votos</strong></td>
                    <td><strong>" . number_format($totales) . "</strong></td>
                  </tr>";
          } else {
            echo "<tr><td colspan='2'>Todavía no se pueden presentar resultados.</td></tr>";
          }
        ?>
      </tbody>
    </table>
  </div>

  <footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> - Sistema de Votación</p>
  </footer>

  <script>
    const date = new Date();
    document.getElementById("current_date").innerText = `Fecha: ${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
  </script>

</body>
</html>
<!--</head>

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
    
    /*$sqlcandidatos = "SELECT * FROM plancha WHERE TotalAcciones > 0 ORDER BY TotalAcciones DESC ";
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
    }*/


    ?>


  </div>
</body>
-->