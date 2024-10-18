<?php 
include '../valores/conexion.php'; 
require_once '../../vendor/autoload.php'; 
session_start();

// Inicializar HTML Purifier
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier();

if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] !== 'http://127.0.0.1/proyecto7/admin/crearmenu.php') {
    // Redirigir o mostrar mensaje de error si el acceso no es válido
    header("Location: ../myadmin.php");
    exit();
}
// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Limpiar los datos de entrada
    $categoriaId = $_POST['categoria_id'];
    $nombreProducto = $purifier->purify($_POST['nombre_producto']);
    $descripcionProducto = $purifier->purify($_POST['descripcion_producto']);
    $precioProducto = $_POST['precio_producto'];
    $imagenProducto = $_FILES['imagen_producto'];

    // Verificar si los campos no están vacíos y si se subió una imagen
    if (!empty($nombreProducto) && !empty($descripcionProducto) && !empty($precioProducto) && $imagenProducto['error'] === UPLOAD_ERR_OK) {
        
        // Definir la ruta donde se guardará la imagen
        $rutaImagen = '../../assets/imagenesProductos/' . basename($imagenProducto['name']);
       // var_dump($imagenProducto['tmp_name']); exit;
        // Mover la imagen al directorio especificado
        if (move_uploaded_file($imagenProducto['tmp_name'], $rutaImagen)) {
            
            $rutaImagen = '../assets/imagenesProductos/' . basename($imagenProducto['name']);
            // Preparar la consulta SQL para insertar los datos
            $sql = "INSERT INTO menuproduct 
                (MP_ProductoId, MP_MC_CategoriaId, MP_NombreProducto, MP_DescripcionProducto, MP_ImagenProducto, MP_PrecioProducto, MP_AL_CreadorPor, MP_FechaCreacion) 
                VALUES (UUID(), :categoria_id, :nombre_producto, :descripcion_producto, :imagen_producto, :precio_producto, :creador_por, NOW())";

            try {
                $stmt = $conn->prepare($sql);
                // Asignar valores a los parámetros
                $stmt->bindParam(':categoria_id', $categoriaId, PDO::PARAM_STR);
                $stmt->bindParam(':nombre_producto', $nombreProducto, PDO::PARAM_STR);
                $stmt->bindParam(':descripcion_producto', $descripcionProducto, PDO::PARAM_STR);
                $stmt->bindParam(':imagen_producto', $rutaImagen, PDO::PARAM_STR);
                $stmt->bindParam(':precio_producto', $precioProducto, PDO::PARAM_STR);
                $stmt->bindParam(':creador_por', $_SESSION['administrador'], PDO::PARAM_STR); // ID del administrador actual

                // Ejecutar la consulta
                $stmt->execute();

                // Redirigir con éxito
                $_SESSION['crearprod'] = 'Producto creado exitosamente.';
                header("Location: ../crearmenu.php");
                exit();
            } catch (PDOException $e) {
                echo "Error en el registro: " . $e->getMessage();
            }
        } else {
            $_SESSION['crearprod'] = 'Error al mover la imagen.';
            header("Location: ../crearmenu.php");
            exit();
        }
    } else {
        $_SESSION['crearprod'] = 'Por favor completa todos los campos y asegúrate de subir una imagen válida.';
        header("Location: ../crearmenu.php");
        exit();
    }
} else {
    // Si el acceso no es por POST
    header("Location: ../crearmenu.php");
    exit();
}
?>
