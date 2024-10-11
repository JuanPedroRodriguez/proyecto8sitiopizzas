                <!-- Modal -->
                    <div class="modal fade" id="modalModificarCategoria_<?php echo $categoria['MC_CategoriaId']; ?>" tabindex="-1" aria-labelledby="modalLabel_<?php echo $categoria['MC_CategoriaId']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel_<?php echo $categoria['MC_CategoriaId']; ?>">Modificar Categoría</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="crud/modificar_categoria.php" method="POST">
                                        <input type="hidden" name="categoria_id" value="<?php echo $categoria['MC_CategoriaId']; ?>">
                                        <div class="mb-3">
                                            <label for="nombre_categoria_<?php echo $categoria['MC_CategoriaId']; ?>" class="form-label">Nombre de la Categoría</label>
                                            <input type="text" class="form-control" id="nombre_categoria_<?php echo $categoria['MC_CategoriaId']; ?>" name="nombre_categoria" value="<?php echo htmlspecialchars($categoria['MC_NombreCategoria']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="descripcion_categoria_<?php echo $categoria['MC_CategoriaId']; ?>" class="form-label">Descripción de la Categoría</label>
                                            <textarea class="form-control" id="descripcion_categoria_<?php echo $categoria['MC_CategoriaId']; ?>" name="descripcion_categoria" required><?php echo htmlspecialchars($categoria['MC_DescripcionCategoria']); ?></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
               
           
                