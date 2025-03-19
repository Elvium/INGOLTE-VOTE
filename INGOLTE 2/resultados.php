<?php
include 'db-conexion.php';
?>

<head>
  <meta charset="UTF-8">
  <title>Votaciones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

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
    .btn-custom {
      background-color: #28a745;
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      font-size: 1.1rem;
      transition: background-color 0.3s ease;
      color: white;
    }
    .btn-custom:hover {
      background-color: #218838;
    }
    /* Botón Volver */
    .btn-back {
      position: absolute;
      top: 20px;
      right: 20px;
      background-color: #28a745;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 10px;
      font-size: 1rem;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: bold;
      transition: background 0.3s ease;
    }
    .btn-back i {
      font-size: 1.2rem;
    }
    .btn-back:hover {
      background-color: #218838;
    }

    /* Estilos de impresión */
    @media print {
      body {
        background: none;
      }
      .footer, .container-results, .btn-back {
        display: none;
      }
      .table {
        border: 1px solid #ccc;
        margin-top: 20px;
      }
    }
  </style>
</head>
<body>

  <!-- Botón Volver -->
  <a href="admin.php" class="btn-back">
    <i class="bi bi-arrow-left"></i> Volver
  </a>

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

    <!-- Botón de impresión -->
    <button class="btn btn-custom mt-3" onclick="printResults()">Imprimir Resultados</button>
  </div>

  <footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> - Sistema de Votación</p>
  </footer>

  <script>
    const date = new Date();
    document.getElementById("current_date").innerText = `Fecha: ${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;

    function printResults() {
      window.print();
    }
  </script>

</body>
</html>
