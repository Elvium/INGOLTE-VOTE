
<head>
  <meta charset="UTF-8">
  <title> VOTACIONES </title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<style>
    body {
      background: linear-gradient(to right, #d4edda, #a8df8e);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
    .navbar {
      background-color: #28a745;
      border-radius: 10px;
      padding: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .nav-link {
      color: white !important;
      font-weight: bold;
      padding: 10px 15px;
      transition: background 0.3s ease;
    }
    .nav-link:hover {
      background-color: #218838;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <ul class="nav justify-content-center w-100">
        <li class="nav-item"><a class="nav-link" href="poder.php">ENTREGAR PODER</a></li>
        <li class="nav-item"><a class="nav-link" href="asistencia.php">ASISTENCIA</a></li>
        <li class="nav-item"><a class="nav-link" href="plancha.php">PLANCHAS</a></li>
        <li class="nav-item"><a class="nav-link" href="votaciones.php">VOTACIONES</a></li>
        <li class="nav-item"><a class="nav-link" href="resultados.php">RESULTADOS</a></li>
        <li class="nav-item"><a class="nav-link" href="actualizarbase.php">ACTUALIZAR</a></li>
      </ul>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>