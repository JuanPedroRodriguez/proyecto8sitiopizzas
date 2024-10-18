<?php
include '../valores/conexion.php';
session_start();

if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] !== 'http://127.0.0.1/proyecto7/admin/crearmenu.php') {
    // Redirigir o mostrar mensaje de error si el acceso no es válido
    header("Location: ../myadmin.php");
    exit();
}
// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID de la categoría
    $categoria_id = $_POST['categoria_id'];

    if (!empty($categoria_id)) {
        try {
            // 1. Obtener las rutas de las imágenes de los productos asociados a la categoría
            $sql = "SELECT MP_ImagenProducto FROM menuproduct WHERE MP_MC_CategoriaId = :categoria_id";
            $stmt = $conn->prepare($sql);
            // Asignar valor al parámetro
            $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_STR);
            // Ejecutar la consulta
            $stmt->execute();
            
            // Obtener todas las rutas de las imágenes
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // 2. Eliminar físicamente las imágenes del servidor
            foreach ($productos as $producto) {
                $rutaImagen = '../' . $producto['MP_ImagenProducto']; // Ajustar la ruta si es necesario
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen); // Eliminar la imagen del servidor
                }
            }

            // 3. Eliminar los productos asociados a la categoría
            $sql = "DELETE FROM menuproduct WHERE MP_MC_CategoriaId = :categoria_id";
            $stmt = $conn->prepare($sql);
            // Asignar valor al parámetro
            $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_STR);
            // Ejecutar la consulta
            $stmt->execute();

            // 4. Eliminar la categoría
            $sql = "DELETE FROM menucategoria WHERE MC_CategoriaId = :categoria_id";
            $stmt = $conn->prepare($sql);
            // Asignar valor al parámetro
            $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_STR);
            // Ejecutar la consulta
            $stmt->execute();

            // Redirigir con éxito
            $_SESSION['eliminarcat'] = 'Categoría eliminada exitosamente junto con sus productos e imágenes.';
            header("Location: ../crearmenu.php");
            exit();

        } catch (PDOException $e) {
            echo "Error al eliminar la categoría y sus productos: " . $e->getMessage();
        }
    } else {
        echo "ID de categoría no válido.";
    }
} else {
    echo "Solicitud no válida.";
}
?>
