<?php
include '../valores/conexion.php';
session_start();
if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] !== 'http://127.0.0.1/proyecto7/admin/altamodulo.php') {
    // Redirigir o mostrar mensaje de error si el acceso no es válido
    header("Location: ../myadmin.php");
    exit();
}
// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_POST['usuario_id'];

    // Verificar que el ID de usuario no esté vacío
    if (!empty($usuario_id)) {

        // Validar que el usuario no sea el ID protegido
        if ($usuario_id === '162e9f43-81db-11ef-b45d-4cd7178be01c') {
            // Mensaje de error si se intenta eliminar al usuario protegido
            $_SESSION['eliminacionuser'] = 'Este usuario no puede ser eliminado.';
            header("Location: ../altamodulo.php");
            exit();
        }

        try {
            // Preparar la consulta SQL para eliminar al usuario
            $sql = "DELETE FROM adminlogin WHERE AL_SocioId = :usuario_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_STR);

            // Ejecutar la consulta
            $stmt->execute();

            // Redirigir con éxito
            $_SESSION['eliminacionuser'] = 'Usuario eliminado exitosamente';
            header("Location: ../altamodulo.php");
            exit();
        } catch (PDOException $e) {
            echo "Error al eliminar el usuario: " . $e->getMessage();
        }
    } else {
        echo "No se proporcionó un ID de usuario válido.";
    }
}
?>
