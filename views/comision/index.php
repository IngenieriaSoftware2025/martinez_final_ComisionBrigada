<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h3 class="text-center mb-2">BIENVENIDO</h3>
                    <h4 class="text-center mb-2 text-primary">Gestión de Comisiones</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">

                    <form id="FormComision">
                        <input type="hidden" id="com_id" name="com_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="com_usuario" class="form-label">Personal
                                </label>
                                <select class="form-select" id="com_usuario" name="com_usuario" required>
                                    <option value="">Seleccione el personal...</option>
                                    <?php foreach ($personal as $persona): ?>
                                        <?php if ($persona->perso_situacion == 1): ?>
                                            <option value="<?= $persona->perso_id ?>">
                                                <?= $persona->perso_grado . ' ' . $persona->perso_nombre . ' ' . $persona->perso_apellidos ?> - <?= $persona->perso_unidad ?: 'Sin unidad' ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="com_destino" class="form-label">Destino
                                </label>
                                <input type="text" class="form-control" id="com_destino" name="com_destino" 
                                       placeholder="Ingrese el destino" required>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-12">
                                <label for="com_descripcion" class="form-label">Descripción
                                </label>
                                <input type="text" class="form-control" id="com_descripcion" name="com_descripcion" 
                                       placeholder="Ingrese la descripción de la comisión" required>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="com_fech_inicio" class="form-label">Fecha de Inicio 
                                </label>
                                <input type="datetime-local" class="form-control" id="com_fech_inicio" name="com_fech_inicio" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="com_fech_fin" class="form-label">Fecha de Fin 
                                </label>
                                <input type="datetime-local" class="form-control" id="com_fech_fin" name="com_fech_fin" required>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-5">
                            <div class="col-auto">
                                <button class="btn btn-success" type="submit" id="BtnGuardar">
                                    <i class="bi bi-floppy me-2"></i>Guardar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                                    <i class="bi bi-pencil me-2"></i>Modificar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-secondary" type="reset" id="BtnLimpiar">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Limpiar
                                </button>
                            </div>
                            
                            <div class="col-auto">
                                <button class="btn btn-info" type="button" id="BtnMostrarRegistros">
                                    <i class="bi bi-eye me-2"></i>Mostrar Registros
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center p-3" id="SeccionTablaComisiones" style="display:none;">
    <div class="col-lg-12">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <div class="col-12">
                        <h3 class="text-center text-primary">
                            COMISIONES REGISTRADAS
                        </h3>
                    </div>
                </div>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableComisiones">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/comision/index.js') ?>"></script>