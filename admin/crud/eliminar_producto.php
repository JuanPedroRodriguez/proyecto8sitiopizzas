<?php
include '../valores/conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del producto que se va a eliminar
    $productoId = $_POST['producto_id'];

    // Verificar si el producto ID está presente
    if (!empty($productoId)) {
        try {
            // Buscar la imagen del producto antes de eliminarlo
            $stmt = $conn->prepare("SELECT MP_ImagenProducto FROM menuproduct WHERE MP_ProductoId = :producto_id");
            $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_STR);
            $stmt->execute();
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($producto) {
                // Eliminar la imagen del servidor si existe
                $rutaImagen = '../' . $producto['MP_ImagenProducto'];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }

                // Preparar la consulta SQL para eliminar el producto
                $sql = "DELETE FROM menuproduct WHERE MP_ProductoId = :producto_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_STR);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    $_SESSION['eliminarprod'] = 'Producto eliminado exitosamente.';
                } else {
                    $_SESSION['eliminarprod'] = 'Error al eliminar el producto.';
                }
            } else {
                $_SESSION['eliminarprod'] = 'El producto no existe.';
            }

        } catch (PDOException $e) {
            $_SESSION['eliminarprod'] = 'Error en la eliminación: ' . $e->getMessage();
        }
    } else {
        $_SESSION['eliminarprod'] = 'Por favor proporciona un ID de producto válido.';
    }

    // Redirigir al menú de productos
    header("Location: ../crearmenu.php");
    exit();
}
?>
