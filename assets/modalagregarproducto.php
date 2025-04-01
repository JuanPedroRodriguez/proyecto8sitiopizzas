<!-- Modal para agregar producto -->
<div class="modal fade" id="agregarProductoModal<?php echo $categoria['MC_CategoriaId']; ?>" tabindex="-1" aria-labelledby="agregarProductoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="crud/crear_producto.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarProductoLabel">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="categoria_id" id="categoria_id" value= <?php echo $categoria['MC_CategoriaId']; ?>>
                    <div class="mb-3">
                        <label for="nombre_producto" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion_producto" class="form-label">Descripción del Producto</label>
                        <textarea class="form-control" id="descripcion_producto" name="descripcion_producto"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precio_producto" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio_producto" name="precio_producto" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="imagen_producto" class="form-label">Imagen del Producto</label>
                        <input type="file" class="form-control" id="imagen_producto" name="imagen_producto" accept="image/*" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Agregar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>