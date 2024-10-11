  <!-- Modal para confirmar eliminación -->
                    <div class="modal fade" id="modalEliminarproducto_<?php echo $producto['MP_ProductoId']; ?>" tabindex="-1" aria-labelledby="modalEliminarLabel_<?php echo $producto['MP_NombreProducto']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEliminarLabel_<?php echo $producto['MP_ProductoId']; ?>">Confirmar Eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar la categoría "<strong><?php echo htmlspecialchars($producto['MP_NombreProducto']); ?></strong>"?
                                </div>
                                <div class="modal-footer">
                                    <form action="crud/eliminar_producto.php" method="POST">
                                        <input type="hidden" name="producto_id" value="<?php echo $producto['MP_ProductoId']; ?>">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>