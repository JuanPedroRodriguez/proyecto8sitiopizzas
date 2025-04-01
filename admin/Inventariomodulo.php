<?php
session_start(); // Iniciar la sesión

// Verificar si la sesión 'administrador' no está configurada
if (!isset($_SESSION['administrador'])) {
    // Redirigir a myadmin.php
    header("Location: myadmin.php");
    exit(); // Asegúrate de usar exit después de header
}
if (isset($_SESSION['altain'])) {
  echo '<script>alert("'.$_SESSION['altain'].'"); </script>';
  unset($_SESSION['altain']);
}
if (isset($_SESSION['modificarinsumo'])) {
  echo '<script>alert("'.$_SESSION['modificarinsumo'].'"); </script>';
  unset($_SESSION['modificarinsumo']);
}
if (isset($_SESSION['eliminarinsumo'])) {
  echo '<script>alert("'.$_SESSION['eliminarinsumo'].'"); </script>';
  unset($_SESSION['eliminarinsumo']);
}

include 'valores/conexion.php';
include 'crud/leerinsumos.php'; 

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
          <div class="col-12 col-sm-6 col-md-4">
            <a href="adminmodulo.php" class="btn btn-primary w-100">
              Inicio <i class="bi bi-house"></i>
            </a>
          </div>
    </center><br><br>
    <h2>Gestion de Inventario <i class="bi bi-clipboard-data"></i><!--<img src="../assets/imagenes/pizza.png" alt="" class="img-fluid" style="width: 1.5rem; height: 1.5rem;">--></h2>
        
    <!-- Sección para crear nuevas categorías -->
    <div id="nueva_categoria" class="mt-5">
        <h3>
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAgregarInsumo" aria-expanded="false" aria-controls="collapseAgregarInsumo" id="btnAgregarInsumo">
                Agregar Nuevo Insumo <i id="iconoAgregarInsumo" class="bi bi-plus-circle"></i>
            </button>
        </h3>
        <div class="collapse col-12 col-sm-12 col-lg-6" id="collapseAgregarInsumo">
            <div class="card card-body">
                <form action="crud/crear_insumo.php" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="pagina" value="<?php echo isset($_GET['pagina']) ? $_GET['pagina'] :''; ?>">
                  <input type="hidden" name="referencia" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
                    <div class="mb-3">
                        <label for="nombre_insumo" class="form-label"><span class="badge bg-secondary">Nombre del Insumo:</span></label>
                        <input type="text" class="form-control" id="nombre_insumo" name="nombre_insumo" required>
                    </div>
                    <div class="mb-2">
                        <label for="piezas"><span class="badge bg-secondary">Numero de Piezas:</span></label>
                        <input type="text" id="piezas" name="piezas" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="gramos"><span class="badge bg-secondary">Gramos:</span></label>
                        <input type="text" id="gramos" name="gramos" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="kilogramos"><span class="badge bg-secondary">Kilogramos:</span></label>
                        <input type="text" id="kilogramos" name="kilogramos" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="litros"><span class="badge bg-secondary">Litros:</span></label>
                        <input type="text" id="litros" name="litros" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="mililitros"><span class="badge bg-secondary">MiliLitros:</span></label>
                        <input type="text" id="mililitros" name="mililitros" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="porcion"><span class="badge bg-secondary">Numero de Porciones:</span></label>
                        <input type="text" id="porcion" name="porcion" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="otro"><span class="badge bg-secondary">Otro tipo de medida:</span></label>
                        <input type="text" id="otro" name="otro" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="imagen_insumo" class="form-label"><span class="badge bg-secondary">Imagen del Insumo</span></label>
                        <input type="file" class="form-control" id="imagen_insumo" name="imagen_insumo" accept="image/*">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success">Agregar Insumo</button>
                </form>
            </div>
        </div>
    </div>
        <br>

        <!-- HTML para mostrar las categorías -->
        <div id="lista_insumos" class="mt-5">
          <h3><span class="badge text-bg-secondary">Lista de Insumos</span></h3>
          
          <?php if (!empty($insumos)): ?>
              <table class="table table-striped table-bordered">
                  <thead>
                      <!-- Versión de Escritorio -->
                      <tr class="table-primary d-none d-lg-table-row">
                          <th>Nombre del Insumo</th>
                          <th>Numero de Piezas</th>
                          <th>Gramos</th>
                          <th>Kilogramos</th>
                          <th>MiliLitros</th>
                          <th>Litros</th>
                          <th>Numero de Porciones</th>
                          <th>Otra Medida</th>
                          <th>Imagen</th>
                          <th>Acciones</th>
                      </tr>
                  </thead>
                  <?php 
                  // Detectar si es móvil
                  $isMobile = preg_match('/(Android|iPhone|iPad|Mobile)/i', $_SERVER['HTTP_USER_AGENT']);
                  //var_dump($_SERVER['HTTP_USER_AGENT']); exit;
                  // Número de registros por página
                  $registros_por_pagina = 10;

                  // Página actual (obtener desde GET, valor por defecto = 1)
                  $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

                  // Calcular el índice inicial
                  $indice_inicio = ($pagina_actual - 1) * $registros_por_pagina;

                  // Obtener el número total de registros
                  $total_registros = count($insumos);

                  // Calcular el número total de páginas
                  $total_paginas = ceil($total_registros / $registros_por_pagina);

                  
                  if ($isMobile) {
                    // Mostrar todos los registros en móvil
                    $insumos_pagina = $insumos;
                  } else {
                      // Obtener los registros para la página actual
                      $insumos_pagina = array_slice($insumos, $indice_inicio, $registros_por_pagina);
                  }
                  ?>
                  <tbody>
                      <?php foreach ($insumos_pagina as $insumo): 
                          $insumoid = $insumo['In_InsumoId'];
                      ?>
                      <!-- Versión de Escritorio -->
                      <tr class="d-none d-lg-table-row">
                          <td><span class="badge bg-secondary"><?php echo htmlspecialchars($insumo['In_NombreInsumo']); ?></span></td>
                          <td>
                              <span class="<?php echo ($insumo['In_NumeroPiezas'] != '') 
                                  ? ($insumo['In_NumeroPiezas'] != 0 ? 'badge bg-success' : 'badge bg-danger') 
                                  : ''; ?>">
                                  <?php echo htmlspecialchars($insumo['In_NumeroPiezas']); ?>
                              </span>
                          </td>
                          <td>
                              <span class="<?php echo ($insumo['In_PesoGramos'] != '') 
                                  ? ($insumo['In_PesoGramos'] != 0 ? 'badge bg-success' : 'badge bg-danger') 
                                  : ''; ?>">
                                  <?php echo htmlspecialchars($insumo['In_PesoGramos']); ?>
                              </span>
                          </td>
                          <td>
                              <span class="<?php echo ($insumo['In_PesoKilos'] != '') 
                                  ? ($insumo['In_PesoKilos'] != 0 ? 'badge bg-success' : 'badge bg-danger') 
                                  : ''; ?>">
                                  <?php echo htmlspecialchars($insumo['In_PesoKilos']); ?>
                              </span>
                          </td>
                          <td>
                              <span class="<?php echo ($insumo['In_Mililitros'] != '') 
                                  ? ($insumo['In_Mililitros'] != 0 ? 'badge bg-success' : 'badge bg-danger') 
                                  : ''; ?>">
                                  <?php echo htmlspecialchars($insumo['In_Mililitros']); ?>
                              </span>
                          </td>
                          <td>
                              <span class="<?php echo ($insumo['In_Litros'] != '') 
                                  ? ($insumo['In_Litros'] != 0 ? 'badge bg-success' : 'badge bg-danger') 
                                  : ''; ?>">
                                  <?php echo htmlspecialchars($insumo['In_Litros']); ?>
                              </span>
                          </td>
                          <td>
                              <span class="<?php echo ($insumo['In_Porcion'] != '') 
                                  ? ($insumo['In_Porcion'] != 0 ? 'badge bg-success' : 'badge bg-danger') 
                                  : ''; ?>">
                                  <?php echo htmlspecialchars($insumo['In_Porcion']); ?>
                              </span>
                          </td>
                          <td>
                              <span class="<?php echo ($insumo['In_Otro'] != '') 
                                  ? ($insumo['In_Otro'] != 0 ? 'badge bg-success' : 'badge bg-danger') 
                                  : ''; ?>">
                                  <?php echo htmlspecialchars($insumo['In_Otro']); ?>
                              </span>
                          </td>

                          <td style="font-size: 10px;">
                              <img src="<?php echo htmlspecialchars($insumo['In_ImagenInsumo']); ?>"  width="50" height="50" alt="<?php echo !empty($insumo['In_ImagenInsumo']) ? 'Imagen del producto' : 'Sin imagen asignada'; ?>">
                          </td>
                          <td>
                              <!-- Botón para abrir el modal -->
                              <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalmodificarinsumo_<?php echo $insumo['In_InsumoId']; ?>">
                                  Modificar
                              </button> 
                              <!-- Botón para abrir el modal de eliminación -->
                              <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#modalEliminarInsumo_<?php echo $insumo['In_InsumoId']; ?>">
                                  Eliminar
                              </button>
                          </td>
                      </tr>

                      <!-- Versión Vertical para Móviles -->
                      <tr class="d-lg-none">
                          <td colspan="2"><strong>Nombre del Insumo:</strong> 
                            <span class="badge bg-secondary">
                              <?php echo htmlspecialchars($insumo['In_NombreInsumo']); ?>
                            </span>
                          </td>
                      </tr>
                      <tr class="d-lg-none">
                          <td colspan="2"><strong>Numero de Piezas:</strong> 
                            <span class="<?php echo ($insumo['In_NumeroPiezas'] != '') 
                                    ? ($insumo['In_NumeroPiezas'] != 0 ? 'badge bg-success' : 'badge bg-danger') 
                                    : ''; ?>">
                              <?php echo htmlspecialchars($insumo['In_NumeroPiezas']); ?>
                        
                          </td>
                      </tr>
                      <tr class="d-lg-none">
                          <td colspan="2"><strong>Gramos:</strong> 
                            <span class="<?php echo ($insumo['In_PesoGramos'] != '') 
                                  ? ($insumo['In_PesoGramos'] != 0 ? 'badge bg-success' : 'badge bg-danger') 
                                  : ''; ?>">
                              <?php echo htmlspecialchars($insumo['In_PesoGramos']); ?>
                            </span>
                          </td>
                      </tr>
                      <tr class="d-lg-none">
                          <td colspan="2"><strong>Kilogramos:</strong> 
                            <span class="<?php echo ($insumo['In_PesoKilos'] != '') 
                                  ? ($insumo['In_PesoKilos'] != 0 ? 'badge bg-success' : 'badge bg-danger') 
                                  : ''; ?>">
                              <?php echo htmlspecialchars($insumo['In_PesoKilos']); ?>
                            </span>
                          </td>
                      </tr>
                      <tr class="d-lg-none">
                          <td colspan="2"><strong>MiliLitros:</strong> 
                            <span class="<?php echo ($insumo['In_Mililitros'] != '') 
                                  ? ($insumo['In_Mililitros'] != 0 ? 'badge bg-success' : 'badge bg-danger') 
                                  : ''; ?>">
                              <?php echo htmlspecialchars($insumo['In_Mililitros']); ?>
                            </span>
                          </td>
                      </tr>
                      <tr class="d-lg-none">
                          <td colspan="2"><strong>Litros:</strong> 
                            <span class="<?php echo ($insumo['In_Litros'] != '') 
                                  ? ($insumo['In_Litros'] != 0 ? 'badge bg-success' : 'badge bg-danger') 
                                  : ''; ?>">
                              <?php echo htmlspecialchars($insumo['In_Litros']); ?>
                            </span>
                          </td>
                      </tr>
                      <tr class="d-lg-none">
                          <td colspan="2"><strong>Numero de Porciones:</strong> 
                            <span class="<?php echo ($insumo['In_Porcion'] != '') 
                                    ? ($insumo['In_Porcion'] != 0 ? 'badge bg-success' : 'badge bg-danger') 
                                    : ''; ?>">
                              <?php echo htmlspecialchars($insumo['In_Porcion']); ?>
                            </span>
                          </td>
                      </tr>
                      <tr class="d-lg-none">
                          <td colspan="2"><strong>Otra Medida:</strong> 
                            <span class="<?php echo ($insumo['In_Otro'] != '') 
                                    ? ($insumo['In_Otro'] != 0 ? 'badge bg-success' : 'badge bg-danger') 
                                    : ''; ?>">
                              <?php echo htmlspecialchars($insumo['In_Otro']); ?>
                            </span>
                          </td>
                      </tr>
                      <tr class="d-lg-none">
                          <td colspan="2"><strong>Imagen:</strong> <img src="<?php echo htmlspecialchars($insumo['In_ImagenInsumo']); ?>" width="50" height="50" alt="<?php echo !empty($insumo['In_ImagenInsumo']) ? 'Imagen del producto' : 'Sin imagen asignada'; ?>"></td>
                      </tr>
                      <tr class="d-lg-none">
                          <td colspan="2">
                              <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalmodificarinsumo_<?php echo $insumo['In_InsumoId']; ?>">Modificar</button>
                              <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#modalEliminarInsumo_<?php echo $insumo['In_InsumoId']; ?>">Eliminar</button>
                          </td>
                      </tr> 
                      <!-- Separador entre registros -->
                      <tr class="d-lg-none">
                          <td colspan="2">&nbsp;</td> <!-- Esto añade un espacio vacío -->
                      </tr>
                      <?php
                          include '../assets/modalmodificarinsumos.php'; 
                          include '../assets/modaleliminarinsumo.php';
                      ?>
                      <?php endforeach; ?>
                  </tbody>
              </table>
              <!-- PAGINACIÓN -->
              
                <nav class="d-none d-lg-block">
                    <ul class="pagination justify-content-center">
                        <!-- Botón anterior -->
                        <li class="page-item <?php echo ($pagina_actual <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $pagina_actual - 1; ?>" tabindex="-1">Anterior</a>
                        </li>

                        <!-- Números de página -->
                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <li class="page-item <?php echo ($pagina_actual == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Botón siguiente -->
                        <li class="page-item <?php echo ($pagina_actual >= $total_paginas) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?pagina=<?php echo $pagina_actual + 1; ?>">Siguiente</a>
                        </li>
                    </ul>
                </nav>
              
          <?php else: ?>
              <p>No se encontraron Insumos.</p>
          <?php endif; ?>
        </div>

</div>
<script>
   document.getElementById('btnAgregarInsumo').addEventListener('click', function() {
        // Detecta el estado de aria-expanded para cambiar el ícono al instante
        var isExpanded = document.getElementById('btnAgregarInsumo').getAttribute('aria-expanded') === 'true';
        
        if (isExpanded) {
            document.getElementById('iconoAgregarInsumo').classList.remove('bi-plus-circle');
            document.getElementById('iconoAgregarInsumo').classList.add('bi-dash-circle');
        } else {
            document.getElementById('iconoAgregarInsumo').classList.remove('bi-dash-circle');
            document.getElementById('iconoAgregarInsumo').classList.add('bi-plus-circle');
        }
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
