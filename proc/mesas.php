<?php  
    $jsonObject1 = json_decode(file_get_contents("php://input"), true);

    if (isset($jsonObject1['selector'])) {
        $selector = $jsonObject1['selector'];
    } 
    
    $sala = $jsonObject1['sala'];


    $estado = "";

    include_once('../proc/conexion.php');
    try {

        if (isset($selector)) {
            $sql = $pdo -> prepare("SELECT * FROM mesa WHERE ubicacion_mesa = :um AND id_mesa <> :pm");
            $sql -> bindParam(":pm", $selector);

        } elseif (isset($sala)) {
            $sql = $pdo -> prepare("SELECT * FROM mesa WHERE ubicacion_mesa = :um");
        }

        $sql -> bindParam(":um", $sala);
        $sql -> execute();
        $resultado = $sql -> fetchAll(PDO::FETCH_ASSOC);

        if (isset($selector)) {
            $select = '<select name="" id="select-mesa">';
            $select .= '<option value=""></option>';

            foreach ($resultado as $valor) {
                $select .= '<option value="'.$valor['id_mesa'].'">'.$valor['nombre_mesa'].'</option>';
            }

            $select .= '</select>';

            echo $select;
        } else {
            foreach ($resultado as $valor) {

                $sql_reserva = $pdo -> prepare("SELECT * FROM reservas WHERE mesa_res = :im");
                
                $sql_reserva -> bindParam(":im", $valor['id_mesa']);
                $sql_reserva -> execute();
                $resultado_reserva = $sql_reserva -> fetchAll(PDO::FETCH_ASSOC);

                if ($valor['estado_mesa'] == 1) {
                    $clases = 'ocupado ';
                } elseif ($valor['estado_mesa'] == 2) {
                    $clases = 'libre ';
                } else {
                    $clases = 'mantenimiento ';
                }

                if (!empty($resultado_reserva)) {
                    $clases .= 'reservado';
                }

                echo '<p onclick="openAlert('.$valor['id_mesa'].', `'.$valor['nombre_mesa'].'`)" class="'.$clases.'" >hTTd</p>';
            }
        }


        

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }
?>

