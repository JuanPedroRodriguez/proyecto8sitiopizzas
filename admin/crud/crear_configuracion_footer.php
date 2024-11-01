<?php 
include '../valores/conexion.php'; // Conexión a la base de datos
require_once '../../vendor/autoload.php'; // Cargar HTML Purifier
session_start(); // Iniciar la sesión para mantener autenticación

// Configurar y inicializar HTML Purifier
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);

// Validar el acceso para asegurarse de que proviene de la página headermodulo.php
if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] !== 'http://127.0.0.1/proyecto7/admin/footermodulo.php') {
    // Redirigir o mostrar mensaje de error si el acceso no es válido
    header("Location: ../myadmin.php");
    exit();
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiar y asignar los datos de entrada usando HTML Purifier
    $categoria_padre_id = "5e031d57-76d7-11ef-b08e-4cd7178be01c";
    $nombre_categoria_padre_id = "footer";
    $color_fondo = $purifier->purify($_POST['color_fondo']);
    $color_texto_nombre_pestana = $purifier->purify($_POST['color_texto_nombre_pestana']);
    $link_didi = $purifier->purify($_POST['didi']);
    $link_rappi = $purifier->purify($_POST['rappi']);
    $link_ubereats = $purifier->purify($_POST['ubereats']);
    $leyenda_derechos = $purifier->purify($_POST['derechos']);
    
    // Inicializar la variable de ruta de imagen como NULL
    $ruta_imagen = NULL;

    // Consulta SQL para insertar los datos en la tabla `configgen`
    $sql = "INSERT INTO configgen (CG_ConfigGenCategId, CG_ColorFondoFooter, CG_ColorTextoNombrePestañaFooter,CG_LinkDidi, CG_LinkRappi, CG_LinkUbereats, CG_DerechosReservados, CG_CCP_CategoriaPadreId, CG_CCP_NombreCategoriaPadre) 
                                        VALUES (UUID(), :color_fondo, :color_texto_nombre_pestana,:didi, :rappi, :ubereats, :derechos, :categoria_padre_id, :nombre_categoria_padre_id) ";

    try {
        $stmt = $conn->prepare($sql);

        // Asignar valores a los parámetros
        $stmt->bindParam(':color_fondo', $color_fondo, PDO::PARAM_STR);
        $stmt->bindParam(':color_texto_nombre_pestana', $color_texto_nombre_pestana, PDO::PARAM_STR);
        $stmt->bindParam(':didi', $link_didi, PDO::PARAM_STR);
        $stmt->bindParam(':rappi', $link_rappi, PDO::PARAM_STR);
        $stmt->bindParam(':ubereats', $link_ubereats, PDO::PARAM_STR);
        $stmt->bindParam(':derechos', $leyenda_derechos, PDO::PARAM_STR);
        $stmt->bindParam(':categoria_padre_id', $categoria_padre_id, PDO::PARAM_STR);
        $stmt->bindParam(':nombre_categoria_padre_id', $nombre_categoria_padre_id, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Redirigir con mensaje de éxito
        $_SESSION['config_creada_footer'] = 'Configuración del footer creada exitosamente';
        header("Location: ../footermodulo.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al insertar la configuración: " . $e->getMessage();
    }
}
?>
