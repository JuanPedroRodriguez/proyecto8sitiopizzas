  <!-- Modal para confirmar eliminación -->
                    <div class="modal fade" id="modalEliminarInsumo_<?php echo $insumo['In_InsumoId']; ?>" tabindex="-1" aria-labelledby="modalEliminarLabel_<?php echo $insumo['In_NombreInsumo']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEliminarLabel_<?php echo $insumo['In_NombreInsumo']; ?>">Confirmar Eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar el insumo "<strong><?php echo htmlspecialchars($insumo['In_NombreInsumo']); ?></strong>"?
                                </div>
                                <div class="modal-footer">
                                    <form action="crud/eliminar_insumo.php" method="POST">
                                        <input type="hidden" name="insumoid" value="<?php echo $insumo['In_InsumoId']; ?>">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>