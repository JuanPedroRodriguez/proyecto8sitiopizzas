<?php

try {
    // Preparar la consulta SQL para obtener todas las categorías
    $sql = "SELECT 
                *
            FROM Inventario";
    
    $stmt = $conn->prepare($sql);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener todas las filas como un array asociativo
    $insumos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al obtener las categorías: " . $e->getMessage();
}
?>


