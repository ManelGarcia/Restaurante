<?php  
    echo '<div class="sala_res">';
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
                $sql_reserva = $pdo -> prepare("SELECT * FROM reservas WHERE mesa_res = :im AND CURRENT_TIMESTAMP < inicio_res");
                
                $sql_reserva -> bindParam(":im", $valor['id_mesa']);
                $sql_reserva -> execute();
                $resultado_reserva = $sql_reserva -> fetchAll(PDO::FETCH_ASSOC);

                $sql_reserva2 = $pdo -> prepare("SELECT * FROM reservas WHERE mesa_res = :im AND CURRENT_TIMESTAMP > inicio_res AND CURRENT_TIMESTAMP < final_res");
                
                $sql_reserva2 -> bindParam(":im", $valor['id_mesa']);
                $sql_reserva2 -> execute();
                $resultado_reserva2 = $sql_reserva2 -> fetchAll(PDO::FETCH_ASSOC);

                $sql_reserva3 = $pdo -> prepare("SELECT * FROM reservas WHERE mesa_res = :im ORDER BY inicio_res");
                
                $sql_reserva3 -> bindParam(":im", $valor['id_mesa']);
                $sql_reserva3 -> execute();
                $resultado_reserva3 = $sql_reserva3 -> fetchAll(PDO::FETCH_ASSOC);
                
                $titulo = '';
                if (!empty($resultado_reserva3)) {
                    foreach ($resultado_reserva3 as $i => $value) {
                        $titulo .= 'Reserva'.$resultado_reserva3[$i]['id_reservas'].': '.$resultado_reserva3[$i]['inicio_res'].' - '.$resultado_reserva3[$i]['final_res'].' | ';
                    }
                } else {
                    $titulo = null;
                }


                $mantenimiento = null;
                $clases = null;

                if ($valor['estado_mesa'] == 1) {
                    $clases = 'ocupado ';
                }elseif (!empty($resultado_reserva2)) {
                    $clases .= 'reservado-now ';
                } elseif ($valor['estado_mesa'] == 2 && empty($resultado_reserva2)) {
                    $clases = 'libre ';
                } elseif ($valor['estado_mesa'] == 3) {
                    $clases = 'mantenimiento ';
                    $mantenimiento = 1;
                }

                if (!empty($resultado_reserva)) {
                    $clases .= 'reservado ';
                }

                $res = null;
                $sum = null;

                if (($valor['nca_as'] - $valor['nca_ac']) > 0) {
                    $res = $valor['nca_as'] - $valor['nca_ac'];
                } elseif (($valor['nca_as'] - $valor['nca_ac']) < 0) {
                    $sum = $valor['nca_as'] - $valor['nca_ac'];
                }

                $sillas = null;
                if (($valor['nca_as']) != 0) {
                    for ($i = 0; $i < $valor['nca_as']; $i++) {
                        $sillas .= '<div class="silla"></div>';
                    }
                }

                // var_dump($resultado_reserva3);
                                
                if (isset($mantenimiento)) {
                    echo '<div class="' . $clases . '")">';
                } else {
                    echo '<div class="' . $clases . '" onclick="openAlert(' . $valor['id_mesa'] . ', \'' . $valor['nombre_mesa'] . '\')" title="'.$titulo.'">';
                }

                if (isset($res)) {
                    echo '<h1>+'.$res.'</h1>';
                } else {
                    echo ' ';
                }

                echo '</div>';
            }
        }
        echo '</div>'; 


        

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }
?>

