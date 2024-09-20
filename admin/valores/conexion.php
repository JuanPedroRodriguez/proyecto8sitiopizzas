<?php
// Datos de conexión a la base de datos
$servername = "127.0.0.1"; // Dirección del servidor
$username = "root";        // Usuario de la base de datos
$password = "";            // Contraseña (deberías cambiarla si no está vacía)
$dbname = "administrador"; // Nombre de tu base de datos

try {
    // Crear conexión usando PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Establecer el modo de error de PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexión fallida: " . $e->getMessage());
}