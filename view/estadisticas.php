<?php
session_start();//iniciamos sesion
if ($_SESSION["username"]) {//verificamos si existe la variable de sesion
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Estadísticas</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="shortcut icon" href="../img/OIG.png" type="image/x-icon">
        <link rel="stylesheet" href="../style/estadisticas.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@600&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500&family=Trispace:wght@500&display=swap" rel="stylesheet">
    </head>
    <body class="main-body">
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
                <a href="./mostrar.php"><img src="../img/casablanca.png" alt="Historial" id="icono"></a>
            </div>
            <div class="div2">
                    <a href="./mostrar.php"><img src="../img/casaverde.png" alt="Historial" id="icono2"></a>
            </div>
        </div>
        <div class="div1">
            <div>
                <a href="./historial.php"><img src="../img/historialblanco.png" alt="Estadísticas" id="icono"></a>
            </div>
            <div class="div2">
                <a href="./historial.php"><img src="../img/historialverde.png" alt="Estadísticas" id="icono2"></a>
            </div>
        </div>
        <br>
    </nav>

    <h1 id="titulo">Estadísticas</h3>
    <br>
    <div class="page-border">
        <?php
        include_once("../proc/conexion.php");//incluimos archivo de conexion
        //consulta para obtener el nombre del camarero con mas ocupaciones y el numero
        $sqlCamarero = "SELECT
                C.id_camarero,
                C.nombre_cam,
                COUNT(T.id_tiempo) AS total_ocupaciones
            FROM
                Camarero C
            JOIN
                Tiempo T ON C.id_camarero = T.camarero_tmp
            GROUP BY
                C.id_camarero, C.nombre_cam
            ORDER BY
                total_ocupaciones DESC
            LIMIT 1;
            ";
            //consulta para obtener la sala que ha sido mas ocupada y el numero de veces
            $sqlSala="SELECT
            U.id_ubicacion,
            U.lugar AS nombre_sala,
            COUNT(T.id_tiempo) AS total_ocupaciones
                FROM
                    Ubicacion U
                JOIN
                    Mesa M ON U.id_ubicacion = M.ubicacion_mesa
                JOIN
                    Tiempo T ON M.id_mesa = T.mesa_tmp
                GROUP BY
                    U.id_ubicacion, U.lugar
                ORDER BY
                    total_ocupaciones DESC
                LIMIT 1;";

            //consulta para ver que dia en que mas ocupaciones ha habido 
            $sqlFecha ="SELECT
                
            DATE_FORMAT(inicio, '%d/%m/%y') AS fecha,
            COUNT(id_tiempo) AS total_ocupaciones
            FROM
                Tiempo
            GROUP BY
                fecha
            ORDER BY
                total_ocupaciones DESC
            LIMIT 1;
            ";
            //consulta para ver los clientes totales del restaurante
            $sqlClientes ="SELECT
                
            SUM(mesa.sillas_mesa) AS total_sillas_ocupadas
            FROM mesa
            INNER JOIN
            tiempo ON mesa.id_mesa = tiempo.mesa_tmp
                ;
            ";

            try{
                // Preparación y ejecución de la consulta 
                $stmtCamarero = mysqli_prepare($conn, $sqlCamarero);

                if ($stmtCamarero) {
                    
                    mysqli_stmt_execute($stmtCamarero);
                    mysqli_stmt_bind_result($stmtCamarero, $id_cam, $nombre_cam, $ocupaciones);
                    // Verificar si hay resultados y los muestra
                    if (mysqli_stmt_fetch($stmtCamarero)) {
                        echo "<p class='textos5'>Camarero del mes</p>";
                        echo "<p class='textos4'>El camarero del mes es ".$nombre_cam.", ha sido el que más mesas ha ocupado con un total de ".$ocupaciones." veces</p>";
                        
                    }else {//si no hay resultados dice que no hay registros
                        echo "<p class='mt-3 texto3'>NO SE ENCONTRARON REGISTROS</p>";
                    }
        
                    mysqli_stmt_close($stmtCamarero);//cerramos stmt
                }
                echo "<br>";
                echo "<br>";
                // Preparación y ejecución de la consulta 
                $stmtSala = mysqli_prepare($conn, $sqlSala);

                if ($stmtSala) {
                    mysqli_stmt_execute($stmtSala);
                    mysqli_stmt_bind_result($stmtSala, $id_ubi, $lugar, $ocupacionesSala);
                    // Verificar si hay resultados y los muestra
                    if (mysqli_stmt_fetch($stmtSala)) {
                        echo "<p class='textos5'>Sala más ocupada</p>";
                        echo "<p class='textos4'>La gente suele comer en la sala ".$lugar.", ha sido ha ocupada ".$ocupacionesSala." veces</p>";
        
                    }else {//si no hay resultados dice que no hay registros
                        echo "<p class='mt-3 textos4'>NO SE ENCONTRARON REGISTROS</p>";
                    }
        
                    mysqli_stmt_close($stmtSala);//cerramos stmt
        
                }
                echo "<br>";
                echo "<br>";
                // Preparación y ejecución de la consulta 
                $stmtFecha = mysqli_prepare($conn, $sqlFecha);

                if ($stmtFecha) {
                    mysqli_stmt_execute($stmtFecha);
                    mysqli_stmt_bind_result($stmtFecha, $fecha, $ocupacionesFecha);
                    // Verificar si hay resultados y los muestra
                    if (mysqli_stmt_fetch($stmtFecha)) {
                        echo "<p class='textos5'>Día más ocupado</p>";
                        echo "<p class='textos4'>El dia ".$fecha." ha sido el que más ocupaciones ha habido, con un total de ".$ocupacionesFecha." veces</p>";

                    }else {//si no hay resultados dice que no hay registros
                        echo "<p class='mt-3 textos4'>NO SE ENCONTRARON REGISTROS</p>";
                    }

                    mysqli_stmt_close($stmtFecha);//cerramos stmt

                }
                echo "<br>";
                echo "<br>";
                // Preparación y ejecución de la consulta 
                $stmtClientes = mysqli_prepare($conn, $sqlClientes);

                if ($stmtClientes) {
                    mysqli_stmt_execute($stmtClientes);
                    mysqli_stmt_bind_result($stmtClientes, $clientes);
                    // Verificar si hay resultados y los muestra
                    if (mysqli_stmt_fetch($stmtClientes)) {
                        echo "<p class='textos5'>Clientes atendidos</p>";
                        echo "<p class='textos4'>Estamos orgullosos de haber a atendido a ".$clientes." clientes</p>";
            
                    }else {//si no hay resultados dice que no hay registros
                        echo "<p class='mt-3 textos4'>NO SE ENCONTRARON REGISTROS</p>";
                    }
            
                    mysqli_stmt_close($stmtClientes);//cerramos stmt
            
                }
                mysqli_close($conn);//cerramos la conexion


            }catch(Exception $e){
                echo "Error: ". $e->getMessage() ."";//si hay algun tipo de error lo muestra
            }
            
        ?>
    </div>
    
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
