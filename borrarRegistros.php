<?php
include 'db-conexion.php';

$sqlBorrarVotaciones = "DELETE FROM votaciones";
$borrado1 = mysqli_query($conexion, $sqlBorrarVotaciones);
$sqlBorrarPlanchas = "DELETE FROM plancha";
$borrado2 = mysqli_query($conexion, $sqlBorrarPlanchas);
$sqlRefresh = "SELECT Cedula FROM asistencia";
$refresh1 = mysqli_query($conexion, $sqlRefresh);

while ($row = mysqli_fetch_array($refresh1)) {

    $cedulaRefresh = $row['Cedula'];
    $accionesRefresh = 0;

    //si es socio, obtiene sus acciones de una vez
    $sqlesSocio = "SELECT * FROM base WHERE Cedula= '$cedulaRefresh'";
    $siesSocio = mysqli_query($conexion, $sqlesSocio);
    if ($row1 = mysqli_fetch_assoc($siesSocio)) {
        $accionesRefresh += intval($row1['Acciones']);
    }

    //reviso si es Apoderado
    $sqlApoderado = "SELECT Cedula,Acciones FROM base WHERE Apoderado ='$cedulaRefresh'";
    $validarPoderApoderado = mysqli_query($conexion, $sqlApoderado);

    while ($row2 = mysqli_fetch_array($validarPoderApoderado)) {
        //sumar las acciones en la variable cada vez que encuentre que es apoderado de alguien
        $accionesRefresh += intval($row2['Acciones']);
        $cc = $row2['Cedula'];
        //preguntar si el socio esta como asistente
        $sqlSocioPresente = "SELECT Cedula FROM asistencia WHERE Cedula ='$cc'";
        $siestaspresente = mysqli_query($conexion, $sqlSocioPresente);
        if ($row3 = mysqli_fetch_assoc($siestaspresente)) {
            //si el socio asistio, buscar sus acciones y restarselas al apoderado
            $cc1 = $row3['Cedula'];
            $sqlsisepresento = "SELECT Acciones FROM base WHERE Cedula ='$cc1'";
            $resta = mysqli_query($conexion, $sqlsisepresento);

            //se realiza la resta
            if ($row4 = mysqli_fetch_assoc($resta)) {
                $accionesRefresh -= intval($row4['Acciones']);
            }
        }
    }
    $sqlActualizacionAsistencia = "UPDATE asistencia SET Acciones='$accionesRefresh' WHERE Cedula='$cedulaRefresh'";
}

header('Location: http://votaringolte.online/plancha.php');
          exit;


?>