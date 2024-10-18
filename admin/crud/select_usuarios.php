<?php
try {
    // Preparar la consulta SQL para obtener todos los usuarios administradores
    $sql = "SELECT 
                AL_SocioId, 
                AL_NombreDeUsuario, 
                AL_PrimerApellido,
                AL_SegundoApellido,
                AL_Correo
            FROM adminlogin";
    
    $stmt = $conn->prepare($sql);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener todas las filas como un array asociativo
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al obtener los usuarios: " . $e->getMessage();
}
?>
