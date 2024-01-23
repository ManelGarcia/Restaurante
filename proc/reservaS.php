<?php 
    $jsonObject1 = json_decode(file_get_contents("php://input"), true);

    $id = $jsonObject1['id'];

    include_once('../proc/conexion.php');

    $stmt = 'SELECT * FROM mesa WHERE mesa_res = :im';

    $sql = $pdo -> prepare($stmt);
    $sql -> bindParam(":im", $id);
    $sql -> execute(); 

    $res = $sql -> fetchAll(PDO::FETCH_ASSOC);

    echo $res[0]['estado_mesa'];
?>