<?php
include 'db-conexion.php';

$ccSocio = $_POST['ccSocio'] ?? null;
$Apoderado = $_POST['ccApoderado'] ?? null;
$nm = $_POST['nm'] ?? null;
$cantidadAccionesApoderado = 0;
$accionesPermiso = 0;
$fecha = $_POST['fecha'] ?? null;

if ($ccSocio != null) {
    $sqlApoderadoPermitido = "SELECT sum(Acciones) AS permiso FROM base WHERE Apoderado='$Apoderado'";
    $permiso = mysqli_query($conexion, $sqlApoderadoPermitido);

    $sqlAlerta = "SELECT Nombre, Acciones FROM base WHERE Cedula='$ccSocio'";
    $alerta = mysqli_query($conexion, $sqlAlerta);

    if ($row1 = $alerta->fetch_assoc()) {
        $name = $row1['Nombre'];
        $accionescant = $row1['Acciones'];

        if ($row2 = $permiso->fetch_assoc()) {
            $accionesPermiso = intval($row2['permiso']) + intval($accionescant);

            if ($accionesPermiso < 250) {
                $nm = strtoupper($nm);

                $sqlSocio = "UPDATE base SET Poder = 1, Apoderado='$Apoderado', nmApoderado='$nm' WHERE Cedula='$ccSocio'";
                $ejecutar = mysqli_query($conexion, $sqlSocio);

                if (!$ejecutar) {
                    echo '<script>alert("NO SE ENCONTRO AL ACCIONISTA EN LA BASE DE DATOS");</script>';
                } else {
                    $sqlPoder = "INSERT INTO poderes (ccAccionista, nmAccionista, ccApoderado, nmApoderado, nAcciones, fecha) 
                                 VALUES ($ccSocio, '$name', $Apoderado, '$nm', $accionescant, '$fecha')";

                    $queryPoderes = mysqli_query($conexion, $sqlPoder);

                    echo '<script>alert("EL ACCIONISTA  ' . $name . '  DIO UN PODER DE  ' . $accionescant . '  ACCIONES AL APODERADO  ' . $nm . '");</script>';
                }
            } else {
                echo '<script>alert("EL APODERADO SUPERARIA EL MAXIMO DE 250 ACCIONES '.$accionesPermiso.'");</script>';
            }
        } else {
            echo '<script>alert("ERROR INESPERADO CON LA BASE DE DATOS");</script>';
        }
    } else {
        echo '<script>alert("NO SE ENCONTRO SOCIO CON ESA CEDULA");</script>';
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
        <h2 class="text-center text-success">Entregar Poder</h2>
        <p class="text-center">El accionista le confiere sus acciones al apoderado.</p>

        <form method="post">
            <div class="mb-3">
                <input type="text" name="ccSocio" class="form-control" placeholder="Cédula Socio" required />
            </div>
            <div class="mb-3">
                <input type="text" name="ccApoderado" class="form-control" placeholder="Cédula Apoderado" required />
            </div>
            <div class="mb-3">
                <input type="date" name="fecha" class="form-control" value="2023-10-31" min="2023-10-01" max="2023-11-01" />
            </div>
            <button type="submit" class="btn btn-custom w-100">Confirmar</button>
        </form>

        <form action="impresAccionistas.php" class="mt-3">
            <button type="submit" class="btn btn-custom w-100">Generar Reporte</button>
        </form>
    </div>

    <footer class="footer">
        <?php
        $sqlSocioActual = "SELECT count(*) as tconteo, sum(Acciones) as tacciones, sum(Poder) as tPoder FROM base";
        $ejecucionConteo = mysqli_query($conexion, $sqlSocioActual);
        $sqlconsultaApoderado = "SELECT sum(Acciones) as tPoderes FROM base WHERE Poder=1";
        $ejecucionConteoApoderado = mysqli_query($conexion, $sqlconsultaApoderado);

        if ($row = $ejecucionConteoApoderado->fetch_assoc()) {
            $cantidadAccionesApoderado += $row['tPoderes'];
        }

        if ($row = $ejecucionConteo->fetch_assoc()) {
            echo "<p>Accionistas: <strong>" . number_format($row['tconteo']) . "</strong> | Acciones: <strong>" . number_format($row['tacciones']) . "</strong></p>";
            echo "<p>Apoderados: <strong>" . number_format($row['tPoder']) . "</strong> | Acciones: <strong>" . number_format($cantidadAccionesApoderado) . "</strong></p>";
        }
        ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
