<?php
include '../valores/conexion.php';
require_once '../../vendor/autoload.php';
session_start();

// Inicializar HTML Purifier
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier();

$navegador = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
$Navegador = 'http://127.0.0.1'.$navegador;

if ($Navegador !== 'http://127.0.0.1/proyecto7/admin/inventariomodulo.php') {
    // Redirigir o mostrar mensaje de error si el acceso no es válido
    header("Location: ../myadmin.php");
    exit();
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiar los datos de entrada
    $insumoid = $purifier->purify($_POST['insumoid']); // Este vendrá como hidden en el formulario del modal
    $nombre_insumo = $purifier->purify($_POST['nombre_insumo']);
    $piezas = $purifier->purify($_POST['piezas']);
    $gramos = $purifier->purify($_POST['gramos']);
    $kilogramos = $purifier->purify($_POST['kilogramos']);
    $litros = $purifier->purify($_POST['litros']);
    $mililitros = $purifier->purify($_POST['mililitros']);
    $porcion = $purifier->purify($_POST['porcion']);
    $otro = $purifier->purify($_POST['otro']);
    $imageninsumo = $_FILES['imageninsumo'];

    // Verificar que los campos necesarios no estén vacíos
    if (!empty($insumoid) && !empty($nombre_insumo)) {

        // Si se subió una nueva imagen, se procesa
        if ($imageninsumo['error'] === UPLOAD_ERR_OK) {
            // Definir la ruta de la nueva imagen
            $rutaImagen = '../../assets/imagenesInsumos/' . basename($imageninsumo['name']);
            

            // Consultar la imagen antigua para eliminarla
            $stmt = $conn->prepare("SELECT In_ImagenInsumo FROM inventario WHERE In_InsumoId = :insumoid");
            $stmt->bindParam(':insumoid', $insumoid, PDO::PARAM_STR);
            $stmt->execute();
            $oldImage = $stmt->fetchColumn();

            // Eliminar la imagen antigua si existe
            if ($oldImage && file_exists('../' . $oldImage)) {
                unlink('../' . $oldImage); // Eliminar la imagen antigua
            }

            // Mover la nueva imagen al directorio especificado
            if (!move_uploaded_file($imageninsumo['tmp_name'], $rutaImagen)) {
                $_SESSION['modificarinsumo'] = 'Error al mover la nueva imagen.';
                header("Location: ../inventariomodulo.php");
                exit();
            }
            $rutaImagen = '../assets/imagenesInsumos/' . basename($imageninsumo['name']); // Actualizar la ruta
        }

        // Preparar la consulta SQL para actualizar el producto
        $sql = "UPDATE inventario 
                SET In_NombreInsumo = :nombre_insumo, 
                    In_NumeroPiezas = :piezas, 
                    In_PesoGramos = :gramos, 
                    In_PesoKilos = :kilogramos, 
                    In_Mililitros = :mililitros,
                    In_Litros = :litros,
                    In_Porcion = :porcion,
                    In_Otro = :otro ";

        // Si se subió una nueva imagen, incluirla en la consulta
        if ($imageninsumo['error'] === UPLOAD_ERR_OK) {
            $sql .= ", In_ImagenInsumo = :imageninsumo";
        }

        $sql .= " WHERE In_InsumoId = :insumoId";

        try {
            $stmt = $conn->prepare($sql);
            // Asignar valores a los parámetros
            $stmt->bindParam(':insumoId', $insumoid, PDO::PARAM_STR);
            $stmt->bindParam(':nombre_insumo', $nombre_insumo, PDO::PARAM_STR);
            $stmt->bindParam(':piezas', $piezas, PDO::PARAM_STR);
            $stmt->bindParam(':gramos', $gramos, PDO::PARAM_STR);
            $stmt->bindParam(':kilogramos', $kilogramos, PDO::PARAM_STR); 
            $stmt->bindParam(':mililitros', $mililitros, PDO::PARAM_STR);
            $stmt->bindParam(':litros', $litros, PDO::PARAM_STR);
            $stmt->bindParam(':porcion', $porcion, PDO::PARAM_STR);
            $stmt->bindParam(':otro', $otro, PDO::PARAM_STR);
            
            if ($imageninsumo['error'] === UPLOAD_ERR_OK) {
                $stmt->bindParam(':imageninsumo', $rutaImagen, PDO::PARAM_STR);
            }

            // Ejecutar la consulta
            $stmt->execute();

            // Redirigir con éxito
            $_SESSION['modificarinsumo'] = 'Insumo modificado exitosamente.';
            header("Location: ../inventariomodulo.php");
            exit();
        } catch (PDOException $e) {
            echo "Error en la modificación: " . $e->getMessage();
        }
    } else {
        $_SESSION['modificarinsumo'] = 'Por favor completa todos los campos.';
        header("Location: ../inventariomodulo.php");
        exit();
    }
}
?>
