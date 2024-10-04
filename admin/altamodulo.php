<?php
session_start(); // Iniciar la sesión

// Verificar si la sesión 'administrador' no está configurada
if (!isset($_SESSION['administrador'])) {
    // Redirigir a myadmin.php
    header("Location: myadmin.php");
    exit(); // Asegúrate de usar exit después de header
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo Administrador - Pizzería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
          <a class="nav-link" href="crearmenu.php" style="color: #ffffff;">Crear Nueva Categoría y Productos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" style="color: #ffffff;">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" style="color: #ffffff;">header</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" style="color: #ffffff;">footer</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" style="color: #ffffff;">contenido</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-4">
    <h2>Módulo Administrador</h2>
    
    <!-- Sección de gestionar usuarios administradores -->
    <div id="usuarios_admin" class="mt-5">
        <form action="registro.php" method="POST">
            <div class="mb-3">
                <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>

    </div>

   
</div>
<?php 
// Verificar si la sesión 'alta' existe
if (isset($_SESSION['alta']) && !empty($_SESSION['alta'])) {
    // Obtener el valor de la sesión 'alta'
    $alta = $_SESSION['alta'];

    // Mostrar un alert con el contenido de la sesión
    echo "<script>alert('Mensaje: " . addslashes($alta) . "');</script>";

    // Destruir solo la sesión 'alta'
    unset($_SESSION['alta']); // Elimina solo la variable de sesión 'alta'
}
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
