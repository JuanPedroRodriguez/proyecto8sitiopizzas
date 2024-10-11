<?php
include '../valores/conexion.php';
require_once '../../vendor/autoload.php';
session_start();

// Inicializar HTML Purifier
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier();

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Limpiar los datos de entrada
    $productoId = $_POST['producto_id']; // Este vendrá como hidden en el formulario del modal
    $categoriaId = $_POST['categoria_id'];
    $nombreProducto = $purifier->purify($_POST['nombre_producto']);
    $descripcionProducto = $purifier->purify($_POST['descripcion_producto']);
    $precioProducto = $_POST['precio_producto'];
    $imagenProducto = $_FILES['imagen_producto'];

    // Verificar si los campos no están vacíos
    if (!empty($productoId) && !empty($nombreProducto) && !empty($descripcionProducto) && !empty($precioProducto)) {

        // Si se subió una nueva imagen, se procesa
        if ($imagenProducto['error'] === UPLOAD_ERR_OK) {
            // Definir la ruta de la nueva imagen
            $rutaImagen = '../../assets/imagenesProductos/' . basename($imagenProducto['name']);
            
            $allowedMimeTypes = ['image/jpeg', 'image/png'];
            if (!in_array($imagenProducto['type'], $allowedMimeTypes)) {
                $_SESSION['modificarprod'] = 'Solo se permiten imágenes JPEG o PNG.';
                header("Location: ../crearmenu.php");
                exit();
            }
            // Antes de mover la nueva imagen
            $stmt = $conn->prepare("SELECT MP_ImagenProducto FROM menuproduct WHERE MP_ProductoId = :producto_id");
            $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_STR);
            $stmt->execute();
            $oldImage = $stmt->fetchColumn();
            if ($oldImage && file_exists('../' . $oldImage)) {
                unlink('../' . $oldImage); // Eliminar la imagen antigua
            }
            // Mover la nueva imagen al directorio especificado
            if (move_uploaded_file($imagenProducto['tmp_name'], $rutaImagen)) {
                $rutaImagen = '../assets/imagenesProductos/' . basename($imagenProducto['name']);
            } else {
                $_SESSION['modificarprod'] = 'Error al mover la nueva imagen.';
                header("Location: ../crearmenu.php");
                exit();
            }
        }

        // Preparar la consulta SQL para actualizar el producto
        $sql = "UPDATE menuproduct 
                SET MP_MC_CategoriaId = :categoria_id, 
                    MP_NombreProducto = :nombre_producto, 
                    MP_DescripcionProducto = :descripcion_producto, 
                    MP_PrecioProducto = :precio_producto, 
                    MP_AL_ModificadoPor = :modificado_por, 
                    MP_FechaModificacion = NOW()";

        // Si se subió una nueva imagen, también actualizar el campo de la imagen
        if ($imagenProducto['error'] === UPLOAD_ERR_OK) {
            $sql .= ", MP_ImagenProducto = :imagen_producto";
        }

        $sql .= " WHERE MP_ProductoId = :producto_id";

        try {
            $stmt = $conn->prepare($sql);
            // Asignar valores a los parámetros
            $stmt->bindParam(':categoria_id', $categoriaId, PDO::PARAM_STR);
            $stmt->bindParam(':nombre_producto', $nombreProducto, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion_producto', $descripcionProducto, PDO::PARAM_STR);
            $stmt->bindParam(':precio_producto', $precioProducto, PDO::PARAM_STR);
            $stmt->bindParam(':modificado_por', $_SESSION['administrador'], PDO::PARAM_STR); // ID del administrador actual
            $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_STR);
            
            if ($imagenProducto['error'] === UPLOAD_ERR_OK) {
                $stmt->bindParam(':imagen_producto', $rutaImagen, PDO::PARAM_STR);
            }

            // Ejecutar la consulta
            $stmt->execute();

            // Redirigir con éxito
            $_SESSION['modificarprod'] = 'Producto modificado exitosamente.';
            header("Location: ../crearmenu.php");
            exit();
        } catch (PDOException $e) {
            echo "Error en la modificación: " . $e->getMessage();
        }
    } else {
        $_SESSION['modificarprod'] = 'Por favor completa todos los campos.';
        header("Location: ../crearmenu.php");
        exit();
    }
}
?>
