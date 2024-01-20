<?php
session_start();//iniciamos sesion

// Verifica si existe la variable de sesion username
if ($_SESSION["username"]) {
    // Incluye el archivo de conexión a la base de datos
    include_once('./conexion.php');

    // Obtiene los datos del formulario
    $estado = mysqli_real_escape_string($conn, $_POST['estado_mesa']);
    $id = mysqli_real_escape_string($conn, $_POST['id_mesa']);
    $url = mysqli_real_escape_string($conn, $_POST['url']);
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);

    try {
        // Si se ha enviado el estado
        if (isset($estado)) {

            // Deshabilita la autoconfirmación 
            mysqli_autocommit($conn, false);
            //iniciamos la transaccion
            mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

            // Obtiene el tiempo actual
            $tiempo_actual = date('Y-m-d H:i:s');

            // Obtiene el estado actual de la mesa
            $sql_estado_actual = "SELECT estado_mesa FROM mesa WHERE id_mesa = ?";
            $stmt_estado_actual = mysqli_prepare($conn, $sql_estado_actual);
            mysqli_stmt_bind_param($stmt_estado_actual, "i", $id);
            mysqli_stmt_execute($stmt_estado_actual);
            mysqli_stmt_bind_result($stmt_estado_actual, $estado_anterior);
            mysqli_stmt_fetch($stmt_estado_actual);
            mysqli_stmt_close($stmt_estado_actual);

            // Obtiene el ID del camarero actual
            $sql_id_camarero = "SELECT id_camarero FROM camarero WHERE usuario_cam = ?";
            $stmt_id_camarero = mysqli_prepare($conn, $sql_id_camarero);
            mysqli_stmt_bind_param($stmt_id_camarero, "s", $username);
            mysqli_stmt_execute($stmt_id_camarero);
            mysqli_stmt_bind_result($stmt_id_camarero, $id_camarero);
            mysqli_stmt_fetch($stmt_id_camarero);
            mysqli_stmt_close($stmt_id_camarero);

            // Si el estado actual es Desocupado y el nuevo estado es Ocupado, realiza la inserción en la tabla Tiempo
            if ($estado == 2 && $estado_anterior == 2) {
                //insert en la tabla tiempo pero no añadimos el tiempo final
                $sql_insert_tiempo = "INSERT INTO tiempo (inicio, mesa_tmp, camarero_tmp) VALUES (?, ?, ?)";
                $stmt_insert_tiempo = mysqli_prepare($conn, $sql_insert_tiempo);
                mysqli_stmt_bind_param($stmt_insert_tiempo, "sii", $tiempo_actual, $id, $id_camarero);
                mysqli_stmt_execute($stmt_insert_tiempo);
                mysqli_stmt_close($stmt_insert_tiempo);
            } elseif ($estado == 1 && $estado_anterior == 1) {
                // Si el estado actual es Ocupado y el nuevo estado es Desocupado, actualiza el tiempo final en la tabla Tiempo
                $sql_update_tiempo = "UPDATE tiempo SET final = ? WHERE mesa_tmp = ? AND camarero_tmp = ? AND final IS NULL";
                $stmt_update_tiempo = mysqli_prepare($conn, $sql_update_tiempo);
                mysqli_stmt_bind_param($stmt_update_tiempo, "sii", $tiempo_actual, $id, $id_camarero);
                mysqli_stmt_execute($stmt_update_tiempo);
                mysqli_stmt_close($stmt_update_tiempo);
            }

            // Actualiza el estado de la mesa en la tabla Mesa
            if ($estado == 2) {
                $sql1 = "UPDATE mesa SET estado_mesa = 1 WHERE id_mesa = ?";
            } else {
                $sql1 = "UPDATE mesa SET estado_mesa = 2 WHERE id_mesa = ?";
            }
            
            $stmt1 = mysqli_prepare($conn, $sql1);
            mysqli_stmt_bind_param($stmt1, "i", $id);
            mysqli_stmt_execute($stmt1);
            mysqli_stmt_close($stmt1);

            // Confirma la transacción
            mysqli_commit($conn);

            // Redirecciona a la página de mostrar con la sala correspondiente
            header('Location: ../view/mostrar.php?sala=' . $url);
        }
    } catch (Exception $e) {
        // En caso de error, realiza un rollback y maneja la excepción
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
        die();
    }
} else {
    // Redirecciona al index si el usuario no está autenticado
    header("Location: ../index.php");
}
?>
