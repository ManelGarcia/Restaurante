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
        echo '<table border="1"><thead><tr><th>Nombre/Identificacion</th><th>Tipo</th><th>Ubicacion</th><th>Mantenimiento</th></tr></thead><tbody>';

        $stmt1 = 'SELECT m.*, u.lugar AS ubicacion_mesa
        FROM mesa m
        JOIN ubicacion u ON m.ubicacion_mesa = u.id_ubicacion;
        ';

        $sql1 = $pdo -> prepare($stmt1);
        $sql1 -> execute(); 

        while ($row1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr><td>'.$row1['nombre_mesa'].'</td><td>Mesa</td><td>'.$row1['ubicacion_mesa'].'</td><td><button onclick="manten('.$row1['id_mesa'].')">Mantenimiento</button></td></tr>';
        }


        $stmt2 = 'SELECT s.*, u.lugar AS ubicacion_silla
        FROM sillas s
        JOIN mesa m ON s.mesa_asig = m.id_mesa
        JOIN ubicacion u ON m.ubicacion_mesa = u.id_ubicacion;
        ';

        $sql2 = $pdo -> prepare($stmt2);
        $sql2 -> execute(); 

        while ($row2 = $sql2->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr><td>'.$row2['id_sillas'].'</td><td>Silla</td><td>'.$row2['ubicacion_silla'].'</td></tr>';
        }
        echo '</tbody></table>';
    ?>
</body>
</html>

<?php
    } else {
        header("Location: ./mostrar.php");
    }
// } else {
//     header("Location: ../index.php");
// }
