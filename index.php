<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Delight</title>
    <link rel="shortcut icon" href="../src/LOGO/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./style/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./img/OIG.png" type="image/x-icon">
    <script src="./js/main.js"></script>
</head>

<body>
    <div class="flex" id="oscuro">
        <div class="container">
            <h2 class="flex letra" id="titulo">INICIO DE SESION</h2>
            <br>
            <div class="flex">
                <img src="./img/OIG.png" style="width: 40%;" alt="logo">
            </div>
            <form action="./proc/login.php" method="POST">
                <div class="inputs">
                    <label for="email" class="letra">Usuario:</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php if(isset($_GET['username'])) {echo $_GET['username'];} ?>">
                
                </div>
                <br>
                <span id="usernameError" class="letra" style="color: red;"></span>
                
                <br>
                <div class="inputs">
                    <label for="password" class="letra">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <!-- Si detecta que el campo password o el usuario estan mal puestos o no existen nos salta el mensaje -->
                    <?php if (isset($_GET['passwordDoNotMatch']) || isset($_GET['usernameNoExist'])) {echo "<br><br><p class='letra' style='color: red;'>Usuario o contraseña incorrectos.</p>"; } ?>
                    </div>
                <br>
                <!-- Muestra el mensaje de error del JavaScript -->
                <span id="passwordError" class="letra" style="color: red;"></span>
                <br><br>
                <!-- Usamos el evento onclick para que se ejecute el JavaScript -->
                <button type="submit" name="login" value="login" class="boton letra" onclick="return validarForm();">Iniciar sesión</button>
                <br>
            
            </form>
        </div>
    </div>
</body>

</html>