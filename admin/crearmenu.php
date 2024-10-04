<?php
session_start(); // Iniciar la sesión

// Verificar si la sesión 'administrador' no está configurada
if (!isset($_SESSION['administrador'])) {
    // Redirigir a myadmin.php
    header("Location: myadmin.php");
    exit(); // Asegúrate de usar exit después de header
}

include 'valores/conexion.php';

try {
    $sql = "SELECT CCP_CategoriaPadreId FROM configcategoriapadre where CCP_NombreCategoriaPadre = 'menu' ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $resultado  = $stmt->fetch(PDO::FETCH_OBJ);
    $categoria_padre = $resultado->CCP_CategoriaPadreId;
  //var_dump($resultado);
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
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
        <a class="nav-link" href="altamodulo.php" style="color: #ffffff;">Alta Administradores</a>
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

    <!-- Sección para crear nuevas categorías -->
    <div id="nueva_categoria" class="mt-5">
        <h3>Crear Nueva Categoría</h3>
        <form action="crear_categoria.php" method="POST">
            <div class="mb-3">
                <label for="nombre_categoria" class="form-label">Nombre de la Categoría</label>
                <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" required>
            </div>
            <div class="mb-3">
                <label for="descripcion_categoria" class="form-label">Descripción de la Categoría</label>
                <textarea class="form-control" id="descripcion_categoria" name="descripcion_categoria" required></textarea>
            </div>
            <div class="mb-3">
                <input type="hidden" class="form-control" id="categoria_padre" name="categoria_padre" value="<?php echo $categoria_padre; ?>" readonly required>
            </div>
            <button type="submit" class="btn btn-success">Crear Categoría</button>
        </form>
    </div>

   
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
