<?php
// Inicia la sesión
session_start();

// Verifica si la variable de sesión está creada
if (isset($_SESSION["username"])) {
    // Consultas SQL para obtener datos de salas, mesas y usuarios
    $sqlSalas = "SELECT lugar FROM ubicacion;";
    $sqlMesas = "SELECT id_mesa, nombre_mesa FROM Mesa";
    $sqlusuarios = "SELECT nombre_us FROM usuario";

    // Incluye el archivo de conexión a la base de datos
    include_once("../proc/conexion.php");

    try {
        // Preparación y ejecución de la consulta para obtener salas
        $stmtSalas = $pdo->prepare($sqlSalas);
        $stmtSalas->execute();
        $salas = $stmtSalas->fetchAll(PDO::FETCH_COLUMN);

        // Preparación y ejecución de la consulta para obtener mesas
        $stmtMesas = $pdo->prepare($sqlMesas);
        $stmtMesas->execute();
        $mesas = $stmtMesas->fetchAll(PDO::FETCH_ASSOC);

        // Preparación y ejecución de la consulta para obtener usuarios
        $stmtusuarios = $pdo->prepare($sqlusuarios);
        $stmtusuarios->execute();
        $usuarios = $stmtusuarios->fetchAll(PDO::FETCH_COLUMN);

    } catch (PDOException $e) {
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
    <style>
        * {
            color: white;
        }
    </style>
    
    <body>
        <h1 id="titulo">Historial</h1>

        <?php
       
        // Definir la consulta inicial para mostrar toda la tabla
        $sql = "SELECT
                DATE_FORMAT(T.inicio_tmp, '%d/%m/%y %H:%i:%s') AS Tiempoinicio_tmp,
                DATE_FORMAT(T.final_tmp, '%d/%m/%y %H:%i:%s') AS Tiempofinal_tmp,
                U.lugar AS Sala,
                M.nombre_mesa AS NombreMesa,
                C.nombre_us AS Nombreusuario,
                TIMEDIFF(T.final_tmp, T.inicio_tmp) AS TiempoTranscurrido
            FROM Tiempo T
            JOIN Mesa M ON T.mesa_tmp = M.id_mesa
            JOIN usuario C ON T.camarero_tmp = C.id_usuario
            JOIN Ubicacion U ON M.ubicacion_mesa = U.id_ubicacion";

        // Aplicar el filtrado si se hizo clic en el botón de filtrar
        if (isset($_POST['filtrar'])) {
            // Obtener los datos del formulario y guardarlos en variables
            $filtroSala = isset($_POST['sala']) ? $_POST['sala'] : 'Todas';
            $filtroMesa = isset($_POST['mesa']) ? $_POST['mesa'] : 'Todas';
            $filtrousuario = isset($_POST['usuario']) ? $_POST['usuario'] : 'Todos';
            // Crear array para las condiciones
            $condiciones = array();
            // Si filtroSala no marca todas, añadimos condición
            if ($filtroSala != 'Todas') {
                $condiciones[] = "U.lugar = '{$filtroSala}'";
            }
            // Si filtroMesa no marca todas, añadimos condición
            if ($filtroMesa != 'Todas') {
                $condiciones[] = "M.nombre_mesa = '{$filtroMesa}'";
            }
            // Si filtrousuario no marca todos, añadimos condición
            if ($filtrousuario != 'Todos') {
                $condiciones[] = "C.nombre_us = '{$filtrousuario}'";
            }
            // Si recibimos la fecha
            if (isset($_POST['fecha']) && !empty($_POST['fecha'])) {
                // Guardamos la fecha en una variable
                $filtroFecha = htmlspecialchars($_POST['fecha']);
                $condiciones[] = "DATE(T.inicio_tmp) = '{$filtroFecha}'";
            }
            // Si hay condiciones, añadimos a la consulta SQL inicial un WHERE con la condición
            if (!empty($condiciones)) {
                $sql .= " WHERE " . implode(' AND ', $condiciones);
            }
        }
        // Ordenamos de forma descendente para que las nuevas ocupaciones aparezcan arriba de la tabla
        $sql .= " ORDER BY Tiempoinicio_tmp DESC";
        try {
            // Preparamos el statement, ejecutamos y obtenemos resultados
            $stmt = $pdo->prepare($sql);

            if ($stmt) {
                $stmt->execute();
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Verificar si hay resultados
                if ($resultados) {
                    echo "<table class='table mt-3' style='display:flex; justify-content:center; text-align:center; font-size:25px; margin: 0;'>
                            <tr>
                                <th style='border-top-width: 2px; border-top: 2px solid #03cc57;'>Tiempo de inicio_tmp</th>
                                <th style='border-top-width: 2px; border-top: 2px solid #03cc57;'>Tiempo final_tmp</th>
                                <th style='border-top-width: 2px; border-top: 2px solid #03cc57;'>Sala</th>
                                <th style='border-top-width: 2px; border-top: 2px solid #03cc57;'>Mesa</th>
                                <th style='border-top-width: 2px; border-top: 2px solid #03cc57;'>usuario</th>
                                <th style='border-top-width: 2px; border-top: 2px solid #03cc57;'>Tiempo Transcurrido</th>
                            </tr>";

                    foreach ($resultados as $fila) {
                        echo "<tr>
                                <td style='border-top-width: 2px; border-bottom: 2px solid #03cc57;'>{$fila['Tiempoinicio_tmp']}</td>
                                <td style='border-top-width: 2px; border-bottom: 2px solid #03cc57;'>{$fila['Tiempofinal_tmp']}</td>
                                <td style='border-top-width: 2px; border-bottom: 2px solid #03cc57;'>{$fila['Sala']}</td>
                                <td style='border-top-width: 2px; border-bottom: 2px solid #03cc57;'>{$fila['NombreMesa']}</td>
                                <td style='border-top-width: 2px; border-bottom: 2px solid #03cc57;'>{$fila['Nombreusuario']}</td>
                                <td style='border-top-width: 2px; border-bottom: 2px solid #03cc57;'>{$fila['TiempoTranscurrido']}</td>
                            </tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<p class='texto3'>NO SE ENCONTRARON REGISTROS</p>";
                }
            }

            // Cerramos el statement
            $stmt = null;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Maneja excepciones
        }

        // Cerramos la conexión
        $pdo = null;

        ?>
    </body>
    <!-- Agrega el enlace al archivo JS de Bootstrap (opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </html>
<?php
} else {
    header("Location: ../index.php"); // Si no hay variable de sesión, redirigimos al index
}
?>
