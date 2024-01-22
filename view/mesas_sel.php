<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1 id="titulo">MESAS</h3>

<div class='page-border'>
    <div class="flex">
        <p class="content-text textos">Selecciona la sala y pulsa la mesa para indicar que están ocupadas o libres</p>
    </div>

    <div id="header" class='paragraph flex'>
        <form id='form-filter' method='get'>
            <?php
                include_once('../proc/conexion.php');
                try {
                    $sql1 = $pdo -> prepare("SELECT * FROM ubicacion");
                    $sql1 -> execute();
                    
                    $resultado1 = $sql1->fetchAll(PDO::FETCH_ASSOC);
                    echo "<select name='sala' class='ubicacion' id='filtros_sala'>";
                    echo "<option value=''></option>";

                    foreach ($resultado1 as $valor) {
                        echo "<option value='" . $valor['id_ubicacion'] . "'>" . $valor['lugar'] . "</option>";
                    }
                    echo "</select>";
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage() . "<br>";
                }
            ?>
        </form><br>
    </div>
    <div id="mesas-div" class="tab-content flex tab-otro">
    </div>
    <br>
    <div id='alerta'></div>
</div>
</body>
</html>