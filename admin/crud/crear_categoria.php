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
    $nombre_categoria = $purifier->purify($_POST['nombre_categoria']);
    $descripcion_categoria = $purifier->purify($_POST['descripcion_categoria']);
    $categoria_padre_id = $_POST['categoria_padre']; // Esto viene como hidden en el formulario
    //var_dump($categoria_padre_id); exit; 
    // Verificar si los campos no están vacíos
    if (!empty($nombre_categoria) && !empty($descripcion_categoria)) {
        
        // Preparar la consulta SQL para insertar los datos
        $sql = "INSERT INTO menucategoria 
            (MC_CategoriaId, MC_CCP_CategoriaPadreId, MC_NombreCategoria, MC_DescripcionCategoria, MC_AL_CreadoPor, MC_FechaCreacion) 
            VALUES (UUID(), :categoria_padre_id, :nombre_categoria, :descripcion_categoria, :creado_por, NOW())";

        try {
            $stmt = $conn->prepare($sql);
            // Asignar valores a los parámetros
            $stmt->bindParam(':categoria_padre_id', $categoria_padre_id, PDO::PARAM_STR);
            $stmt->bindParam(':nombre_categoria', $nombre_categoria, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion_categoria', $descripcion_categoria, PDO::PARAM_STR);
            $stmt->bindParam(':creado_por', $_SESSION['administrador'], PDO::PARAM_STR); // ID del administrador actual
            
            // Ejecutar la consulta
            $stmt->execute();

            // Redirigir con éxito
            
            $_SESSION['altacat'] = 'Categoría creada exitosamente';
            header("Location: ../crearmenu.php");
            exit();
        } catch (PDOException $e) {
            echo "Error en el registro: " . $e->getMessage();
        }
    } else {
        echo "Por favor completa todos los campos.";
    }
}
?>
