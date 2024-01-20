<?php
// Inicia una sesión
session_start();
if ($_SESSION["username"]) {
    include_once "./conexion.php";
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    // Elimina todas las variables de sesión
    session_unset();

    // Destruye la sesión actual
    session_destroy();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: "¡Hasta pronto <?php echo $username; ?>!",
                icon: "success",
                showCancelButton: false,
                confirmButtonColor: "green",
                confirmButtonText: "Volver a inicio"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirige a la página principal
                    window.location.href = '../index.php';
                }
            });
        });
    </script>

    <?php
    // Termina el script para asegurarse de que no se ejecuten más instrucciones
    exit();
} else {
    header("Location: ../index.php");
}
?>
