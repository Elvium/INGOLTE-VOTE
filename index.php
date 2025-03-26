<?php
include './logica/db-conexion.php';

session_start();

?>


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> VOTACIONES </title>
  <!--<link rel="stylesheet" type="text/css" href="css/style.css">-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    body {
      background: linear-gradient(to right, #d4edda, #a8df8e);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      background: #fff;
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
      font-size: 1.2rem;
      padding: 10px;
      transition: background 0.3s ease;
    }
    .btn-custom:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <div class="card p-4">
          <h2 class="text-center text-success mb-4">Iniciar Sesión</h2>
          <?php
            if (isset($_GET['error']) && $_GET['error'] == 1) {
              echo '<p class="text-danger text-center"> Datos incorrectos </p>';
            }
          ?>
          <form action="logica/loguear.php" method="post">
            <div class="mb-3">
              <input type="text" name="cc" class="form-control" placeholder="Usuario" required />
            </div>
            <div class="mb-3">
              <input type="password" name="p" class="form-control" placeholder="Contraseña" required />
            </div>
            <button type="submit" class="btn btn-custom w-100">Entrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>