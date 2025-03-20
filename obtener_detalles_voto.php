<?php
include 'db-conexion.php';

$ccSocio = $_POST['ccSocio'] ?? null;
$plancha = $_POST['plancha'] ?? null;

$response = ['success' => false];

if ($ccSocio && $plancha) {
    // Obtener el nombre de la plancha y las acciones
    $sql = "SELECT p.nombre, a.acciones FROM plancha p 
            JOIN asistencia a ON p.id = '$plancha' 
            WHERE a.cedula = '$ccSocio'";
    $result = mysqli_query($conexion, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $response['success'] = true;
        $response['plancha'] = $row['nombre'];
        $response['cantAcciones'] = $row['acciones'];
    }
}

echo json_encode($response);
?>
