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

    // Configuración para la carga de la imagen (si se subió una imagen)
    if (!empty($_FILES['imagen_1']['name'])) {
        $nombre_imagen = $_FILES['imagen_1']['name'];
        $ruta_imagen = '../../assets/imagenes/' . basename($nombre_imagen);


         // Consultar la imagen antigua para eliminarla
         $stmt = $conn->prepare("SELECT CG_Imagen1 FROM configgen WHERE CG_CCP_CategoriaPadreId = :categoria_padre_id AND CG_CCP_NombreCategoriaPadre = :nombre_categoria_padre_id");
         $stmt->bindParam(':categoria_padre_id', $categoria_padre_id, PDO::PARAM_STR);
         $stmt->bindParam(':nombre_categoria_padre_id', $nombre_categoria_padre_id, PDO::PARAM_STR);
         $stmt->execute();
         $oldImage = $stmt->fetchColumn();
 
         // Eliminar la imagen antigua si existe
         if ($oldImage && file_exists('../../' . $oldImage)) {
             unlink('../../' . $oldImage); // Eliminar la imagen antigua
         }
        // Mover la imagen al directorio de imágenes
        if (!move_uploaded_file($_FILES['imagen_1']['tmp_name'], $ruta_imagen)) {
            echo "Error al subir la imagen.";
            exit();
        }
    } else {
        $ruta_imagen = null; // Si no hay imagen, dejar el campo como null
    }
    $ruta_imagen = '../assets/imagenes/' . basename($_FILES['imagen_1']['name']);
    //var_dump($ruta_imagen); exit;
    // Consulta SQL para actualizar los datos en la tabla `configgen`
    $sql = " UPDATE configgen 
            SET CG_ColorFondo = :color_fondo,
                CG_ColorTextoNombrePestaña = :color_texto_nombre_pestana,
                CG_ColorFondoNombrePestaña = :color_fondo_nombre_pestana,
                CG_Imagen1 = :ruta_imagen
            WHERE CG_CCP_CategoriaPadreId = :categoria_padre_id
              AND CG_CCP_NombreCategoriaPadre = :nombre_categoria_padre_id";

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
        $_SESSION['config_guardada'] = 'Configuración del header actualizada exitosamente';
        header("Location: ../headermodulo.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al actualizar la configuración: " . $e->getMessage();
    }
}
?>
