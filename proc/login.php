<?php
// Verificar si ambos campos del formulario se han enviado
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $errores = ""; //creamos variable de errores
    
    // Incluir el archivo de conexión a la base de datos
    include_once("./conexion.php");
    
    // Obtener el nombre de usuario y contraseña del formulario
    $username = $_POST["username"];
    $passwd = $_POST["password"];
    // Encriptamos la contraseña
    $pwdEncriptada = hash("sha256", $passwd);
    
    try {
        // Hacemos consulta sql para buscar el usuario en la bd
        $stmt = $pdo -> prepare("SELECT usuario_us, password_us FROM usuario WHERE usuario_us = :username");
        $stmt->bindParam(':username', $username); // Vincular el nombre de usuario a la consulta
        $stmt->execute(); // Ejecutar la consulta
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener el resultado de la consulta
        
        // Verificar si se encontró un usuario con el nombre proporcionado
        if ($row) {
            // Guardamos en variable valores de la bd
            $nombre = $row['usuario_us'];
            $password = $row['password_us'];
            
            // Comprobamos si las contraseñas coinciden
            if (hash_equals($pwdEncriptada, $password)) {
                session_start();
                $_SESSION["username"] = $username; // Guardar el nombre de usuario en la sesión
                
                //mostramos mensaje para que vea el usuario mediante un sweet alert
                ?>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            title: "Bienvenido <?php echo $username; ?>",
                            icon: "success",
                            confirmButtonColor: "green",
                            confirmButtonText: "Inicio"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirige a la página de mostrar
                                window.location.href = '../view/mostrar.php';
                            }
                        });
                    });
                </script>
                <?php
               
                exit(); // Asegurar que el script se detenga después de la redirección
            } else {//si la contraseña es incorrecta
                //guardamos errores
                if ($errores) {
                    $errores .= '&passwordDoNotMatch=true';
                } else {
                    $errores = '?passwordDoNotMatch=true';
                }
        
                // Si hay errores los enviamos por la url
                if ($errores!=""){
        
                    $datosRecibidos = array(
                        'username' => $username,
                        
                        
                    );
                    $datosDevueltos = http_build_query($datosRecibidos);
                    header("Location: ../index.php" . $errores . "&" . $datosDevueltos);
                    exit();
                }
            }  
        } else {//si el usuario no existe
            //guardamos errores y lo enviamos por la url
            if ($errores) {
                $errores .= '&usernameNoExist=true';
            } else {
                $errores = '?usernameNoExist=true';
            }
    
            // Si hay errores
            if ($errores!=""){
    
                $datosRecibidos = array(
                    'username' => $username,
                    
                    
                );
                $datosDevueltos = http_build_query($datosRecibidos);
                header("Location: ../index.php" . $errores . "&" . $datosDevueltos);
                exit();
            }
        }
        
        //cerramos stmt
        $stmt = null;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $pdo = null;
    }

} else {
    header("Location: ../index.php");//si no ha llenado los dos ccampos no nos deja pasar
    exit();
}
?>
