<!-- Modal para confirmar eliminación de usuario -->
<div class="modal fade" id="modalEliminarUsuario_<?php echo $usuario['AL_SocioId']; ?>" tabindex="-1" aria-labelledby="modalEliminarLabel_<?php echo $usuario['AL_SocioId']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarLabel_<?php echo $usuario['AL_SocioId']; ?>">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar al usuario "<strong><?php echo htmlspecialchars($usuario['AL_NombreDeUsuario']); ?></strong>"?
            </div>
            <div class="modal-footer">
                <form action="crud/eliminar_usuario.php" method="POST">
                    <input type="hidden" name="usuario_id" value="<?php echo $usuario['AL_SocioId']; ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
