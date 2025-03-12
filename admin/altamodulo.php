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
    <link rel="icon" type="image/x-icon" href="../assets/imagenes/adminlogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #006391;">
  <div class="container-fluid">
    <!-- Logo de la pizzería -->
    <a class="navbar-brand" href="adminmodulo.php" style="color: #ffffff;">Pizzería</a>
    
    <!-- Botón "hamburguesa" -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
  
    <h2>Dar de alta un usuario nuevo <i class="bi bi-person-circle"></i></h2>
      
    <!-- Sección de gestionar usuarios administradores -->
    <div id="usuarios_admin" class="mt-5 col-12">
        <form action="crud/registro.php" method="POST">
            <div class="mb-3 col-4">
                <label for="nombre_usuario" class="form-label"><span class="badge text-bg-secondary">Nombre de Usuario</span></label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
            </div>
            <div class="mb-3 col-4">
                <label for="nombre_usuario" class="form-label"><span class="badge text-bg-secondary">Nombre</span></label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3 col-4">
                <label for="nombre_usuario" class="form-label"><span class="badge text-bg-secondary">Primer Apellido</span></label>
                <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" required>
            </div>
            <div class="mb-3 col-4">
                <label for="nombre_usuario" class="form-label"><span class="badge text-bg-secondary">Segundo Apellido</span></label>
                <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" required>
            </div>
            <div class="mb-3 col-4">
                <label for="email" class="form-label"><span class="badge text-bg-secondary">Email</span></label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3 col-4">
                <label for="password" class="form-label"><span class="badge text-bg-secondary">Contraseña</span></label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>

    </div>
  
</div><br>
<div class="container mt-4">
    <h2>Usuarios Administradores</h2>

    <?php if (!empty($usuarios)): ?>
      <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre de Usuario</th>
                    <th>Nombre</th>
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
                    <td><?php echo htmlspecialchars($usuario['AL_Nombre']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['AL_PrimerApellido']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['AL_SegundoApellido']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['AL_Correo']); ?></td>
                    <td>
                      <div class="d-flex flex-wrap gap-1">
                        <?php //si en la tabla aparece el registro del usuario admin pero el login es con otro usuario se bloquean los botones
                        if ($usuario['AL_SocioId'] === '162e9f43-81db-11ef-b45d-4cd7178be01c' && $_SESSION['administradorId'] !== '162e9f43-81db-11ef-b45d-4cd7178be01c') { 
                        ?>
                            <!-- Botón para abrir el modal de modificación (deshabilitado) -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalModificarUsuario_<?php echo $usuario['AL_SocioId']; ?>" disabled>
                                Modificar
                            </button> 
                            <!-- Botón para eliminar (deshabilitado) -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarUsuario_<?php echo $usuario['AL_SocioId']; ?>" disabled>
                                Eliminar
                            </button>
                        <?php //si en la tabla aparece el registro del usuario admin y el login es con usuario administrador se habilitan los botones
                        } elseif ($usuario['AL_SocioId'] === '162e9f43-81db-11ef-b45d-4cd7178be01c' && $_SESSION['administradorId'] === '162e9f43-81db-11ef-b45d-4cd7178be01c') { 
                        ?>
                            <!-- Botón para abrir el modal de modificación -->
                            <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalModificarUsuario_<?php echo $usuario['AL_SocioId']; ?>">
                                Modificar
                            </button> 
                            <!-- Botón para eliminar -->
                            <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#modalEliminarUsuario_<?php echo $usuario['AL_SocioId']; ?>">
                                Eliminar
                            </button>
                        <?php 
                          }else{ 
                        ?>
                            <!-- Botón para abrir el modal de modificación -->
                            <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalModificarUsuario_<?php echo $usuario['AL_SocioId']; ?>">
                                    Modificar
                            </button> 
                            <!-- Botón para eliminar -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarUsuario_<?php echo $usuario['AL_SocioId']; ?>">
                                Eliminar
                            </button>
                        <?php 
                        } 
                        ?>
                      </div>
                    </td>
                  </tr>
                  
                  <!-- Incluir el modal para modificar usuario -->
                  <?php include '../assets/modalmodificarusuario.php'; 
                        include '../assets/modaleliminarusuario.php';
                  ?>
                <?php endforeach; ?>
            </tbody>
        </table>
      </div>  
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
