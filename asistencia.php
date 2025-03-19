<?php
include 'db-conexion.php';

$ccAsistencia = $_POST['cc'] ?? null;
$ccConsulta = $_POST['consulta'] ?? null;
$accion = 0;
$acciones = 0;

if ($ccAsistencia != null) {
    $sqlSociodioPoder = "SELECT Cedula,Nombre, Apoderado, Acciones FROM base WHERE Poder = 1 and CEDULA ='$ccAsistencia'";
    $consultaSocioApoderado = mysqli_query($conexion, $sqlSociodioPoder);

    if ($row = $consultaSocioApoderado->fetch_assoc()) {
        $cc = $row['Cedula'];
        $nombreAsistente = $row['Nombre'];
        $Apoderado = $row['Apoderado'];
        $acc = $row['Acciones'];

        if (!empty($cc)) {
            $sqlactualizarSocio = "UPDATE base SET Poder = 0, Apoderado= NULL, nmApoderado=NULL  WHERE Cedula='$cc'";
            $ejecutar1 = mysqli_query($conexion, $sqlactualizarSocio);
            $sqlactualizarAsistencia = "UPDATE asistencia SET Acciones = Acciones - $acc  WHERE Cedula='$Apoderado'";
            $ejecutar2 = mysqli_query($conexion, $sqlactualizarAsistencia);
        }
    }

    $sqlBusquedaAccionesApoderado = "SELECT SUM(Acciones) as total, nmApoderado as nm FROM base WHERE Apoderado= '$ccAsistencia'";
    $consulta1 = mysqli_query($conexion, $sqlBusquedaAccionesApoderado);

    if ($row = $consulta1->fetch_assoc()) {
        $acciones = $row['total'];
        $nombreAsistente = $row['nm'];
    }

    $sqlBusquedaAccionesSocio = "SELECT Acciones , Nombre FROM base WHERE Cedula = '$ccAsistencia'";
    $consulta2 = mysqli_query($conexion, $sqlBusquedaAccionesSocio);

    if ($row = $consulta2->fetch_assoc()) {
        $acciones += $row['Acciones'];
        $nombreAsistente = $row['Nombre'];
    }

    if ($acciones != 0) {
        $sqlAsistencia = "INSERT INTO asistencia (Cedula,Nombre,Acciones) VALUES ($ccAsistencia,'$nombreAsistente',$acciones)";
        $ejecutar = mysqli_query($conexion, $sqlAsistencia);

        if (!$ejecutar) {
            echo '<script>alert("ERROR INESPERADO");</script>';
        } else {
            echo '<script>alert("BIENVENIDO A LAS VOTACIONES ' . $nombreAsistente . '");</script>';
        }
    } else {
        echo '<script>alert("ESTE ACCIONISTA NO CUENTA CON ACCIONES");</script>';
    }
} elseif ($ccConsulta != null) {
    $sqlConsultaAcciones = "SELECT Nombre , Acciones FROM asistencia WHERE Cedula='$ccConsulta'";
    $accionesActuales = mysqli_query($conexion, $sqlConsultaAcciones);

    if ($row = $accionesActuales->fetch_assoc()) {
        echo '<script>alert("LA CANTIDAD DE ACCIONES DE '.$row['Nombre'].'  SON '.$row['Acciones'].'");</script>';
    } else {
        echo '<script>alert("EL SOCIO NO SE ENCUENTRA REGISTRADO EN ASISTENCIA");</script>';
    }
}
?>

<head>
    <meta charset="UTF-8">
    <title> VOTACIONES </title>
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
            max-width: 400px;
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
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            margin-top: auto;
        }
        /* Estilo para el botón de volver */
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

    <!-- Botón de Volver -->
    <form action="admin.php">
        <button type="submit" class="btn-volver">
            <i class="bi bi-arrow-left"></i> Volver
        </button>
    </form>

    <div class="container-form">
        <h2 class="text-center text-success">Asistencia</h2>
        <form method="post">
            <div class="mb-3">
                <input type="text" name="cc" class="form-control" placeholder="Cédula" required />
            </div>
            <button type="submit" class="btn btn-custom w-100">Confirmar</button>
        </form>

        <form action="impresAsistentes.php" class="mt-3">
            <button type="submit" class="btn btn-custom w-100">Generar Reporte</button>
        </form>
    </div>

    <div class="container-form mt-4">
        <h5 class="text-center text-success">Consulta de Acciones Actuales</h5>
        <form method="post">
            <div class="mb-3">
                <input type="text" name="consulta" class="form-control" placeholder="Cédula" required />
            </div>
            <button type="submit" class="btn btn-custom w-100">Consultar</button>
        </form>
    </div>

    <footer class="footer">
        <?php
        $sqlAsistenciaActual = "SELECT count(*) as tasistencia, sum(Acciones) as tacciones FROM asistencia";
        $ejecucionAsistencia = mysqli_query($conexion, $sqlAsistenciaActual);

        if ($row = $ejecucionAsistencia->fetch_assoc()) {
            $asist = $row['tasistencia'];
            $accion += $row['tacciones'];
        }

        echo "<p>Asistentes: <strong>" . number_format($asist) . "</strong> | Acciones Representadas: <strong>" . number_format($accion) . "</strong></p>";
        ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
