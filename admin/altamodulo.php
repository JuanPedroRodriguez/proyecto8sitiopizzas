<?php
session_start(); // Iniciar la sesión

// Verificar si la sesión 'administrador' no está configurada
if (!isset($_SESSION['administrador'])) {
    // Redirigir a myadmin.php
    header("Location: myadmin.php");
    exit();
}
//var_dump($_SESSION['administrador']);
// Verificar si la sesión 'alta' existe
if (isset($_SESSION['alta']) && !empty($_SESSION['alta'])) {
  // Obtener el valor de la sesión 'alta'
  $alta = $_SESSION['alta'];

  // Mostrar un alert con el contenido de la sesión
  echo "<script>alert('Mensaje: " . addslashes($alta) . "');</script>";

  // Destruir solo la sesión 'alta'
  unset($_SESSION['alta']); // Elimina solo la variable de sesión 'alta'
}
if (isset($_SESSION['modificacionuser'])) {
  echo '<script>alert("'.$_SESSION['modificacionuser'].'"); </script>';
  unset($_SESSION['modificacionuser']);
}
if (isset($_SESSION['eliminacionuser'])) {
  echo '<script>alert("'.$_SESSION['eliminacionuser'].'"); </script>';
  unset($_SESSION['eliminacionuser']);
}
include 'valores/conexion.php';
include 'crud/select_usuarios.php';
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
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <!-- Ícono de usuario blanco con Font Awesome y enlace de logout -->
            <a class="nav-link" href="logout.php" style="color: #ffffff;">
                <i class="fas fa-user"></i> Cerrar sesión
            </a>
        </li>
    </ul>
</nav>

<div class="container mt-4">
    <h2>Módulo Administrador</h2>
    
    <!-- Sección de gestionar usuarios administradores -->
    <div id="usuarios_admin" class="mt-5">
        <form action="crud/registro.php" method="POST">
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

   
</div><br>
<div class="container mt-4">
    <h2>Usuarios Administradores</h2>

    <?php if (!empty($usuarios)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre de Usuario</th>
                    <th>Primer Apellido</th>
                    <th>Segundo Apellido</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($usuario['AL_NombreDeUsuario']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['AL_PrimerApellido']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['AL_SegundoApellido']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['AL_Correo']); ?></td>
                    <td>
                    <?php 
                      if ($usuario['AL_SocioId'] === '162e9f43-81db-11ef-b45d-4cd7178be01c' && $_SESSION['administradorId'] !== '162e9f43-81db-11ef-b45d-4cd7178be01c') { 
                      ?>
                          <!-- Botón para abrir el modal de modificación (deshabilitado) -->
                          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalModificarUsuario_<?php echo $usuario['AL_SocioId']; ?>" disabled>
                              Modificar
                          </button> 
                          <!-- Botón para eliminar (deshabilitado) -->
                          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarUsuario_<?php echo $usuario['AL_SocioId']; ?>" disabled>
                              Eliminar Usuario
                          </button>
                      <?php 
                      } elseif ($usuario['AL_SocioId'] === '162e9f43-81db-11ef-b45d-4cd7178be01c' && $_SESSION['administradorId'] === '162e9f43-81db-11ef-b45d-4cd7178be01c') { 
                      ?>
                          <!-- Botón para abrir el modal de modificación -->
                          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalModificarUsuario_<?php echo $usuario['AL_SocioId']; ?>">
                              Modificar
                          </button> 
                          <!-- Botón para eliminar -->
                          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarUsuario_<?php echo $usuario['AL_SocioId']; ?>">
                              Eliminar Usuario
                          </button>
                      <?php 
                        }else{ 
                      ?>
                          <!-- Botón para abrir el modal de modificación -->
                          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalModificarUsuario_<?php echo $usuario['AL_SocioId']; ?>">
                                  Modificar
                          </button> 
                          <!-- Botón para eliminar -->
                          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarUsuario_<?php echo $usuario['AL_SocioId']; ?>">
                              Eliminar Usuario
                          </button>
                      <?php 
                      } 
                      ?>
                    </td>
                  </tr>
                  
                  <!-- Incluir el modal para modificar usuario -->
                  <?php include '../assets/modalmodificarusuario.php'; 
                        include '../assets/modaleliminarusuario.php';
                  ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    <?php else: ?>
        <p>No hay usuarios administradores registrados.</p>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
