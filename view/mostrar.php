<?php
// Inicia la sesión para poder acceder a variables de sesión
session_start();

// Verifica si hay un nombre de usuario almacenado en la sesión
// if ($_SESSION["username"]) {
    // Incluye el archivo de conexión a la base de datos
    include_once("../proc/conexion.php");
    ?>

    <!-- Inicio del documento HTML -->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Configuración del encabezado del documento -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mesas //// Space Delight 👽👽</title>
        <!-- Enlaces a hojas de estilo y recursos externos -->
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="shortcut icon" href="../img/OIG.png" type="image/x-icon">
        <link rel="stylesheet" href="../style/mostrar.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@600&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500&family=Trispace:wght@500&display=swap" rel="stylesheet"> -->
        <style>
        body {
            font-family: Arial, sans-serif;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .alert-box {
            background: #fff;
            padding: 20px;
            margin-top: 15%;
            margin-left: 35%;
            width: 30rem;
            height: 20rem;
            border-radius: 5px;
            text-align: center;
        }

        .left-box {
            float: left;
            width: 50%;
            height: 100%;
        }

        
        .right-box {
            float: right;
            width: 50%;
            height: 100%;
        }

        .libre {
            background-color: green;
        }

        .ocupado {
            background-color: red;
        }

        .mantenimiento {
            background-color: blue;
        }

        .reservado {
            border: 1px solid orange;
        }
        
    </style>
    </head>

    <body class="main-body">
        <!-- Título de la página -->
        <h1 id="titulo">Mesas</h3>

        <!-- Contenido principal -->
        <div class='page-border'>
            <!-- Mensaje informativo sobre la selección de salas y mesas -->
            <div class="flex">
                <p class="content-text textos">Selecciona la sala y pulsa la mesa para indicar que están ocupadas o libres</p>
            </div>

            <!-- Formulario para filtrar por sala -->
            <div class='paragraph flex'>
                <form id='form-filter' method='get'>
                    <?php
                        // Obtiene las salas de la base de datos y las muestra en un menú desplegable
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
                    <!-- Botón para aplicar el filtro -->
                </form>
            </div>
            <div id="mesas-div" class="tab-content flex tab-otro">
            </div>
            <br>
            <div id='alerta'></div>

        <!-- Script JavaScript -->
        <script>

        </script>
        <script src="../js/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    </body>
    </html>
<?php
// Si la variable de sesión no está creada te manda al login
// }else {
//     header("Location: ../index.php");
// }