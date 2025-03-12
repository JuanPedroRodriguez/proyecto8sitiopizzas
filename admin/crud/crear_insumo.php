<?php 
include '../valores/conexion.php'; 
require_once '../../vendor/autoload.php';
session_start();
// Inicializar HTML Purifier
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier();

if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] !== 'http://127.0.0.1/proyecto7/admin/inventariomodulo.php') {
    // Redirigir o mostrar mensaje de error si el acceso no es válido
    header("Location: ../myadmin.php");
    exit();
}
// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiar los datos de entrada
    $nombre_insumo = $purifier->purify($_POST['nombre_insumo']);
    $piezas = $purifier->purify($_POST['piezas']);
    $gramos = $purifier->purify($_POST['gramos']);
    $kilogramos = $purifier->purify($_POST['kilogramos']);
    $litros = $purifier->purify($_POST['litros']);
    $mililitros = $purifier->purify($_POST['mililitros']);
    $porcion = $purifier->purify($_POST['porcion']);
    $otro = $purifier->purify($_POST['otro']);
    $imagen_insumo = $_FILES['imagen_insumo'];
    //var_dump($categoria_padre_id); exit; 

    // Configuración para la carga de la imagen (si se subió una imagen)
    if (!empty($_FILES['imagen_insumo']['name'])) {
        $nombre_imagen = $_FILES['imagen_insumo']['name'];
        $ruta_imagen = '../../assets/imagenes/' . basename($nombre_imagen);

        // Mover la imagen al directorio de imágenes
        if (!move_uploaded_file($_FILES['imagen_insumo']['tmp_name'], $ruta_imagen)) {
            echo "Error al subir la imagen.";
            exit();
        }
        $ruta_imagen = '../assets/imagenes/' . basename($_FILES['imagen_insumo']['name']);
    } else {
        $ruta_imagen = null; // Si no hay imagen, dejar el campo como null
    }
    // Verificar si los campos no están vacíos
    if (!empty($nombre_insumo)) {
        
        // Preparar la consulta SQL para insertar los datos
        $sql = "INSERT INTO inventario 
            (In_InsumoId, In_NombreInsumo, In_NumeroPiezas, In_PesoGramos, In_PesoKilos, In_Mililitros, In_Litros, In_Porcion, In_Otro, In_ImagenInsumo) 
            VALUES (UUID(), :NombreInsumo, :NumeroPiezas, :PesoGramos, :PesoKilos, :Mililitros, :Litros, :Porcion, :Otro, :ImagenInsumo)";

        try {
            $stmt = $conn->prepare($sql);
            // Asignar valores a los parámetros
            $stmt->bindParam(':NombreInsumo', $nombre_insumo, PDO::PARAM_STR);
            $stmt->bindParam(':NumeroPiezas', $piezas, PDO::PARAM_INT);
            $stmt->bindParam(':PesoGramos', $gramos, PDO::PARAM_INT);
            $stmt->bindParam(':PesoKilos', $kilogramos, PDO::PARAM_INT);
            $stmt->bindParam(':Mililitros', $mililitros, PDO::PARAM_INT);
            $stmt->bindParam(':Litros', $litros, PDO::PARAM_INT);
            $stmt->bindParam(':Porcion', $porcion, PDO::PARAM_INT);
            $stmt->bindParam(':Otro', $otro, PDO::PARAM_STR);
            $stmt->bindParam(':ImagenInsumo', $ruta_imagen, PDO::PARAM_STR);
           
            
            // Ejecutar la consulta
            $stmt->execute();

            // Redirigir con éxito
            $_SESSION['altain'] = 'Insumo registrado exitosamente';
            header("Location: ../inventariomodulo.php");
            exit();
        } catch (PDOException $e) {
            echo "Error en el registro: " . $e->getMessage();
        }
    } else {
        echo "Por favor completa todos los campos.";
    }
}
?>
