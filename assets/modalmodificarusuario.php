<!-- Modal para modificar usuario -->
<div class="modal fade" id="modalModificarUsuario_<?php echo $usuario['AL_SocioId']; ?>" tabindex="-1" aria-labelledby="modalLabel_<?php echo $usuario['AL_SocioId']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel_<?php echo $usuario['AL_SocioId']; ?>">Modificar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="crud/modificar_usuario.php" method="POST">
                    <input type="hidden" name="usuario_id" value="<?php echo $usuario['AL_SocioId']; ?>">
                    <div class="mb-3">
                        <label for="nombre_usuario_<?php echo $usuario['AL_SocioId']; ?>" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="nombre_usuario_<?php echo $usuario['AL_SocioId']; ?>" name="nombre_usuario" value="<?php echo htmlspecialchars($usuario['AL_NombreDeUsuario']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="primer_apellido_<?php echo $usuario['AL_SocioId']; ?>" class="form-label">Primer Apellido</label>
                        <input type="text" class="form-control" id="primer_apellido_<?php echo $usuario['AL_SocioId']; ?>" name="primer_apellido" value="<?php echo htmlspecialchars($usuario['AL_PrimerApellido']); ?>" >
                    </div>
                    <div class="mb-3">
                        <label for="segundo_apellido_<?php echo $usuario['AL_SocioId']; ?>" class="form-label">Segundo Apellido</label>
                        <input type="text" class="form-control" id="segundo_apellido_<?php echo $usuario['AL_SocioId']; ?>" name="segundo_apellido" value="<?php echo htmlspecialchars($usuario['AL_SegundoApellido']); ?>" >
                    </div>
                    <div class="mb-3">
                        <label for="email_<?php echo $usuario['AL_SocioId']; ?>" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email_<?php echo $usuario['AL_SocioId']; ?>" name="email" value="<?php echo htmlspecialchars($usuario['AL_Correo']); ?>" >
                    </div>
                    <div class="mb-3">
                        <label for="password_<?php echo $usuario['AL_SocioId']; ?>" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password_<?php echo $usuario['AL_SocioId']; ?>" name="password">
                        <small class="text-muted">Si no desea cambiar la contraseña, deje este campo vacío.</small>
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
