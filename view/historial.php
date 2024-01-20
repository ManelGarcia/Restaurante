<?php
// Inicia la sesión
session_start();

// Verifica si la variabl de sesion esta creada
if (isset($_SESSION["username"])) {
    // Consultas SQL para obtener datos de salas, mesas y camareros
    $sqlSalas = "SELECT lugar FROM ubicacion;";
    $sqlMesas = "SELECT id_mesa, nombre_mesa FROM Mesa";
    $sqlCamareros = "SELECT nombre_cam FROM Camarero";

    // Incluye el archivo de conexión a la base de datos
    include_once("../proc/conexion.php");

    try {
        // Preparación y ejecución de la consulta para obtener salas
        $stmtSalas = mysqli_prepare($conn, $sqlSalas);
        mysqli_stmt_execute($stmtSalas);
        mysqli_stmt_bind_result($stmtSalas, $sala);
        $salas = array();//creamos array
        while (mysqli_stmt_fetch($stmtSalas)) {
            $salas[] = $sala;//guardamos el resultado dentro del array
        }

        // Preparación y ejecución de la consulta para obtener mesas
        $stmtMesas = mysqli_prepare($conn, $sqlMesas);
        mysqli_stmt_execute($stmtMesas);
        mysqli_stmt_bind_result($stmtMesas, $idMesa, $nombreMesa);
        $mesas = array();//creamos array
        while (mysqli_stmt_fetch($stmtMesas)) {
            $mesas[] = array('id' => $idMesa, 'nombre' => $nombreMesa);//guardamos el resultado dentro del array
        }

        // Preparación y ejecución de la consulta para obtener camareros
        $stmtCamareros = mysqli_prepare($conn, $sqlCamareros);
        mysqli_stmt_execute($stmtCamareros);
        mysqli_stmt_bind_result($stmtCamareros, $camarero);
        $camareros = array();//creamos array
        while (mysqli_stmt_fetch($stmtCamareros)) {
            $camareros[] = $camarero;//guardamos el resultado dentro del array
        }

        // Cerramos las consultas preparadas
        mysqli_stmt_close($stmtSalas);
        mysqli_stmt_close($stmtMesas);
        mysqli_stmt_close($stmtCamareros);

    } catch (Exception $e) {
        // Maneja excepciones
        echo "Error: " . $e->getMessage();
    }
    ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Historial</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="shortcut icon" href="../img/OIG.png" type="image/x-icon">
        <script src="../js/main.js"></script>
        <link rel="stylesheet" href="../style/historial.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@600&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500&family=Trispace:wght@500&display=swap" rel="stylesheet">
    </head>
    
    <body>
        <nav class="nav-bar flex iconos">
            <div class="div1">
                <div>
                    <a href="../proc/cerrar_sesion.php"><img src="../img/logoutblanco.png" alt="Cerrar sesión" id="icono"></a>
                </div>
                <div class="div2">
                    <a href="../proc/cerrar_sesion.php"><img src="../img/logoutverde.png" alt="Cerrar sesión" id="icono2"></a>
                </div>
            </div>
            <div class="div1">
                <div>
                    <a href="./mostrar.php"><img src="../img/casablanca.png" alt="Home" id="icono"></a>
                </div>
                <div class="div2">
                    <a href="./mostrar.php"><img src="../img/casaverde.png" alt="Home" id="icono2"></a>
                </div>
            </div>
            <div class="div1">
                <div>
                    <a href="./estadisticas.php"><img src="../img/estadisticablanca.png" alt="Estadísticas" id="icono"></a>
                </div>
                <div class="div2">
                    <a href="./estadisticas.php"><img src="../img/estadisticaverde.png" alt="Estadísticas" id="icono2"></a>
                </div>
            </div>
            
            <br>
        </nav>

        <h1 id="titulo">Historial</h1>

        <header>
            <form action='' method='post'>
                <label for='sala' class="textos">Filtrar por Sala:</label>
                <select name='sala' id="filtros">
                    <option value='Todas' name='Todas'>Todas</option>
                    <?php
                    //mostramos las salas de la bd que tenemos guardadas en un array
                    foreach ($salas as $salaOption) {
                        echo "<option name='{$salaOption}' value='{$salaOption}'>{$salaOption}</option>";
                    }
                    ?>
                </select>

                <label for='mesa' class="textos">Filtrar por Mesa:</label>
                <select name='mesa' id="filtros">
                    <option value='Todas' name='Todas'>Todas</option>
                    <?php
                    //mostramos las mesas de la bd que tenemos guardadas en el array
                    foreach ($mesas as $mesaOption) {
                        echo "<option name='{$mesaOption['nombre']}' value='{$mesaOption['nombre']}'>{$mesaOption['nombre']}</option>";
                    }
                    ?>
                </select>

                <label for='camarero' class="textos">Filtrar por Camarero:</label>
                <select name='camarero' id="filtros">
                    <option value='Todos' name='Todos'>Todos</option>
                    <?php
                    //mostramos los camareros de la bd que tenemos guardados en el array
                    foreach ($camareros as $camareroOption) {
                        echo "<option name='{$camareroOption}' value='{$camareroOption}'>{$camareroOption}</option>";
                    }
                    ?>
                </select>
                
                <label for="fecha" class="textos">Filtrar por Fecha</label>
                <input type="date" name="fecha" id="filtros">
                <br>
                <br>
                <div id='centrar'>
                    <button type='submit' name='filtrar' value='Filtrar' id="filtrar" class="btn btn-1" onclick="return validarFecha();">Filtrar</button>
                </div>
            </form>
        </header>
        <br>
        <br>

        <?php
       
        // Definir la consulta inicial para mostrar toda la tabla
        $sql = "SELECT
                DATE_FORMAT(T.inicio, '%d/%m/%y %H:%i:%s') AS TiempoInicio,
                DATE_FORMAT(T.final, '%d/%m/%y %H:%i:%s') AS TiempoFinal,
                U.lugar AS Sala,
                M.nombre_mesa AS NombreMesa,
                C.nombre_cam AS NombreCamarero,
                TIMEDIFF(T.final, T.inicio) AS TiempoTranscurrido
            FROM Tiempo T
            JOIN Mesa M ON T.mesa_tmp = M.id_mesa
            JOIN Camarero C ON T.camarero_tmp = C.id_camarero
            JOIN Ubicacion U ON M.ubicacion_mesa = U.id_ubicacion";

        // Aplicar el filtrado si se hizo clic en el botón de filtrar
        if (isset($_POST['filtrar'])) {
            //obtenemos los datos del formulario y los guardamos en variables
            $filtroSala = isset($_POST['sala']) ? $_POST['sala'] : 'Todas';
            $filtroMesa = isset($_POST['mesa']) ? $_POST['mesa'] : 'Todas';
            $filtroCamarero = isset($_POST['camarero']) ? $_POST['camarero'] : 'Todos';
            //creamos array para las condiciones
            $condiciones = array();
            //si filtroSala no marca todas añadimos condicion
            if ($filtroSala != 'Todas') {
                $condiciones[] = "U.lugar = '{$filtroSala}'";
            }
            //si filtroMesa no marca todas añadimos condicion
            if ($filtroMesa != 'Todas') {
                $condiciones[] = "M.nombre_mesa = '{$filtroMesa}'";
            }
            //si filtroCamarero no marca todos añadimos condicion
            if ($filtroCamarero != 'Todos') {
                $condiciones[] = "C.nombre_cam = '{$filtroCamarero}'";
            }
            //si recibimos la fecha
            if (isset($_POST['fecha']) && !empty($_POST['fecha'])) {
                //lo guardamos en variable
                $filtroFecha = mysqli_real_escape_string($conn, $_POST['fecha']);
                $condiciones[] = "DATE(T.inicio) = '{$filtroFecha}'";
            }
            //si hay condiciones añadimos a la consulta sql inicial un where con la condicion
            if (!empty($condiciones)) {
                $sql .= " WHERE " . implode(' AND ', $condiciones);
            }
        }
    //ordenamos de forma descendente para que nos salgan las nuevas ocupaciones arriba de la tabla
    $sql .= " ORDER BY TiempoInicio DESC";
    try{
        //preparamos stmt, ejecutamos y obtenemos resultados
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $tiempoInicio, $tiempoFinal, $sala, $nombreMesa, $nombreCamarero, $tiempoTranscurrido);

            // Verificar si hay resultados
            if (mysqli_stmt_fetch($stmt)) {
                echo "<table class='table mt-3' style='display:flex; justify-content:center; text-align:center; font-size:25px;'>
                        <tr>
                            <th style='border-top-width: 2px; border-top: 2px solid #03cc57;'>Tiempo de Inicio</th>
                            <th style='border-top-width: 2px; border-top: 2px solid #03cc57;'>Tiempo Final</th>
                            <th style='border-top-width: 2px; border-top: 2px solid #03cc57;'>Sala</th>
                            <th style='border-top-width: 2px; border-top: 2px solid #03cc57;'>Mesa</th>
                            <th style='border-top-width: 2px; border-top: 2px solid #03cc57;'>Camarero</th>
                            <th style='border-top-width: 2px; border-top: 2px solid #03cc57;'>Tiempo Transcurrido</th>
                        </tr>";

                do {
                    echo "<tr>
                            <td style='border-top-width: 2px; border-bottom: 2px solid #03cc57;'>$tiempoInicio</td>
                            <td style='border-top-width: 2px; border-bottom: 2px solid #03cc57;'>$tiempoFinal</td>
                            <td style='border-top-width: 2px; border-bottom: 2px solid #03cc57;'>$sala</td>
                            <td style='border-top-width: 2px; border-bottom: 2px solid #03cc57;'>$nombreMesa</td>
                            <td style='border-top-width: 2px; border-bottom: 2px solid #03cc57;'>$nombreCamarero</td>
                            <td style='border-top-width: 2px; border-bottom: 2px solid #03cc57;'>$tiempoTranscurrido</td>
                        </tr>";
                } while (mysqli_stmt_fetch($stmt));

                echo "</table>";
            } else {
                echo "<p class='texto3'>NO SE ENCONTRARON REGISTROS</p>";
                
            }
            mysqli_stmt_close($stmt);//cerramos stmt
        } 

        mysqli_close($conn);//cerramos conexion
   
    }
    catch(Exception $e){
        echo "Error: ". $e->getMessage() ."";//maneja excepciones
    }
        ?>
    </body>
    <!-- Agrega el enlace al archivo JS de Bootstrap (opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </html>
<?php
}else {
    header("Location: ../index.php");//si no hay variable de sesion redirijimos al index
}