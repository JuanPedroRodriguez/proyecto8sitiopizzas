<?php

try {
    // Preparar la consulta SQL para obtener todas las categorías
    $sql = "SELECT 
                MC_CategoriaId, 
                MC_CCP_CategoriaPadreId, 
                MC_NombreCategoria, 
                MC_DescripcionCategoria, 
                MC_AL_CreadoPor, 
                MC_AL_ModificadoPor, 
                MC_FechaCreacion,
                MC_FechaModificacion 
            FROM menucategoria";
    
    $stmt = $conn->prepare($sql);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener todas las filas como un array asociativo
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al obtener las categorías: " . $e->getMessage();
}
?>


