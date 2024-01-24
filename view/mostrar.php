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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="shortcut icon" href="../img/OIG.png" type="image/x-icon">
        <link rel="stylesheet" href="../style/mostrar.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@600&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500&family=Trispace:wght@500&display=swap" rel="stylesheet">
        <style>
        body {
            font-family: Arial, sans-serif;
            color: white;
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
            background: grey !important;
            padding: 20px;
            margin-top: 15%;
            margin-left: 35%;
            width: 30rem;
            height: 20rem;
            border-radius: 5px;
            text-align: center;
        }

º       .mesas-div {
            display: flex;
        }

        .libre, .ocupado, .mantenimiento, .reservado, .reservado-now {
            background-image: url('../img/mesa_buena.png');
            background-size: cover; 
            background-repeat: no-repeat;
            background-position: center;    
            width: 5rem;
            height: 5rem;
            float: left;
            margin: 1rem;
            text-align: center;
            justify-content: center;
        }

        .libre {
            background-color: none;
        }

        .ocupado {
            background-color: FireBrick;
        }

        .mantenimiento {
            background-color: blue;
        }

        .reservado-now {
            background-color: orange;
        }

        .reservado {
            border: 2px dashed coral !important;
        }

        .sala_res {
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 0; 
            margin: 0;
        }

        .ubicacion {
            /* display: flex; */
        }


        
    </style>
    </head>

    <body class="main-body">
        <div class='nav'>
            <?php
            include_once("../proc/conexion.php");

            $sql = $pdo -> prepare("SELECT tipo_us FROM usuario WHERE usuario_us = :us");
            $sql->bindParam(':us', $_SESSION["username"]); 
            $sql->execute(); 
            $row = $sql->fetch(PDO::FETCH_ASSOC); 

            if ($row['tipo_us'] == 1 ) {
                echo "<span onclick='mesas()'>Mesas</span><br>";
                echo "<span onclick='ClickCrud()'>CRUD Usuarios</span><br>";
                echo "<span onclick='ClickCrudM()'>CRUD Materiales</span><br>";
            } elseif ($row['tipo_us'] == 3) {
                echo "<span onclick='mesas()'>Mesas</span><br>";
                echo "<span onclick='ClickCrudM()'>CRUD Materiales</span><br>";
            } else {
                echo "<span onclick='mesas()'>Mesas</span><br>";
            }

            echo "<span onclick='estad()'>Estadisticas</span><br>";
            echo "<span onclick='hist()'>Historial</span>";
            echo '<span><a style="text-decoration: none; color: white" href="../proc/cerrar_sesion.php">Log Out</a></span>';
            ?>
        </div>
        <div id="body">

        </div>

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