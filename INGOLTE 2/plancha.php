<?php
include 'db-conexion.php';

$plancha = $_POST['plancha'] ?? null;

if ($plancha != null && $plancha != '') {
  $sqlPlancha = "INSERT INTO plancha (Nombre) VALUES ('$plancha')";
  $ejecutar = mysqli_query($conexion, $sqlPlancha);

  if (!$ejecutar) {
    echo "Hubo un error";
  } else {
    echo '<script>
    alert("Se registró la plancha con éxito");
    </script>';
  }
}
?>

<head>
  <meta charset="UTF-8">
  <title>VOTACIONES</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  
  <style>
    body {
      background: linear-gradient(to right, #d4edda, #a8df8e);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      position: relative;
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
    .footer {
      background-color: #28a745;
      color: white;
      padding: 15px;
      border-radius: 10px;
      text-align: center;
      margin-top: auto;
    }
    .btn-volver {
      position: absolute;
      top: 20px;
      right: 20px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 10px;
      padding: 10px 15px;
      font-size: 1rem;
      transition: background 0.3s ease;
      z-index: 1000;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    .btn-volver:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

  <form action="admin.php">
    <button type="submit" class="btn-volver">
      <i class="bi bi-arrow-left"></i> Volver
    </button>
  </form>

  <div class="container-form">
    <h2 class="text-center text-success">Registro de Candidatos</h2>
    <p class="text-center text-muted">Este formulario registrará las planchas o candidatos para las votaciones.</p>
    
    <form method="post">
      <div class="mb-3">
        <input type="text" name="plancha" class="form-control" placeholder="Nombre de plancha o candidato" required />
      </div>
      <button type="submit" class="btn btn-custom w-100">Registrar</button>
    </form>

    <form action="borrarRegistros.php" class="mt-3">
      <button type="submit" class="btn btn-danger w-100">Eliminar Registros</button>
    </form>
  </div>

  <footer class="footer">
    <?php
      $sqlConsultasPlanchas = "SELECT Nombre FROM plancha";
      $ejectPlancha = mysqli_query($conexion, $sqlConsultasPlanchas);

      echo "<p>Planchas Disponibles para las Votaciones:</p>";
      while ($row = mysqli_fetch_array($ejectPlancha)) {
        echo "<span class='badge bg-light text-dark mx-1'>" . $row['Nombre'] . "</span>";
      }
    ?>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
