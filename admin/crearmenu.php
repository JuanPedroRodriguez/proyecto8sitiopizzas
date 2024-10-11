<?php
session_start(); // Iniciar la sesión

// Verificar si la sesión 'administrador' no está configurada
if (!isset($_SESSION['administrador'])) {
    // Redirigir a myadmin.php
    header("Location: myadmin.php");
    exit(); // Asegúrate de usar exit después de header
}
if (isset($_SESSION['altacat'])) {
  echo '<script>alert("'.$_SESSION['altacat'].'"); </script>';
  unset($_SESSION['altacat']);
}
if (isset($_SESSION['modificacioncat'])) {
  echo '<script>alert("'.$_SESSION['modificacioncat'].'"); </script>';
  unset($_SESSION['modificacioncat']);
}
if (isset($_SESSION['eliminarcat'])) {
  echo '<script>alert("'.$_SESSION['eliminarcat'].'"); </script>';
  unset($_SESSION['eliminarcat']);
}
if (isset($_SESSION['crearprod'])) {
    echo '<script>alert("'.$_SESSION['crearprod'].'"); </script>';
    unset($_SESSION['crearprod']);
  }
  if (isset($_SESSION['modificarprod'])) {
    echo '<script>alert("'.$_SESSION['modificarprod'].'"); </script>';
    unset($_SESSION['modificarprod']);
  }
  if (isset($_SESSION['eliminarprod'])) {
    echo '<script>alert("'.$_SESSION['eliminarprod'].'"); </script>';
    unset($_SESSION['eliminarprod']);
  }
include 'valores/conexion.php';
include 'crud/leercategorias.php';
include 'crud/leerproductos.php'; 

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
        <form action="crud/crear_categoria.php" method="POST">
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
    </div> <br>
        <!-- HTML para mostrar las categorías -->
    <div id="lista_categorias" class="mt-5">
        <h3>Lista de Categorías</h3>
        <?php if (!empty($categorias)): ?>
            <ul>
                <?php foreach ($categorias as $categoria): 
                    $categoriaId = $categoria['MC_CategoriaId'];
                    ?>
                    
                        <strong>Nombre:</strong> <?php echo htmlspecialchars($categoria['MC_NombreCategoria']); ?><br>
                        <strong>Descripción:</strong> <?php echo htmlspecialchars($categoria['MC_DescripcionCategoria']); ?><br>
                        <strong>Creado por:</strong> <?php echo htmlspecialchars($categoria['MC_AL_CreadoPor']); ?><br>
                        <strong>Modificado por:</strong> <?php echo htmlspecialchars($categoria['MC_AL_ModificadoPor']); ?><br>
                        <strong>Fecha de creación:</strong> <?php echo htmlspecialchars($categoria['MC_FechaCreacion']); ?> <br>
                        <strong>Ultima Modificación:</strong> <?php echo htmlspecialchars($categoria['MC_FechaModificacion']); ?><br>
                        <!-- Botón para abrir el modal -->
                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalModificarCategoria_<?php echo $categoria['MC_CategoriaId']; ?>">
                            Modificar
                        </button> &nbsp;
                        <!-- Botón para abrir el modal de eliminación -->
                        <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#modalEliminarCategoria_<?php echo $categoria['MC_CategoriaId']; ?>">
                            Eliminar
                        </button> <br><br>
                        <div class="accordion" id="accordionCategorias">
                            
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?php echo $categoria['MC_CategoriaId']; ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $categoria['MC_CategoriaId']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $categoria['MC_CategoriaId']; ?>">
                                            ver productos de <?php echo htmlspecialchars($categoria['MC_NombreCategoria']); ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?php echo $categoria['MC_CategoriaId']; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $categoria['MC_CategoriaId']; ?>" data-bs-parent="#accordionCategorias">
                                        <div class="accordion-body">
                                            <!-- Botón para agregar un producto (abre modal) -->
                                            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#agregarProductoModal" data-categoria-id="<?php echo $categoria['MC_CategoriaId']; ?>">
                                                Agregar Producto
                                            </button>

                                            <!-- Tabla de productos -->
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Descripción</th>
                                                        <th>Precio</th>
                                                        <th>Imagen</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    // Intentar obtener los productos de la categoría actual
                                                    try {
                                                        $productos = obtenerProductosPorCategoria($categoriaId);
                                                        
                                                        if (!empty($productos)) :
                                                            foreach ($productos as $producto) :
                                                ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($producto['MP_NombreProducto']); ?></td>
                                                                <td><?php echo htmlspecialchars($producto['MP_DescripcionProducto']); ?></td>
                                                                <td>$<?php echo number_format($producto['MP_PrecioProducto'], 2); ?></td>
                                                                <td>
                                                                    <img src="<?php echo htmlspecialchars($producto['MP_ImagenProducto']); ?>" alt="Imagen del producto" width="50" height="50">
                                                                </td>
                                                                <td>
                                                                    <!-- Botones de acción -->
                                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalmodificarproducto_<?php echo $producto['MP_ProductoId']; ?>">
                                                                        Modificar
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarproducto_<?php echo $producto['MP_ProductoId']; ?> ">
                                                                        Eliminar
                                                                    </button>
                                                                    
                       
                                                                </td>
                                                            </tr>

                                                            
                                                <?php
                                                        endforeach;
                                                    else :
                                                ?>
                                                        <tr>
                                                            <td colspan="5">No hay productos para esta categoría.</td>
                                                        </tr>
                                                <?php
                                                    endif;
                                                } catch (Exception $e) {
                                                    echo "<tr><td colspan='5'>Error al cargar los productos: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            
                        </div>

                        <?php include '../assets/modalmodificar.php'; 
                              include '../assets/modaleliminar.php'; 
                              include '../assets/modaleliminarproducto.php';
                              include '../assets/modalagregarproducto.php';
                              include '../assets/modalmodificarproducto.php'; 
                        ?>
                        <hr>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No se encontraron categorías.</p>
        <?php endif; ?>
    </div>

   
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
