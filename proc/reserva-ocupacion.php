<?php 
$jsonObject = json_decode(file_get_contents("php://input"), true);

$idMesa = $jsonObject['id_mesa'];

if (isset($jsonObject['fechaIni']) && isset($jsonObject['horaIni'])) {
    $fechaIni = $jsonObject['fechaIni'];
    $horaIni = $jsonObject['horaIni'];
} else {
    $fechaIni = date('Y-m-d');
    $horaIni = date('H:i');
}

if (isset($jsonObject['mesaPlus']) && isset($jsonObject['sillaPlus'])) {
    $mesaPlus = $jsonObject['mesaPlus'];
    $sillaPlus = $jsonObject['sillaPlus'];
}


include_once('./conexion.php');

try {

    // Obtiene el estado actual de la mesa
    $sql = $pdo -> prepare("SELECT estado_mesa FROM mesa WHERE id_mesa = :im");
    $sql -> bindParam(":im", $idMesa);
    $sql -> execute();
    $resultado = $sql -> fetchAll(PDO::FETCH_ASSOC);

    if ($resultado[0]['estado_mesa'] == 1) {
        $sql2 = $pdo -> prepare("UPDATE mesa SET estado_mesa = 2 WHERE id_mesa = :im");

        $sql2 -> bindParam(":im", $idMesa);
        $sql2 -> execute();    

    } elseif ($resultado[0]['estado_mesa'] == 2 || $resultado[0]['estado_mesa'] == 3) {
        $sql2 = $pdo -> prepare("UPDATE mesa SET estado_mesa = 1 WHERE id_mesa = :im");

        $sql2 -> bindParam(":im", $idMesa);
        $sql2 -> execute();    

    }

    $sql3 = $pdo -> prepare("SELECT id_usuario FROM usuario WHERE usuario_us = :uu");

    $sql3 -> bindParam(":uu", $_SESSION['username']);
    $sql3 -> execute();
    $resultado3 = $sql3 -> fetchAll(PDO::FETCH_ASSOC);


} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}










?>