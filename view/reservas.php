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
        session_start();

        include_once("../proc/conexion.php");

        echo '<table border="1"><thead><tr><th>Inicio</th><th>Final</th><th>Sala</th><th>Mesa</th><th>Camarero</th></tr></thead><tbody>';

        $stmt1 = 'SELECT r.*, m.nombre_mesa, u.lugar, us.nombre_us FROM reservas r JOIN mesa m ON r.mesa_res = m.id_mesa JOIN ubicacion u ON u.id_ubicacion = m.ubicacion_mesa JOIN usuario us ON us.id_usuario = r.camarero_res;';

        $sql1 = $pdo -> prepare($stmt1);
        $sql1 -> execute(); 

        while ($row1 = $sql1->fetch(PDO::FETCH_ASSOC)) {
            $date = date('Y-m-d H:i:s');

            if ($row1['final_res'] < $date) {
                echo '<tr><td>'.$row1['inicio_res'].'</td><td>'.$row1['final_res'].'</td><td>'.$row1['nombre_mesa'].'</td><td>'.$row1['lugar'].'</td><td>'.$row1['nombre_us'].'</td></tr>';
            } else {
                echo '<tr><td>'.$row1['inicio_res'].'</td><td>'.$row1['final_res'].'</td><td>'.$row1['nombre_mesa'].'</td><td>'.$row1['lugar'].'</td><td>'.$row1['nombre_us'].'</td></tr>';
            }


        }

    ?>
    <div id='edit_res'></div>

</body>
</html>


