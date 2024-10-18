<?php
include '../valores/conexion.php';
require_once '../../vendor/autoload.php';
session_start();

// Inicializar HTML Purifier
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier();

if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] !== 'http://127.0.0.1/proyecto7/admin/altamodulo.php') {
    // Redirigir o mostrar mensaje de error si el acceso no es válido
    header("Location: ../myadmin.php");
    exit();
}
// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiar los datos de entrada
    $usuario_id = $_POST['usuario_id']; // Esto viene como hidden en el formulario
    $nombre_usuario = $purifier->purify($_POST['nombre_usuario']);
    $primer_apellido = $purifier->purify($_POST['primer_apellido']);
    $segundo_apellido = $purifier->purify($_POST['segundo_apellido']);
    $email = $purifier->purify($_POST['email']);
    $password = !empty($_POST['password']) ? password_hash($purifier->purify($_POST['password']), PASSWORD_DEFAULT) : null; // Hashear si se proporciona

    // Verificar que los campos necesarios no estén vacíos
    if (!empty($usuario_id)) {

        // Validar si el usuario es el de ID protegido
        if ($usuario_id === '162e9f43-81db-11ef-b45d-4cd7178be01c') {
            // Solo permitir la modificación de la contraseña
            if (!empty($password)) {
                // Preparar la consulta para actualizar solo la contraseña
                $sql = "UPDATE adminlogin 
                        SET AL_Contrasena = :password 
                        WHERE AL_SocioId = :usuario_id";

                try {
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_STR);

                    // Ejecutar la consulta
                    $stmt->execute();

                    // Redirigir con éxito
                    $_SESSION['modificacionuser'] = 'Contraseña modificada exitosamente';
                    header("Location: ../altamodulo.php");
                    exit();
                } catch (PDOException $e) {
                    echo "Error al modificar la contraseña: " . $e->getMessage();
                }
            } else {
                // Si no se proporciona la contraseña, lanzar una alerta
                $_SESSION['modificacionuser'] = "No se proporcionaron cambios";
                header("Location: ../altamodulo.php");
            }
        } else {
            // Para otros usuarios, proceder con la modificación normal
            if (!empty($nombre_usuario) && !empty($email)) {
                // Preparar la consulta SQL para actualizar los datos
                $sql = "UPDATE adminlogin 
                        SET AL_NombreDeUsuario = :nombre_usuario, 
                            AL_PrimerApellido = :primer_apellido, 
                            AL_SegundoApellido = :segundo_apellido, 
                            AL_Correo = :email";
                
                // Solo actualizar la contraseña si se proporciona
                if ($password) {
                    $sql .= ", AL_Contrasena = :password";
                }

                $sql .= " WHERE AL_SocioId = :usuario_id";

                try {
                    $stmt = $conn->prepare($sql);
                    // Asignar valores a los parámetros
                    $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
                    $stmt->bindParam(':primer_apellido', $primer_apellido, PDO::PARAM_STR);
                    $stmt->bindParam(':segundo_apellido', $segundo_apellido, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_STR);

                    // Si se proporcionó una nueva contraseña, enlazarla
                    if ($password) {
                        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                    }

                    // Ejecutar la consulta
                    $stmt->execute();

                    // Redirigir con éxito
                    $_SESSION['modificacionuser'] = 'Usuario modificado exitosamente';
                    header("Location: ../altamodulo.php");
                    exit();
                } catch (PDOException $e) {
                    echo "Error en la modificación: " . $e->getMessage();
                }
            } else {
                echo "Por favor completa todos los campos obligatorios.";
            }
        }
    } else {
        echo "No se proporcionó un ID de usuario válido.";
    }
}
?>
