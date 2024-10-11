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
    $categoria_id = $_POST['categoria_id']; // Esto viene como hidden en el formulario
    $nombre_categoria = $purifier->purify($_POST['nombre_categoria']);
    $descripcion_categoria = $purifier->purify($_POST['descripcion_categoria']);

    // Verificar que los campos no estén vacíos
    if (!empty($categoria_id) && !empty($nombre_categoria) && !empty($descripcion_categoria)) {
        
        // Preparar la consulta SQL para actualizar los datos
        $sql = "UPDATE menucategoria 
                SET MC_NombreCategoria = :nombre_categoria, 
                    MC_DescripcionCategoria = :descripcion_categoria, 
                    MC_AL_ModificadoPor = :modificado_por, 
                    MC_FechaModificacion = NOW()
                WHERE MC_CategoriaId = :categoria_id";

        try {
            $stmt = $conn->prepare($sql);
            // Asignar valores a los parámetros
            $stmt->bindParam(':nombre_categoria', $nombre_categoria, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion_categoria', $descripcion_categoria, PDO::PARAM_STR);
            $stmt->bindParam(':modificado_por', $_SESSION['administrador'], PDO::PARAM_STR); // ID del administrador actual
            $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_STR);
            
            // Ejecutar la consulta
            $stmt->execute();

            // Redirigir con éxito
            $_SESSION['modificacioncat'] = 'Categoría modificada exitosamente';
            header("Location: ../crearmenu.php");
            exit();
        } catch (PDOException $e) {
            echo "Error en la modificación: " . $e->getMessage();
        }
    } else {
        echo "Por favor completa todos los campos.";
    }
}
?>
