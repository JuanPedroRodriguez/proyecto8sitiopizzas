                    <!-- Modal para confirmar eliminación -->
                    <div class="modal fade" id="modalEliminarCategoria_<?php echo $categoria['MC_CategoriaId']; ?>" tabindex="-1" aria-labelledby="modalEliminarLabel_<?php echo $categoria['MC_CategoriaId']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEliminarLabel_<?php echo $categoria['MC_CategoriaId']; ?>">Confirmar Eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar la categoría "<strong><?php echo htmlspecialchars($categoria['MC_NombreCategoria']); ?></strong>"?
                                </div>
                                <div class="modal-footer">
                                    <form action="crud/eliminar_categoria.php" method="POST">
                                        <input type="hidden" name="categoria_id" value="<?php echo $categoria['MC_CategoriaId']; ?>">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>