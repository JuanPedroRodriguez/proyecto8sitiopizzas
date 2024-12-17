<?php
session_start(); // Iniciar la sesión

// Verificar si la sesión 'administrador' no está configurada
if (!isset($_SESSION['administrador'])) {
    // Redirigir a myadmin.php
    header("Location: myadmin.php");
    exit(); // Asegúrate de usar exit después de header
}
include 'valores/conexion.php';
include 'crud/leercategorias.php';
include 'crud/leerproductos.php'; 
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
  <center><h2>Módulo Administrador <i class="bi bi-person-fill-gear"></i></h2></center><br>
  
  <center><h3>¿Cuál sección deseas editar?</h3></center><br>

  <div class="justify-content-center align-items-center col-12">
    <div class="d-flex flex-column flex-sm-row text-center justify-content flex-wrap gap-3">
      <!-- Botón Alta Administradores -->
      <div class="col-12 col-sm-2 col-md-3">
        <a href="altamodulo.php" class="btn btn-primary w-100">
          Administradores <i class="bi bi-person"></i>
        </a>
      </div>
      <!-- Botón Crear Nueva Categoría y Productos -->
      <div class="col-12 col-sm-1 col-md-2">
        <a href="crearmenu.php" class="btn btn-success w-100">
          Menú <i class="bi bi-card-list"></i>
        </a>
      </div>
      
      <!-- Botón Inicio -->
       <!--
      <div class="col-12 col-sm-1 col-md-2">
        <a href="#" class="btn btn-info w-100">
          Inicio <i class="bi bi-house"></i>
        </a>
      </div>
      -->
      <!-- Botón Header -->
      <div class="col-12 col-sm-1 col-md-2">
        <a href="headermodulo.php" class="btn btn-warning w-100">
          Header <i class="bi bi-gear"></i>
        </a>
      </div>
      <!-- Botón Footer -->
      <div class="col-12 col-sm-1 col-md-2">
        <a href="footermodulo.php" class="btn btn-danger w-100">
          Footer <i class="bi bi-gear"></i>
        </a>
      </div>
      <!-- Botón Contenido -->
      <div class="col-12 col-sm-1 col-md-2">
        <a href="#" class="btn btn-dark w-100">
          Contenido <i class="bi bi-card-heading"></i>
        </a>
      </div>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
