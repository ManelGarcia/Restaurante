<?php
    $jsonObject1 = json_decode(file_get_contents("php://input"), true);
    $id_mesa = $jsonObject1['smesa'];

    include_once('../proc/conexion.php');
    try {
        $sql = $pdo -> prepare("SELECT COUNT(id_sillas) AS id_sillas FROM sillas WHERE mesa_act = :id");

        $sql -> bindParam(":id", $id_mesa);
        $sql -> execute();
        $resultado = $sql -> fetchAll(PDO::FETCH_ASSOC);

        echo $resultado[0]["id_sillas"];

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }



?>