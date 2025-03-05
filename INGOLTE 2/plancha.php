<?php
include 'db-conexion.php';


$plancha = $_POST['plancha'] ?? null;


if ($plancha != null or $plancha != '') {
  $sqlPlancha = "INSERT INTO plancha (Nombre) VALUES ('$plancha')";

  $ejecutar = mysqli_query($conexion, $sqlPlancha);

  if (!$ejecutar) {
    echo "Hubo un error";

  } else {
    echo '<script>
    alert("Se registro la pagina con exito");
    </script>';

  }
}

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
  <div>
    <br>
    <h1>Registro de Candidatos</h1>

    <form class="formulario" method="post">
      <p>Este formulario registrará las planchas o candidatos para las votaciones.
      </p>

      <input type="text" name="plancha" placeholder="Nombre de plancha o candidato" required="required" />

      <button type="submit" class="btn btn-primary btn-block btn-large">Registrar</button>
      <!--<button type="submit" class="btn btn-primary btn-block btn-large">Eliminar Registros</button>-->
    </form>
    <form action="borrarRegistros.php" class="botbajito">
      <button type="submit" class="btn btn-primary btn-large">Eliminar</button>
    </form>
  </div>

  <footer>
<?php
$sqlConsultasPlanchas = "SELECT  Nombre  FROM plancha";
$ejectPlancha = mysqli_query($conexion, $sqlConsultasPlanchas);


echo'<p>PLANCHAS DISPONIBLES PARA LAS VOTACIONES </p>&emsp;';
while ($row = mysqli_fetch_array($ejectPlancha)) {

  echo '<label>' . $row['Nombre'] . '</label>&emsp;&emsp;';

}




?>


  </footer>

</body>