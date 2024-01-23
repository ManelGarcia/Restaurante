<?php
// Inicia la sesión para poder acceder a variables de sesión
session_start();

// if ($_SESSION["username"]) {
    include_once("../proc/conexion.php");

    $sql = $pdo -> prepare("SELECT tipo_us FROM usuario WHERE usuario_us = :us");
    $sql->bindParam(':us', $_SESSION["username"]); 
    $sql->execute(); 
    $row = $sql->fetch(PDO::FETCH_ASSOC); 

    if ($row['tipo_us'] == 1) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <br>
    <?php
        $jsonObject1 = json_decode(file_get_contents("php://input"), true);

        $stmt = 'SELECT u.*, r.nombre_rol FROM usuario u INNER JOIN roles r ON u.tipo_us = r.id_rol WHERE 1=1';

        if (isset($jsonObject1['busqueda'])) {
            $filter_name = $jsonObject1['busqueda'];
            $stmt .= ' AND (u.usuario_us LIKE "%'.$filter_name.'%" OR u.nombre_us LIKE "%'.$filter_name.'%" OR u.email_us LIKE "%'.$filter_name.'%")';
        }

        if (isset($jsonObject1['orden'])) {
            $order_by = $jsonObject1['orden']; 
            $stmt .= ' ORDER BY u.'.$order_by;
        }

        $sql1 = $pdo -> prepare($stmt);
        $sql1 -> execute(); 

        echo '<table border="1"><thead><tr><th>Usuario <button onclick="sqlFiltro(\'usuario_us\')">v</button></th><th>Nombre <button onclick="sqlFiltro(\'nombre_us\')">v</button></th><th>E-Mail <button onclick="sqlFiltro(\'email_us\')">v</button></th><th>Tipo <button onclick="sqlFiltro(\'nombre_rol\')">v</button></th></tr></thead><tbody>';
        while ($row1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr><td>'.$row1['usuario_us'].'</td><td>'.$row1['nombre_us'].'</td><td>'.$row1['email_us'].'</td><td>'.$row1['nombre_rol'].'</td><td><button onclick=editarUs('.$row1['id_usuario'].')>Editar</button></td></tr>';
        }
        echo '</tbody></table>';


    ?>
    <div id='edit_us'></div>
</body>
</html>











<?php
    } else {
        header("Location: ./mostrar.php");
    }
// } else {
//     header("Location: ../index.php");
// }
