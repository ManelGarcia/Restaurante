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
        <div>
            <span onclick='ClickCrud()'>CRUD Usuarios</span><br>
            <span onclick='ClickCrudM()'>CRUD Materiales</span><br>
            <span onclick='mesas()'>Mesas</span><br>
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