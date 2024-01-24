<?php
$jsonObject1 = json_decode(file_get_contents("php://input"), true);
$id = $jsonObject1['id'];
$name = $jsonObject1['name'];
$user1 = $jsonObject1['user'];
$email = $jsonObject1['email'];
$type = $jsonObject1['type'];

try {
    include_once("../proc/conexion.php");

    $sql = $pdo -> prepare("SELECT * FROM usuario WHERE id_usuario = :iu");
    $sql->bindParam(':iu', $id); 
    $sql->execute(); 
    $row = $sql->fetchAll(PDO::FETCH_ASSOC); 

    // var_dump($row);

    $sql2 = $pdo -> prepare("UPDATE usuario SET usuario_us = :uu, nombre_us = :nu, email_us = :eu, tipo_us = :tu WHERE id_usuario = :iu");

    $sql2->bindParam(':iu', $id); 

    if ($row[0]['usuario_us'] !== $user1) {
        $sql2->bindParam(':uu', $user1);
    } else {
        $sql2->bindParam(':uu', $row[0]['usuario_us']);
    }

    if ($row[0]['nombre_us'] !== $name) {
        $sql2->bindParam(':nu', $name); 
    } else {
        $sql2->bindParam(':nu', $row[0]['nombre_us']);
    }

    if ($row[0]['email_us'] !== $email) {
        $sql2->bindParam(':eu', $email); 
    } else {
        $sql2->bindParam(':eu', $row[0]['email_us']);
    }

    if ($row[0]['tipo_us'] !== $type) {
        $sql2->bindParam(':tu', $type); 
    } else {
        $sql2->bindParam(':tu', $row[0]['tipo_us']);
    }

    $sql2->execute(); 

} catch (Exception $e){
    echo "Error en la conexión con la base de datos: " . $e->getMessage();
    die();
}
