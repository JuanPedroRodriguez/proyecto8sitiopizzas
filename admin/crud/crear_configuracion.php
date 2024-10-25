<?php 
include '../valores/conexion.php'; // Conexión a la base de datos
require_once '../../vendor/autoload.php'; // Cargar HTML Purifier
session_start(); // Iniciar la sesión para mantener autenticación

// Configurar y inicializar HTML Purifier
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);

// Validar el acceso para asegurarse de que proviene de la página headermodulo.php
if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] !== 'http://127.0.0.1/proyecto7/admin/headermodulo.php') {
    // Redirigir o mostrar mensaje de error si el acceso no es válido
    header("Location: ../myadmin.php");
    exit();
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiar y asignar los datos de entrada usando HTML Purifier
    $categoria_padre_id = $purifier->purify($_POST['categoria_padre_id']);
    $nombre_categoria_padre_id = $purifier->purify($_POST['nombre_categoria_padre_id']);
    $color_fondo = $purifier->purify($_POST['color_fondo']);
    $color_texto_nombre_pestana = $purifier->purify($_POST['color_texto_nombre_pestana']);
    $color_fondo_nombre_pestana = $purifier->purify($_POST['color_fondo_nombre_pestana']);

    // Inicializar la variable de ruta de imagen
    $ruta_imagen = null;

    // Configuración para la carga de la imagen (si se subió una imagen)
    if (!empty($_FILES['imagen_1']['name'])) {
        // Definir la ruta donde se guardará la imagen
        $rutaImagen = '../../assets/imagenes/' . basename($_FILES['imagen_1']['name']);

        // Validar tipo de archivo
        $allowedMimeTypes = ['image/jpeg', 'image/png'];
        if (!in_array($_FILES['imagen_1']['type'], $allowedMimeTypes)) {
            $_SESSION['config_error'] = 'Solo se permiten imágenes JPEG o PNG.';
            header("Location: ../headermodulo.php");
            exit();
        }

        // Mover la imagen al directorio de imágenes
        if (!move_uploaded_file($_FILES['imagen_1']['tmp_name'], $rutaImagen)) {
            $_SESSION['config_error'] = 'Error al subir la imagen.';
            header("Location: ../headermodulo.php");
            exit();
        }
        // Actualizar la ruta de la imagen para guardar en la base de datos
        $ruta_imagen = '../assets/imagenes/' . basename($_FILES['imagen_1']['name']);
    }

    // Consulta SQL para insertar los datos en la tabla `configgen`
    $sql = "INSERT INTO configgen (CG_ConfigGenCategId, CG_ColorFondo, CG_ColorTextoNombrePestaña, CG_ColorFondoNombrePestaña, CG_Imagen1, CG_CCP_CategoriaPadreId, CG_CCP_NombreCategoriaPadre) 
            VALUES (UUID(), :color_fondo, :color_texto_nombre_pestana, :color_fondo_nombre_pestana, :ruta_imagen, :categoria_padre_id, :nombre_categoria_padre_id) ";

    try {
        $stmt = $conn->prepare($sql);

        // Asignar valores a los parámetros
        $stmt->bindParam(':color_fondo', $color_fondo, PDO::PARAM_STR);
        $stmt->bindParam(':color_texto_nombre_pestana', $color_texto_nombre_pestana, PDO::PARAM_STR);
        $stmt->bindParam(':color_fondo_nombre_pestana', $color_fondo_nombre_pestana, PDO::PARAM_STR);
        $stmt->bindParam(':ruta_imagen', $ruta_imagen, PDO::PARAM_STR);
        $stmt->bindParam(':categoria_padre_id', $categoria_padre_id, PDO::PARAM_STR);
        $stmt->bindParam(':nombre_categoria_padre_id', $nombre_categoria_padre_id, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Redirigir con mensaje de éxito
        $_SESSION['config_creada'] = 'Configuración del header creada exitosamente';
        header("Location: ../headermodulo.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al insertar la configuración: " . $e->getMessage();
    }
}
?>
