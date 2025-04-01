<?php
include '../valores/conexion.php';
require_once '../../vendor/autoload.php';
session_start();

$navegador = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
$Navegador = 'http://127.0.0.1'.$navegador;

if ($Navegador !== 'http://127.0.0.1/proyecto7/admin/inventariomodulo.php') {
    // Redirigir o mostrar mensaje de error si el acceso no es válido
    header("Location: ../myadmin.php");
    exit();
}

$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del producto que se va a eliminar
    $insumoid = $purifier->purify($_POST['insumoid']);

    // Verificar si el producto ID está presente
    if (!empty($insumoid)) {
        try {
            // Buscar la imagen del producto antes de eliminarlo
            $stmt = $conn->prepare("SELECT In_ImagenInsumo FROM inventario WHERE In_InsumoId = :insumoid");
            $stmt->bindParam(':insumoid', $insumoid, PDO::PARAM_STR);
            $stmt->execute();
            $imageninsumo = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($imageninsumo) {
                // Eliminar la imagen del servidor si existe
                $rutaImagen = '../' . $imageninsumo['In_ImagenInsumo'];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }

                // Preparar la consulta SQL para eliminar el producto
                $sql = "DELETE FROM inventario WHERE In_InsumoId = :insumoid";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':insumoid', $insumoid, PDO::PARAM_STR);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    $_SESSION['eliminarinsumo'] = 'Insumo eliminado exitosamente.';
                } else {
                    $_SESSION['eliminarinsumo'] = 'Error al eliminar el producto.';
                }
            } else {
                $_SESSION['eliminarinsumo'] = 'El producto no existe.';
            }

        } catch (PDOException $e) {
            $_SESSION['eliminarinsumo'] = 'Error en la eliminación: ' . $e->getMessage();
        }
    } else {
        $_SESSION['eliminarinsumo'] = 'Por favor proporciona un ID de producto válido.';
    }

    // Redirigir al menú de productos
    header("Location: ../inventariomodulo.php");
    exit();
}
?>
