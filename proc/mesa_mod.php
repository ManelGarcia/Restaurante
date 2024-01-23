<?php 
    $jsonObject1 = json_decode(file_get_contents("php://input"), true);

    $id = $jsonObject1['id'];

    include_once('../proc/conexion.php');

    $stmt = 'SELECT estado_mesa FROM mesa WHERE id_mesa = :im';

    $sql = $pdo -> prepare($stmt);
    $sql -> bindParam(":im", $id);
    $sql -> execute(); 

    $res = $sql -> fetchAll(PDO::FETCH_ASSOC);

    if ($res[0]['estado_mesa'] == 3) {
        $stmt1 = 'UPDATE mesa SET estado_mesa = 2 WHERE id_mesa = :im';
    } else {
        $stmt1 = 'UPDATE mesa SET estado_mesa = 3 WHERE id_mesa = :im';
    }

    $sql1 = $pdo -> prepare($stmt1);
    $sql1 -> bindParam(":im", $id);
    $sql1 -> execute(); 
?>