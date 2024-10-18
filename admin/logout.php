<?php
// Iniciar la sesión si no está iniciada
session_start();

// Destruir las variables de sesión específicas
if (isset($_SESSION['administrador']) || isset($_SESSION['administradorId'])) {
    unset($_SESSION['administrador']);  // Eliminar la sesión del administrador
    unset($_SESSION['administradorId']); // Eliminar la sesión del administradorId
}

// Destruir toda la sesión si es necesario
session_destroy(); // Esto elimina todas las sesiones

// Redirigir a la página de inicio de sesión o a la página deseada
header("Location: myadmin.php"); // Cambia 'login.php' por la página que desees
exit();
