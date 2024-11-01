<?php
session_start(); // Iniciar la sesión

// Verificar si la sesión 'administrador' no está configurada
if (!isset($_SESSION['administrador'])) {
    // Redirigir a myadmin.php
    header("Location: myadmin.php");
    exit(); // Asegúrate de usar exit después de header
}
if (isset($_SESSION['config_creada'])) {
  echo '<script>alert("'.$_SESSION['config_creada'].'"); </script>';
  unset($_SESSION['config_creada']);
}
if (isset($_SESSION['config_guardada'])) {
  echo '<script>alert("'.$_SESSION['config_guardada'].'"); </script>';
  unset($_SESSION['config_guardada']);
}
include 'valores/conexion.php';
include 'crud/select_header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo Administrador - Pizzería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #006391;">
  <a class="navbar-brand" href="#" style="color: #ffffff;">Pizzería</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="altamodulo.php" style="color: #ffffff;">Alta Administradores</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="crearmenu.php" style="color: #ffffff;">Crear Nueva Categoría y Productos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" style="color: #ffffff;">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="headermodulo.php" style="color: #ffffff;">Header</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="footermodulo.php" style="color: #ffffff;">Footer</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" style="color: #ffffff;">Contenido</a>
      </li>
    </ul>
  </div>
  <ul class="navbar-nav ms-auto">
    <li class="nav-item">
      <a class="nav-link" href="logout.php" style="color: #ffffff;">
        <i class="fas fa-user"></i> Cerrar sesión
      </a>
    </li>
  </ul>
</nav>

<div class="container mt-4">
    <h2>Módulo Administrador</h2>
    
    <!-- Formulario para gestionar el Header -->
    <div id="configHeader" class="mt-5">
        <h3>Configuración del Header</h3>
        <?php

if (empty($configuracion_header)) {
    // Mostrar formulario para crear la configuración
    ?>
    <form action="crud/crear_configuracion.php" method="POST" enctype="multipart/form-data"> 
        <!-- Identificador de la categoría para el Header -->
        <input type="hidden" name="categoria_padre_id" value="575d7bdb-76d7-11ef-b08e-4cd7178be01c">
        <input type="hidden" name="nombre_categoria_padre_id" value="header">

        <div class="mb-3">
            <label for="colorFondo" class="form-label">Color de Fondo</label>
            <input type="color" class="form-control form-control-sm" id="colorFondo" name="color_fondo" style="height: 30px; width: 50px;">
        </div>
        <div class="mb-3">
            <label for="colorTextoNombrePestana" class="form-label">Color del Texto de las Pestañas</label>
            <input type="color" class="form-control form-control-sm" id="colorTextoNombrePestana" name="color_texto_nombre_pestana" style="height: 30px; width: 50px;">
        </div>
        <div class="mb-3">
            <label for="colorFondoNombrePestana" class="form-label">Color del fondo de las pestañas</label>
            <input type="color" class="form-control form-control-sm" id="colorFondoNombrePestana" name="color_fondo_nombre_pestana" style="height: 30px; width: 50px;">
        </div>
        <div class="mb-3">
            <label for="imagen1" class="form-label">Imagen header</label>
            <input type="file" class="form-control" id="imagen1" name="imagen_1" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Configuración del Header</button>
    </form>
    <?php
} else {
    // Mostrar formulario prellenado con los datos existentes
    $headerData = $configuracion_header[0]; // Suponiendo que solo hay un registro
    ?>
    <form action="crud/guardar_configuracion.php" method="POST" enctype="multipart/form-data"> 
        <!-- Identificador de la categoría para el Header -->
        <input type="hidden" name="categoria_padre_id" value="<?php echo htmlspecialchars($headerData['CG_CCP_CategoriaPadreId']); ?>">
        <input type="hidden" name="nombre_categoria_padre_id" value="header">

        <div class="mb-3">
            <label for="colorFondo" class="form-label">Color de Fondo</label>
            <input type="color" class="form-control form-control-sm" id="colorFondo" name="color_fondo" value="<?php echo htmlspecialchars($headerData['CG_ColorFondo']); ?>" style="height: 30px; width: 50px;">
        </div>
        <div class="mb-3">
            <label for="colorTextoNombrePestana" class="form-label">Color del Texto de las Pestañas</label>
            <input type="color" class="form-control form-control-sm" id="colorTextoNombrePestana" name="color_texto_nombre_pestana" value="<?php echo htmlspecialchars($headerData['CG_ColorTextoNombrePestaña']); ?>" style="height: 30px; width: 50px;">
        </div>
        <div class="mb-3">
            <label for="colorFondoNombrePestana" class="form-label">Color del fondo de las pestañas</label>
            <input type="color" class="form-control form-control-sm" id="colorFondoNombrePestana" name="color_fondo_nombre_pestana" value="<?php echo htmlspecialchars($headerData['CG_ColorFondoNombrePestaña']); ?>" style="height: 30px; width: 50px;">
        </div>
        <div class="mb-3">
            <label for="imagen1" class="form-label">Imagen header</label>
            <input type="file" class="form-control" id="imagen1" name="imagen_1" accept="image/*">
            <small>Imagen actual: <img src="<?php echo htmlspecialchars($headerData['CG_Imagen1']); ?>" width="50" height="50"></small>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Configuración del Header</button>
    </form>
    <?php
}
?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
