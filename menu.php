<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto pizzeria</title>
    <link rel="icon" type="image/x-icon" href="assets/imagenes/pizza.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
       /* Fijar las pestañas en el header */
       .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: #f8f9fa;
            z-index: 1030; /* Para que quede por encima del contenido */
            border-bottom: 1px solid #dee2e6;
        }
        /* Para el contenido del tabpanel */
        .content-body {
            padding-top: 70px; /* Asegurar que el contenido no quede debajo del header */
            margin-top: 100px; /* Espacio entre el contenido y las pestañas */
            text-align: center; /* Centrar el contenido horizontalmente */
        }

        /* Estilo para centrar los elementos en el header */
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Estilo para alinear los ítems del nav */
        .nav-tabs {
            flex: 1;
            display: flex;
            justify-content: center;
            
        }
        .nav-tabs .nav-link {
        color: white; /* Letras blancas para todas las pestañas por defecto */
        }
        .nav-link {
            border: none; /* Eliminar borde en los botones de navegación */
        }
        /* Estilo para la imagen */
        .logo img {
            height: 80px; 
        }
         /* Estilo para el footer */
         .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #f8f9fa;
            padding: 10px 0;
            border-top: 1px solid #dee2e6;
            text-align: center;
            z-index: 1030; 
        }
        .footer .container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        .footer .container p,
        .footer .container a {
            margin: 0;
            font-size: 14px;
            color: #000;
        }
        .footer .container .links {
            display: flex;
            gap: 15px;
        }
    </style>
</head>
<body>

<!-- Header con pestañas fijas -->
<div class="fixed-header" style="background-color: #3d3d3d;">
    <div class="container header-content">
        <!-- Nav tabs -->
        <div class="logo">
            <a href="index.php"><img src="assets/imagenes/pizzaimagen.png" alt="Logo Pizzería"></a>
        </div>
        <ul class="nav nav-tabs " id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="inicio-tab" data-bs-toggle="tab"  type="button" role="tab" aria-controls="tab1" aria-selected="false" onclick="window.location.href='index.php';">Inicio</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Pestaña 1</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">Pestaña 2</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3" aria-selected="false">Pestaña 3</button>
            </li>
        </ul>
    </div>
</div>

<!-- Cuerpo del contenido -->
<div class="container content-body">
    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <h3>Contenido de la Pestaña 1</h3>
            <p>Este es el contenido que se muestra cuando haces clic en la primera pestaña.</p>
        </div>
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            <h3>Contenido de la Pestaña 2</h3>
            <p>Aquí aparece el contenido de la segunda pestaña.</p>
        </div>
        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
            <h3>Contenido de la Pestaña 3</h3>
            <p>Este es el contenido mostrado al hacer clic en la tercera pestaña.</p>
        </div>
    </div>
    <footer class="footer" style="background-color: #3d3d3d;">
        <div class="container">
            <div class="links">
                <a href="index.php?tab=ubicacion"  class="btn btn-link" id="contact-link" style="color: #fff">Contacto</a>
                <a href="#" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#quienesSomosModal" style="color: #fff">Quiénes somos</a>
                <a href="index.php?tab=ubicacion" class="btn btn-link" id="contact-link2" style="color: #fff;"><i class="bi bi-telephone" style="color: #fff;"></i>&nbsp;3300001111</a>
            </div>
            <p class="mb-0" style="color: #fff;">Derechos reservados 2024</p>
        </div>
    </footer>
    <?php include 'assets/modal.php'; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>