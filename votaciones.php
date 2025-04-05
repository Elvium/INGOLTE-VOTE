<?php
include './logica/db-conexion.php';
include './logica/configSesion.php';

session_start();

// Obtener el número de votantes actuales para mostrarlo en el pie de página
$sqlcantVotantes = "SELECT COUNT(*) as vot FROM votaciones";
$ejectvota = mysqli_query($conexion, $sqlcantVotantes);

$votantesActuales = 0;
if ($row = mysqli_fetch_array($ejectvota)) {
    $votantesActuales = $row['vot'];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

    <style>
        body {
            background: linear-gradient(to right, #d4edda, #a8df8e);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
            color: white;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        .grid-item {
            background: #e9f5e9;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .grid-item label {
            font-weight: bold;
        }
        .footer {
            background-color: #28a745;
            color: white;
            padding: 15px;
            text-align: center;
            margin-top: auto;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
        }
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
    </style>
</head>
<body>

    <!-- Botón Volver -->
    <a href="admin.php" class="btn-back">
        <i class="bi bi-arrow-left"></i> Volver
    </a>

    <div class="container-form">
        <h2 class="text-center text-success">Votación</h2>
        
        <form method="post" id="formVotacion">
            <div class="mb-3">
                <input type="text" name="ccSocio" class="form-control" placeholder="Cédula del Votante" required />
            </div>

            <div class="grid-container">
                <?php
                    $sqlcandidatos = "SELECT * FROM plancha";
                    $ejecucionCandidatos = mysqli_query($conexion, $sqlcandidatos);

                    while ($row = mysqli_fetch_array($ejecucionCandidatos)) {
                        echo '<div class="grid-item">
                                <label>' . $row['Nombre'] . '</label><br> 
                                <input type="radio" name="plancha" value="' . $row['ID'] . '" required>
                              </div>';
                    }
                ?>
            </div>

            <button type="submit" class="btn btn-custom w-100 mt-3">Votar</button>
        </form>
    </div>

    <footer class="footer">
        <p>Votantes Actuales: <strong><?php echo number_format($votantesActuales); ?></strong></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('formVotacion').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar que el formulario se envíe de inmediato

            const ccSocio = document.querySelector('input[name="ccSocio"]').value;
            const plancha = document.querySelector('input[name="plancha"]:checked').value;

            // Realizar la solicitud AJAX para obtener los detalles del voto
            fetch('obtener_detalles_voto.php', {
                method: 'POST',
                body: new URLSearchParams({
                    ccSocio: ccSocio,
                    plancha: plancha
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
    // Crear contenido de la impresión del ticket con la clase 'ticket'
    const ticket = `
        <div class="ticket">
            <h3>Votación Confirmada</h3>
            <p><strong>Plancha:</strong> ${data.plancha}</p>
            <p><strong>Acciones:</strong> ${data.cantAcciones}</p>
        </div>
    `;
    const printWindow = window.open('', '_blank', 'width=300,height=300');
    printWindow.document.write(ticket);
    printWindow.document.close();
    
    printWindow.print();

    setTimeout(function() {
        window.location.href = 'votaciones.php';
    }, 2000); // Espera 2 segundos antes de redirigir
} else {
    alert('Error: ' + data.message);
}
})

            .catch(error => {
                alert('Error al realizar la solicitud: ' + error);
            });
        });
    </script>

</body>
<?php
mysqli_close($conexion);
?>

</html>
