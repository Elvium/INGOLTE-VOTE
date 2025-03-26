<?php
include './logica/db-conexion.php';
session_start();

header('Content-Type: application/json'); // Aseguramos que la respuesta será JSON

$response = array('success' => false, 'message' => ''); // Inicializamos la respuesta por defecto

if (!$conexion) {
    $response['message'] = 'Error de conexión a la base de datos: ' . mysqli_connect_error();
    echo json_encode($response);
    exit;
}

$ccSocio = $_POST['ccSocio'] ?? null;
$plancha = $_POST['plancha'] ?? null;

if ($ccSocio && $plancha) {
    // Verificar si el votante existe en la tabla "asistencia"
    $sqlestaAsistencia = "SELECT Nombre, Voto, Acciones FROM asistencia WHERE Cedula = '$ccSocio'";
    $comprobadorAsistencia = mysqli_query($conexion, $sqlestaAsistencia);

    if ($row = $comprobadorAsistencia->fetch_assoc()) {
        $comprobador = $row['Nombre'];
        $voto = $row['Voto'];
        $cantAcciones = $row['Acciones'];

        // Si el votante no ha votado y tiene acciones disponibles
        if ($voto == 0 && $cantAcciones > 0) {
            // Insertamos el voto en la tabla "votaciones"
            $sqlVotacion = "INSERT INTO votaciones (Cedula, Nombre, Plancha, Acciones) VALUES ('$ccSocio', '$comprobador', '$plancha', '$cantAcciones')";
            $Ejecutar2 = mysqli_query($conexion, $sqlVotacion);

            if ($Ejecutar2) {
                // Actualizamos el estado de "voto" a 1 en la tabla "asistencia"
                $sqlSiVoto = "UPDATE asistencia SET Voto = 1 WHERE Cedula = '$ccSocio'";
                mysqli_query($conexion, $sqlSiVoto);

                // Actualizamos las acciones de la plancha
                $sqlcalcularVotacion = "UPDATE plancha SET TotalAcciones = TotalAcciones + $cantAcciones WHERE ID = '$plancha'";
                mysqli_query($conexion, $sqlcalcularVotacion);

                // Si todo se ha hecho correctamente, devolvemos un JSON con la respuesta
                $response['success'] = true;
                $response['message'] = 'Voto registrado correctamente';
                $response['plancha'] = 'Plancha ' . $plancha; // Se puede mejorar para devolver el nombre real de la plancha
                $response['cantAcciones'] = $cantAcciones;
            } else {
                $response['message'] = 'Error al insertar el voto: ' . mysqli_error($conexion);
            }
        } else {
            $response['message'] = 'El accionista ya votó o no tiene acciones disponibles.';
        }
    } else {
        $response['message'] = 'El accionista no está registrado en asistencia.';
    }
} else {
    $response['message'] = 'Datos de votación incompletos.';
}

echo json_encode($response); // Devolvemos la respuesta en formato JSON
?>
