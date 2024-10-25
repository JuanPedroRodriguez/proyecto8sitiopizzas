<?php
try {
    // Preparar la consulta SQL para obtener los datos de configgen donde el nombre de categoría padre sea 'header'
    $sql = "SELECT 
                *
            FROM configgen
            WHERE CG_CCP_NombreCategoriaPadre = 'header' ";
    
    $stmt = $conn->prepare($sql);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener todas las filas como un array asociativo
    $configuracion_header = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al obtener la configuración del header: " . $e->getMessage();
}
?>
