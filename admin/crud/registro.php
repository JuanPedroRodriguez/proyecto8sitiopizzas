<?php 
include '../valores/conexion.php';
require_once '../../vendor/autoload.php';

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
    $nombre_usuario = $purifier->purify($_POST['nombre_usuario']);
    $nombre = $purifier->purify($_POST['nombre']);
    $primer_apellido = $purifier->purify($_POST['primer_apellido']);
    $segundo_apellido = $purifier->purify($_POST['segundo_apellido']);
    $email = $purifier->purify($_POST['email']);
    $password = $purifier->purify($_POST['password']);

    //validaciones para evitar duplicados
    


    // Validar que los campos no estén vacíos
    if (!empty($nombre_usuario) && !empty($email) && !empty($password)) {
        // Hashear la contraseña
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);


        // Preparar la consulta SQL para insertar los datos
        $sql = "INSERT INTO adminlogin (AL_SocioId, AL_NombreDeUsuario, AL_Nombre,AL_PrimerApellido,AL_SegundoApellido,AL_Correo, AL_Contrasena) VALUES (UUID(), :nombre_usuario, :nombre,:primer_apellido,:segundo_apellido,:email, :password)";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':primer_apellido', $primer_apellido, PDO::PARAM_STR);
            $stmt->bindParam(':segundo_apellido', $segundo_apellido, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password_hashed, PDO::PARAM_STR);
            
            // Ejecutar la consulta
            $stmt->execute();

            session_start();
            $_SESSION['alta'] = 'Registro Exitoso';
            header("Location: ../altamodulo.php");
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
