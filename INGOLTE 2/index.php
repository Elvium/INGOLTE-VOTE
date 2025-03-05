<?php
include 'db-conexion.php';

$cc = $_POST['cc'] ?? null;
$pass = $_POST['p'] ?? null;

if ($cc != null && $pass != null) {


  $sqllogin = "SELECT username, pss, rol FROM usingolte WHERE username='$cc'";
  $alerta = mysqli_query($conexion, $sqllogin);

  if (!$alerta) {
    echo '<script>
    alert("Error al iniciar Sesion");
    </script>';

  } else {


    if ($row = $alerta->fetch_assoc()) {

      if ($row['pss'] == $pass) {

        if ($row['rol'] == 'poder') {

          header('Location: http://votaringolte.online/asistencia.php');
          exit;

        } elseif ($row['rol'] == 'admin') {
          header('Location: http://votaringolte.online/admin.php');
          exit;
        } elseif ($row['rol'] == 'plancha') {
          header('Location: http://votaringolte.online/plancha.php');
          exit;
        } elseif ($row['rol'] == 'resultado') {
          header('Location: http://votaringolte.online/resultados.php');
          exit;
        } else {
          header('Location: http://votaringolte.online/votaciones.php');
          exit;
        }
      } else {
        echo '<script>
        alert("Usuario o Contraseña erroneo");
        </script>';

      }
    }

  }


}





?>


<head>
  <meta charset="UTF-8">
  <title> VOTACIONES </title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
  <br>
  <h1>Login</h1>
  <div class="formulario">

    <form method="post">
      <input type="text" name="cc" placeholder="Usuario" required="required" />
      <input type="password" name="p" placeholder="Contraseña" required="required" />
      <button type="submit" class="btn btn-primary btn-block btn-large">Entrar</button>
    </form>
  </div>
</body>