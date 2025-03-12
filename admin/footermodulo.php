<?php
session_start(); // Iniciar la sesión

// Verificar si la sesión 'administrador' no está configurada
if (!isset($_SESSION['administrador'])) {
    // Redirigir a myadmin.php
    header("Location: myadmin.php");
    exit(); // Asegúrate de usar exit después de header
}
if (isset($_SESSION['config_creada_footer'])) {
  echo '<script>alert("'.$_SESSION['config_creada_footer'].'"); </script>';
  unset($_SESSION['config_creada_footer']);
}
if (isset($_SESSION['config_actualizada_footer'])) {
  echo '<script>alert("'.$_SESSION['config_actualizada_footer'].'"); </script>';
  unset($_SESSION['config_actualizada_footer']);
}
include 'valores/conexion.php';
include 'crud/select_footer.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo Administrador - Pizzería</title>
    <link rel="icon" type="image/x-icon" href="../assets/imagenes/adminlogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #006391;">

  <div class="container-fluid">
    <a class="navbar-brand" href="adminmodulo.php" style="color: #ffffff;">Pizzería</a>
    <!-- Botón "hamburguesa" -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" >
      <span class="navbar-toggler-icon" style="filter: invert(100%);"></span>
    </button>
    <!--evitamos que el icono de hamburguesa se vaya hasta el final-->
    <ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <a class="nav-link" href="#" style="color: #ffffff;">
        </a>
      </li>
    </ul>
    <!-- Elementos del menú -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="altamodulo.php" style="color: #ffffff;">Administradores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="crearmenu.php" style="color: #ffffff;">Menú</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="adminmodulo.php" style="color: #ffffff;">Inicio</a>
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
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="logout.php" style="color: #ffffff;">
            <i class="fas fa-user"></i> Cerrar sesión
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <center><h2>Módulo Administrador <i class="bi bi-person-fill-gear"></i></h2>
          <div class="col-12 col-sm-1 col-md-2">
            <a href="adminmodulo.php" class="btn btn-primary w-100">
              Inicio <i class="bi bi-house"></i>
            </a>
          </div>
    </center><br><br>
    
    <!-- Formulario para gestionar el Header -->
    <div id="configHeader" class="mt-5">
        <h3>Configuración del Footer</h3>
        <h4>(Pie de pagina)</h4>
        <?php

if (empty($configuracion_footer)) {
    // Mostrar formulario para crear la configuración
    ?>
    <form action="crud/crear_configuracion_footer.php" method="POST" enctype="multipart/form-data"> 
        <div class="mb-3">
            <label for="colorFondo" class="form-label">Color de Fondo</label>
            <input type="color" class="form-control form-control-sm" id="colorFondo" name="color_fondo" style="height: 30px; width: 50px;">
        </div>
        <div class="mb-3">
            <label for="colorTextoNombrePestana" class="form-label">Color del Texto de los links</label>
            <input type="color" class="form-control form-control-sm" id="colorTextoNombrePestana" name="color_texto_nombre_pestana" style="height: 30px; width: 50px;">
        </div>
        <div class="mb-3">
            <label for="colorTextoNombrePestana" class="form-label">Link para Didi</label>
            <input type="text" class="form-control form-control-sm" id="didi" name="didi" style="height: 30px; width: 350px;">
        </div>
        <div class="mb-3">
            <label for="colorTextoNombrePestana" class="form-label">Link para Rappi</label>
            <input type="text" class="form-control form-control-sm" id="rappi" name="rappi" style="height: 30px; width: 350px;">
        </div>
        <div class="mb-3">
            <label for="colorTextoNombrePestana" class="form-label">Link para UberEats</label>
            <input type="text" class="form-control form-control-sm" id="ubereats" name="ubereats" style="height: 30px; width: 350px;">
        </div>
        <div class="mb-3">
            <label for="colorTextoNombrePestana" class="form-label">Leyenda derechos reservados</label>
            <textarea type="text" class="form-control form-control-sm" id="derechos" name="derechos" style="height: 150px; width: 350px;"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar Configuración del Footer</button>
    </form>
    <?php
} else {
     //Mostrar formulario prellenado con los datos existentes
    $footerData = $configuracion_footer[0]; // Suponiendo que solo hay un registro*/
    ?>
    <form action="crud/guardar_configuracion_footer.php" method="POST" enctype="multipart/form-data"> 
    <div class="mb-3">
            <label for="colorFondo" class="form-label">Color de Fondo</label>
            <input type="color" class="form-control form-control-sm" id="colorFondo" name="color_fondo" style="height: 30px; width: 50px;" value="<?php echo htmlspecialchars($footerData['CG_ColorFondoFooter']); ?>">
        </div>
        <div class="mb-3">
            <label for="colorTextoNombrePestana" class="form-label">Color del Texto de los links</label>
            <input type="color" class="form-control form-control-sm" id="colorTextoNombrePestana" name="color_texto_nombre_pestana" style="height: 30px; width: 50px;" value="<?php echo htmlspecialchars($footerData['CG_ColorTextoNombrePestañaFooter']); ?>">
        </div>
        <div class="mb-3">
            <label for="colorTextoNombrePestana" class="form-label">Link para Didi</label>
            <input type="text" class="form-control form-control-sm" id="didi" name="didi" style="height: 30px; width: 350px;" value="<?php echo htmlspecialchars($footerData['CG_LinkDidi']); ?>">
        </div>
        <div class="mb-3">
            <label for="colorTextoNombrePestana" class="form-label">Link para Rappi</label>
            <input type="text" class="form-control form-control-sm" id="rappi" name="rappi" style="height: 30px; width: 350px;" value="<?php echo htmlspecialchars($footerData['CG_LinkRappi']); ?>">
        </div>
        <div class="mb-3">
            <label for="colorTextoNombrePestana" class="form-label">Link para UberEats</label>
            <input type="text" class="form-control form-control-sm" id="ubereats" name="ubereats" style="height: 30px; width: 350px;" value="<?php echo htmlspecialchars($footerData['CG_LinkUbereats']); ?>">
        </div>
        <div class="mb-3">
            <label for="colorTextoNombrePestana" class="form-label">Leyenda derechos reservados</label>
            <textarea type="text" class="form-control form-control-sm" id="derechos" name="derechos" style="height: 150px; width: 350px;"><?php echo htmlspecialchars($footerData['CG_DerechosReservados']); ?></textarea>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
