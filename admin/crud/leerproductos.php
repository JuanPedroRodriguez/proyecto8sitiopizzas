<?php

function obtenerProductosPorCategoria($categoriaId) {
    global $conn;

    try {
        // Preparar la consulta SQL
        $sql = "SELECT * FROM menuproduct WHERE MP_MC_CategoriaId = :categoria_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':categoria_id', $categoriaId, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Devolver los productos obtenidos
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejar el error y mostrar mensaje (puedes cambiar esto por loguear el error en lugar de mostrarlo)
        echo "Error al obtener los productos: " . $e->getMessage();
        return [];
    }
}
?>