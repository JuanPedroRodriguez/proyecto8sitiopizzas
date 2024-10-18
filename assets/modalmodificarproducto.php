<!-- Modal para modificar producto -->
<div class="modal fade" id="modalmodificarproducto_<?php echo $producto['MP_ProductoId']; ?>" tabindex="-1" aria-labelledby="modificarProductoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modificarProductoLabel">Modificar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="crud/modificar_productos.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="producto_id" id="productoId" value="<?php echo $producto['MP_ProductoId']; ?>"> <!-- ID del producto a modificar -->
          
          <div class="mb-3">
            <label for="nombreProducto" class="form-label">Nombre del Producto</label>
            <input type="text" class="form-control" id="nombreProducto" name="nombre_producto" value="<?php echo $producto['MP_NombreProducto']; ?>">
          </div>

          <div class="mb-3">
            <label for="descripcionProducto" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcionProducto" name="descripcion_producto" rows="3" value="<?php echo $producto['MP_DescripcionProducto']; ?>"></textarea>
          </div>

          <div class="mb-3">
            <label for="precioProducto" class="form-label">Precio</label>
            <input type="number" class="form-control" id="precioProducto" name="precio_producto" value="<?php echo $producto['MP_PrecioProducto']; ?>">
          </div>

          <div class="mb-3">
            <label for="imagenProducto" class="form-label">Imagen del Producto (opcional)</label>
            <input type="file" class="form-control" id="imagenProducto" name="imagen_producto">
          </div>

        <input type="hidden" name="categoria_id" id="categoria_id" value ="<?php echo $categoria['MC_CategoriaId']; ?>">

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
        </form>
      </div>
    </div>
  </div>
</div>
