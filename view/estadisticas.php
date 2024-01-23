<?php
session_start(); // Iniciamos sesión
if ($_SESSION["username"]) { // Verificamos si existe la variable de sesión
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
    <style>
        * {
            color: white;
        }
    </style>
    <body class="main-body">

    <h1 id="titulo">Estadísticas</h3>
    <br>
    <div class="page-border">
        <?php
        include_once("../proc/conexion.php"); // Incluimos archivo de conexión

        try {
            include_once('../proc/conexion.php');

            // Consulta para obtener el nombre del usuario con más ocupaciones y el número
            $sqlusuario = "SELECT
                C.id_usuario,
                C.nombre_us,
                COUNT(T.id_tiempo) AS total_ocupaciones
            FROM
                usuario C
            JOIN
                Tiempo T ON C.id_usuario = T.camarero_tmp
            GROUP BY
                C.id_usuario, C.nombre_us
            ORDER BY
                total_ocupaciones DESC
            LIMIT 1;
            ";

            $stmtusuario = $pdo->prepare($sqlusuario);
            $stmtusuario->execute();
            $resultusuario = $stmtusuario->fetch(PDO::FETCH_ASSOC);

            if ($resultusuario) {
                echo "<p class='textos5'>Camarero del mes</p>";
                echo "<p class='textos4'>El camarero del mes es " . $resultusuario['nombre_us'] . ", ha sido el que más mesas ha ocupado con un total de " . $resultusuario['total_ocupaciones'] . " veces</p>";
            } else {
                echo "<p class='mt-3 texto3'>NO SE ENCONTRARON REGISTROS</p>";
            }

            // Consulta para obtener la sala que ha sido más ocupada y el número de veces
            $sqlSala = "SELECT
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

            $stmtSala = $pdo->prepare($sqlSala);
            $stmtSala->execute();
            $resultSala = $stmtSala->fetch(PDO::FETCH_ASSOC);

            if ($resultSala) {
                echo "<p class='textos5'>Sala más ocupada</p>";
                echo "<p class='textos4'>La gente suele comer en la sala " . $resultSala['nombre_sala'] . ", ha sido ha ocupada " . $resultSala['total_ocupaciones'] . " veces</p>";
            } else {
                echo "<p class='mt-3 textos4'>NO SE ENCONTRARON REGISTROS</p>";
            }

            // Consulta para ver qué día ha tenido más ocupaciones
            $sqlFecha = "SELECT
                DATE_FORMAT(inicio_tmp, '%d/%m/%y') AS fecha,
                COUNT(id_tiempo) AS total_ocupaciones
            FROM
                Tiempo
            GROUP BY
                fecha
            ORDER BY
                total_ocupaciones DESC
            LIMIT 1;
            ";

            $stmtFecha = $pdo->prepare($sqlFecha);
            $stmtFecha->execute();
            $resultFecha = $stmtFecha->fetch(PDO::FETCH_ASSOC);

            if ($resultFecha) {
                echo "<p class='textos5'>Día más ocupado</p>";
                echo "<p class='textos4'>El día " . $resultFecha['fecha'] . " ha sido el que más ocupaciones ha habido, con un total de " . $resultFecha['total_ocupaciones'] . " veces</p>";
            } else {
                echo "<p class='mt-3 textos4'>NO SE ENCONTRARON REGISTROS</p>";
            }

            $pdo = null; // Cerramos la conexión
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Si hay algún tipo de error lo muestra
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
} else {
    header("Location: ../index.php"); // Si no hay variable de sesión redirigimos al index
}
?>
