<?php 
session_start();

$jsonObject = json_decode(file_get_contents("php://input"), true);

$idMesa = $jsonObject['id_mesa'];

if (isset($jsonObject['mesaPlus']) && isset($jsonObject['sillaPlus'])) {
    $mesaPlus = $jsonObject['mesaPlus'];
    $sillaPlus = $jsonObject['sillaPlus'];
}

if ($jsonObject['accion'] == 'reservar') {
    $fechaIni = $jsonObject['fechaIni'];
    $horaIni = $jsonObject['horaIni'];

} elseif ($jsonObject['accion'] == 'ocupar') {
    $fechaHora = date('Y-m-d H:i');
}

include_once('./conexion.php');

try {

    // Obtiene el estado actual de la mesa
    $sql = $pdo -> prepare("SELECT estado_mesa FROM mesa WHERE id_mesa = :im");
    $sql -> bindParam(":im", $idMesa);
    $sql -> execute();
    $resultado = $sql -> fetchAll(PDO::FETCH_ASSOC);

    $sql2 = $pdo -> prepare("SELECT id_usuario FROM usuario WHERE usuario_us = :uu");

    $sql2 -> bindParam(":uu", $_SESSION['username']);
    $sql2 -> execute();
    $resultado2 = $sql2 -> fetchAll(PDO::FETCH_ASSOC);

    // echo $_SESSION['username'].' | ';
    // var_dump($resultado2);

    if ($jsonObject['accion'] == 'ocupar') {
        if ($resultado[0]['estado_mesa'] == 1) {
            $sql3 = $pdo -> prepare("UPDATE mesa SET estado_mesa = 2 WHERE id_mesa = :im");
    
            $sql3 -> bindParam(":im", $idMesa);
            $sql3 -> execute();    

            $sql_update_tiempo = $pdo -> prepare("UPDATE tiempo SET final_tmp = :ta WHERE mesa_tmp = :im AND camarero_tmp = :ic AND final_tmp IS NULL");

            $sql_update_tiempo -> bindParam(":ta", $fechaHora);
            $sql_update_tiempo -> bindParam(":im", $idMesa);
            $sql_update_tiempo -> bindParam(":ic", $resultado2[0]['id_usuario']);
    
            $sql_update_tiempo -> execute();

    
        } elseif ($resultado[0]['estado_mesa'] == 2 || $resultado[0]['estado_mesa'] == 3) {
            $sql3 = $pdo -> prepare("UPDATE mesa SET estado_mesa = 1 WHERE id_mesa = :im");
    
            $sql3 -> bindParam(":im", $idMesa);
            $sql3 -> execute();

            $sql_insert_tiempo = $pdo -> prepare("INSERT INTO tiempo (inicio_tmp, mesa_tmp, camarero_tmp) VALUES (:ta, :im, :ic)");

            $sql_insert_tiempo -> bindParam(":ta", $fechaHora);
            $sql_insert_tiempo -> bindParam(":im", $idMesa);
            $sql_insert_tiempo -> bindParam(":ic", $resultado2[0]['id_usuario']);
    
            $sql_insert_tiempo -> execute();
        }
    } elseif ($jsonObject['accion'] == 'reservar') {
        
    }





} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}










?>