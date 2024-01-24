<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="overlay">
        <div class="alert-box">
            <?php 
                $jsonObject1 = json_decode(file_get_contents("php://input"), true);
                $id = $jsonObject1['id'];

                include_once("../proc/conexion.php");

                $sql = $pdo -> prepare("SELECT u.*, r.nombre_rol FROM usuario u INNER JOIN roles r ON r.id_rol = u.tipo_us WHERE u.id_usuario = :iu");
                $sql->bindParam(':iu', $id); 
                $sql->execute(); 
                $row = $sql->fetch(PDO::FETCH_ASSOC); 

                // var_dump($row);

                $sql_rol = $pdo->prepare("SELECT * FROM roles");
                $sql_rol->execute();
                $rows_rol = $sql_rol->fetchAll(PDO::FETCH_ASSOC);

                // var_dump($row_rol);

            ?>
            <form action="">
                <input type="hidden" id="id_user" value="<?php echo $id ?>">
                <label for="usuario_us">Usuario</label>
                <input type="text" name="user" id="usuario_us" value="<?php echo $row['usuario_us'] ?>"><br>
                <label for="nombre_us">Nombre</label>
                <input type="text" name="name" id="nombre_us" value="<?php echo $row['nombre_us'] ?>"><br>
                <label for="email_us">E-mail</label>
                <input type="text" name="email" id="email_us" value="<?php echo $row['email_us'] ?>"><br>
                <label for="tipo_us">Tipo</label>
                <select name="type" id="tipo_us">
                    <?php
                        foreach ($rows_rol as $value) {
                            if ($value['id_rol'] == $row['tipo_us'] ) {
                                echo '<option value="' . $value['id_rol'] . '" selected>' . $value['nombre_rol'] . '</option>';
                            } else {
                                echo '<option value="' . $value['id_rol'] . '">' . $value['nombre_rol'] . '</option>';
                            }
                        }
                    ?>
                </select>
                <input type="button" onclick=changeUs() value='Enviar'>
            </form>
            <button class="close-btn" onclick="closeAlertUs()">Cancelar</button>
        </div>
    </div>
</body>
</html>