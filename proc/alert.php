<?php             
    include_once('../proc/conexion.php');

    $jsonObject1 = json_decode(file_get_contents("php://input"), true);

    $selMesa = $jsonObject1['idmesa'];
    $nombreMesa = $jsonObject1['nombremesa'];

    $sql2 = $pdo -> prepare("SELECT COUNT(id_sillas) AS id_sillas, mesa_act FROM sillas WHERE mesa_act = :mi");

    $sql2 -> bindParam(":mi", $selMesa);
    $sql2 -> execute();
    $resultado2 = $sql2 -> fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultado2 as $valor2) {
        echo '  <div class="overlay" id="customAlert'.$selMesa.'">
                    <div class="alert-box">
                        <h2>Reservar Mesa</h2>
                        <label for="fecha-ini">Inicio reserva</label>
                        <input id="fecha-ini" type="date">
                        <input id="hora-ini" type="time"><br><br>
                        <label for="n-sillas">Añadir Sillas</label><br><br>
                        <span>Sillas en</span>
                        <span id="sillas-plus"></span><span id="sillas-num"></span><br>
                        <span>Sillas en '.$nombreMesa.'</span>
                        <input id="" type="number" min="0" max="'.$valor2['id_sillas'].'" value="'.$valor2['id_sillas'].'"><br><br>
                        <button class="close-btn" onclick="reservar('.$selMesa.')">Reservar</button>
                        <button class="close-btn" onclick="ocupar('.$selMesa.')">Ocupar/Desocupar</button>
                        <button class="close-btn" onclick="closeAlert('.$selMesa.')">Cancelar</button>
                    </div>
                </div>';
    }

?>