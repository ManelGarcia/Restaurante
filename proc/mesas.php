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
            $sql = $pdo -> prepare("SELECT m.*, COUNT(DISTINCT sr_asig.id_sillas) AS nca_as, COUNT(DISTINCT sr_act.id_sillas) AS nca_ac FROM mesa m LEFT JOIN sillas sr_asig ON m.id_mesa = sr_asig.mesa_asig LEFT JOIN sillas sr_act ON m.id_mesa = sr_act.mesa_act WHERE ubicacion_mesa = :um GROUP BY m.id_mesa, m.nombre_mesa, m.estado_mesa, m.ubicacion_mesa;");
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

                // var_dump($resultado);

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

                if (($valor['nca_as'] - $valor['nca_ac']) > 1) {
                    $res = $valor['nca_as'] - $valor['nca_ac'];
                } elseif (($valor['nca_as'] - $valor['nca_ac']) < 1) {
                    $sum = $valor['nca_as'] - $valor['nca_ac'];
                }

                $sillas = null;
                if (($valor['nca_as']) != 0) {
                    for ($i = 0; $i < $valor['nca_as']; $i++) {
                        $sillas .= 'h';
                    }
                }

                echo '<p onclick="openAlert('.$valor['id_mesa'].', `'.$valor['nombre_mesa'].'`)" class="'.$clases.'" >'.$sillas.' TT</p>';
            }
        }


        

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }
?>

