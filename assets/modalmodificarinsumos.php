<!-- Modal para modificar producto -->
<div class="modal fade" id="modalmodificarinsumo_<?php echo $insumo['In_InsumoId']; ?>" tabindex="-1" aria-labelledby="modificarinsumoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modificarinsumoLabel">Modificar Insumo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="crud/.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="producto_id" id="productoId" value="<?php echo $insumo['In_InsumoId']; ?>"> <!-- ID del producto a modificar -->
 
          <div class="mb-3">
            <label for="nombre_insumo" class="form-label">Nombre del insumo</label>
            <input type="text" class="form-control" id="nombre_insumo" name="nombre_insumo" value="<?php echo $insumo['In_NombreInsumo']; ?>">
          </div>

          <div class="mb-3">
            <label for="piezas" class="form-label">Numero de Piezas</label>
            <input type="text" class="form-control" id="piezas" name="piezas" value="<?php echo $insumo['In_NumeroPiezas']; ?>">
          </div>

          <div class="mb-3">
            <label for="gramos" class="form-label">Gramos</label>
            <input type="text" class="form-control" id="gramos" name="gramos" value="<?php echo $insumo['In_PesoGramos']; ?>">
          </div>

          <div class="mb-3">
            <label for="kilogramos" class="form-label">Kilogramos</label>
            <input type="text" class="form-control" id="kilogramos" name="kilogramos" value="<?php echo $insumo['In_PesoKilos']; ?>">
          </div>

          <div class="mb-3">
            <label for="litros" class="form-label">Litros</label>
            <input type="text" class="form-control" id="litros" name="litros" value="<?php echo $insumo['In_Litros']; ?>">
          </div>

          <div class="mb-3">
            <label for="mililitros" class="form-label">MiliLitros</label>
            <input type="text" class="form-control" id="mililitros" name="mililitros" value="<?php echo $insumo['In_Mililitros']; ?>">
          </div>

          <div class="mb-3">
            <label for="porcion" class="form-label">Numero de Porciones</label>
            <input type="text" class="form-control" id="porcion" name="porcion" value="<?php echo $insumo['In_Porcion']; ?>">
          </div>

          <div class="mb-3">
            <label for="otro" class="form-label">Otro tipo de medida</label>
            <input type="text" class="form-control" id="otro" name="otro" value="<?php echo $insumo['In_Otro']; ?>">
          </div>

          <div class="mb-3">
            <label for="imagenProducto" class="form-label">Imagen del Producto</label>
            <?php if ($insumo['In_ImagenInsumo'] == '' or $insumo['In_ImagenInsumo'] == null) { ?>
            <input type="file" class="form-control" id="imagenProducto" name="imagen_producto"> 
            <?php }else {?>
            <img src="<?php echo htmlspecialchars($insumo['In_ImagenInsumo']); ?>"  width="50" height="50"><br>
            <span>¿Quiere cambiar la imagen?</span><br>
            <input type="file" class="form-control" id="imagenProducto" name="imagen_producto"> 
            <?php }?>
          </div>

        <input type="hidden" name="categoria_id" id="categoria_id" value ="<?php echo $insumo['In_InsumoId']; ?>">

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
        </form>
      </div>
    </div>
  </div>
</div>
