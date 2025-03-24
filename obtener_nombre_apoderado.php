<?php
include './logica/db-conexion.php';

$cedula = $_GET['cedula'] ?? null;

// Verificar si se recibe la cédula
if ($cedula) {
    // Elimina espacios adicionales en la cédula
    $cedula = trim($cedula);

    // Usar prepared statements para evitar inyecciones SQL
    $sql = "SELECT nombre FROM base WHERE cedula = ?";
    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $cedula);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Verificar si se obtuvo algún resultado
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo json_encode([
                'success' => true,
                'nombre' => $row['nombre']
            ]);
        } else {
            // Si no se encuentra el apoderado
            echo json_encode([
                'success' => false,
                'error' => 'No se encontró el apoderado con esa cédula.'
            ]);
        }

        mysqli_stmt_close($stmt);
    } else {
        // Si hubo un error al preparar la consulta
        echo json_encode([
            'success' => false,
            'error' => 'Error en la preparación de la consulta SQL: ' . mysqli_error($conexion)
        ]);
    }
} else {
    // Si no se recibe la cédula
    echo json_encode([
        'success' => false,
        'error' => 'Cédula no proporcionada.'
    ]);
}

mysqli_close($conexion);
?>
