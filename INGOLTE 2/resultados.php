<?php
include 'db-conexion.php';
?>

<head>
  <meta charset="UTF-8">
  <title>Votaciones</title>
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

    /* Estilos de impresión */
    @media print {
      body {
        background: none;
      }
      .footer, .container-results {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
      }
      .table {
        border: 1px solid #ccc;
        margin-top: 20px;
      }
    }

    /* Estilo personalizado para el botón de impresión */
    .btn-print {
      background-color: #28a745;
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      font-size: 1.1rem;
      transition: background-color 0.3s ease;
      color: white;
    }

    .btn-print:hover {
      background-color: #218838;
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
                      <td>" . $row['nombre'] . "</td>
                      <td>" . number_format($row['totalAcciones']) . "</td>
                    </tr>";
              $totales += intval($row['totalAcciones']);
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

    <!-- Botón de impresión con la misma estética -->
    <button class="btn btn-print mt-3" onclick="printResults()">Imprimir Resultados</button>
  </div>

  <footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> - Sistema de Votación</p>
  </footer>

  <script>
    const date = new Date();
    document.getElementById("current_date").innerText = `Fecha: ${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;

    // Función de impresión
    function printResults() {
      
      
      window.print();
    }
  </script>

</body>
</html>
