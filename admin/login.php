<?php
// Incluir el archivo de conexión
include 'valores/conexion.php';
require_once '../vendor/autoload.php';

// Configurar HTML Purifier
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier();


if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] !== 'http://127.0.0.1/proyecto7/admin/myadmin.php') {
    // Redirigir o mostrar mensaje de error si el acceso no es válido
    header("Location: myadmin.php");
    exit();
}
// Obtener los valores del formulario y purificarlos
$nombreDeUsuario = $purifier->purify($_POST['username']);
$contrasena = $purifier->purify($_POST['password']);

try {
    // Preparar la consulta para evitar inyecciones SQL
    $sql = "SELECT * FROM adminlogin WHERE AL_NombreDeUsuario = :nombreDeUsuario";
    $stmt = $conn->prepare($sql);
    
    // Vincular el parámetro
    $stmt->bindParam(':nombreDeUsuario', $nombreDeUsuario);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener el resultado como objeto
    $resultado = $stmt->fetch(PDO::FETCH_OBJ);
  
    // Verificar si se encontró el usuario
    if ($resultado) {
        // Acceder a la contraseña
        $contrasenaGuardada = $resultado->AL_Contrasena;
        $usuarioId = $resultado->AL_SocioId;
        //var_dump(password_verify($contrasena, $contrasenaGuardada)); exit;
        // Verificar la contraseña usando password_verify
        if (password_verify($contrasena, $contrasenaGuardada)) {
            // Contraseña correcta, procede con el login
            session_start();
            $_SESSION['administrador'] = $nombreDeUsuario;
            $_SESSION['administradorId'] = $usuarioId;
            header("Location: adminmodulo.php"); // Redirigir a otra página
            exit();
        } else {
            session_start();
            $_SESSION['errorlogin'] = 'Contraseña Incorrecta';
            header("Location: adminmodulo.php"); // Redirigir a otra página
        }
    } else {
        $alerta = "Usuario no encontrado";
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}

?>
