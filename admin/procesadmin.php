<?php
// Incluir el archivo de conexión
include 'valores/conexion.php';

// Insertar los datos
/*$nombreDeUsuario = $_POST['username'];
$nombres = "Prueba";
$correo = "prueba@ejemplo.com";
$contrasena = "Ohxn9l"; // Contraseña sin encriptar solo para ejemplo
$contrasena = password_hash("Ohxn9l", PASSWORD_BCRYPT); 

// Query para insertar los datos en la tabla adminlogin
$sql = "INSERT INTO adminlogin (AL_NombreDeUsuario, `AL_Nombre(s)`, AL_Correo, AL_Contrasena)
        VALUES ('$nombreDeUsuario', '$nombres', '$correo', '$contrasena')";

if ($conn->query($sql) === TRUE) {
    echo "Nuevo registro insertado exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
*/
// Recoger datos del formulario de login
/*$nombreDeUsuario = $_POST['username'];
$contrasena = $_POST['password'];

// Preparar la consulta para evitar inyecciones SQL
$sql = "SELECT * FROM adminlogin WHERE AL_NombreDeUsuario = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombreDeUsuario);
$stmt->execute();

// Obtener el resultado como un array asociativo
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
var_dump($resultado); exit;*/
// Verificar si el usuario existe
/*if ($stmt->num_rows > 0) {
    // Asociar el resultado y obtener la contraseña encriptada
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    
    // Verificar si la contraseña es correcta
    if (password_verify($contrasena, $hashedPassword)) {
        echo "Login exitoso. ¡Bienvenido!";
        // Aquí podrías iniciar sesión con sesiones, cookies, etc.
        session_start();
        $_SESSION['admin'] = $nombreDeUsuario; // Iniciar sesión
        // Redirigir a la página de administrador
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}
*/
// Obtener los valores del formulario
$nombreDeUsuario = $_POST['username'];
$contrasena = $_POST['password'];

try {
    // Preparar la consulta para evitar inyecciones SQL
    $sql = "SELECT * FROM adminlogin WHERE AL_NombreDeUsuario = :nombreDeUsuario";
    $stmt = $conn->prepare($sql);
    
    // Vincular el parámetro
    $stmt->bindParam(':nombreDeUsuario', $nombreDeUsuario);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener el resultado como objetos
    $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    // Verificar si se encontró el usuario
    if ($resultado) {
        // Acceder a la contraseña
        $contrasenaGuardada = $resultado[0]->AL_Contrasena;
        //var_dump($contrasena); exit;
        // Aquí puedes verificar la contraseña ingresada con la guardada
        if ($contrasena == $contrasenaGuardada) {
            // Contraseña correcta, procede con el login
            session_Start();
            $_SESSION['administrador'] = $nombreDeUsuario;
            header("Location: adminmodulo.php"); // Redirigir a otra página
            exit();
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}

?>
