<?php

include 'db-conexion.php';

?>

<head>
  <meta charset="UTF-8">
  <title> VOTACIONES </title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(to right, #d4edda, #a8df8e);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .container {
      background: #fff;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 600px;
      margin: auto;
      text-align: center;
    }
    .list-group {
      margin-top: 20px;
      background: #f8f9fa;
      border-radius: 10px;
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
    .footer {
      background-color: #343a40;
      color: white;
      padding: 15px;
      border-radius: 10px;
      text-align: center;
      margin-top: auto;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2 class="text-danger">Personas que aún no han votado</h2>

    <ul class="list-group">
      <?php
        $sqlsinvotar = "SELECT Nombre FROM asistencia WHERE Voto = 0";
        $ejecucionSinVotar = mysqli_query($conexion, $sqlsinvotar);
        $hayPendientes = false;

        if ($ejecucionSinVotar) {
          while ($row = mysqli_fetch_array($ejecucionSinVotar)) {
            echo "<li class='list-group-item'>" . $row['Nombre'] . "</li>";
            $hayPendientes = true;
          }
        }

        if (!$hayPendientes) {
          echo "<li class='list-group-item text-center text-success'><strong>¡Todos han votado!</strong></li>";
        }
      ?>
    </ul>

    <a href="asistencia.php" class="btn btn-primary mt-4 btn-custom">Volver</a>
  </div>

  <footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> - Sistema de Votación</p>
  </footer>

</body>
</html>