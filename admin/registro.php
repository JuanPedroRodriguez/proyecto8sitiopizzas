<?php 
include 'valores/conexion.php';
require_once '../vendor/autoload.php';

// Inicializar HTML Purifier
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier();

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiar los datos de entrada
    $nombre_usuario = $purifier->purify($_POST['nombre_usuario']);
    $email = $purifier->purify($_POST['email']);
    $password = $purifier->purify($_POST['password']);

    // Validar que los campos no estén vacíos
    if (!empty($nombre_usuario) && !empty($email) && !empty($password)) {
        // Hashear la contraseña
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);


        // Preparar la consulta SQL para insertar los datos
        $sql = "INSERT INTO adminlogin (AL_SocioId, AL_NombreDeUsuario, AL_Correo, AL_Contrasena) VALUES (UUID(), :nombre_usuario, :email, :password)";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password_hashed, PDO::PARAM_STR);
            
            // Ejecutar la consulta
            $stmt->execute();

            session_start();
            $_SESSION['alta'] = 'Registro Exitoso';
            header("Location: altamodulo.php");
            exit();
        } catch (PDOException $e) {
            // Manejo de errores por violación de UNIQUE
            if ($e->getCode() == 23000) { // Código de error para violación de restricción UNIQUE
                echo "Error: El SocioId ya existe.";
            } else {
                echo "Error en el registro: " . $e->getMessage();
            }
        }
    } else {
        echo "Por favor completa todos los campos.";
    }
}
?>
