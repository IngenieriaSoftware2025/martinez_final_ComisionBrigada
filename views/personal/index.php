<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h3 class="text-center mb-2">BIENVENIDO</h3>
                    <h4 class="text-center mb-2 text-primary">Gestión de Personal</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">

                    <form id="FormPersonal">
                        <input type="hidden" id="perso_id" name="perso_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="perso_grado" class="form-label">Grado
                                </label>
                                <input type="text" class="form-control" id="perso_grado" name="perso_grado" 
                                       placeholder="Ingrese el grado"  required>
                            </div>
                            <div class="col-lg-6">
                                <label for="perso_nombre" class="form-label">Nombre
                                </label>
                                <input type="text" class="form-control" id="perso_nombre" name="perso_nombre" 
                                       placeholder="Ingrese el nombre" required>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="perso_apellidos" class="form-label">Apellidos
                                </label>
                                <input type="text" class="form-control" id="perso_apellidos" name="perso_apellidos" 
                                       placeholder="Ingrese los apellidos" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="perso_unidad" class="form-label">Unidad
                                </label>
                                <input type="text" class="form-control" id="perso_unidad" name="perso_unidad" 
                                       placeholder="Ingrese la unidad">
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

<!-- Sección de tabla -->
<div class="row justify-content-center p-3" id="SeccionTablaPersonal" style="display:none;">
    <div class="col-lg-12">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <div class="col-12">
                        <h3 class="text-center text-primary">
                            PERSONAL REGISTRADO
                        </h3>
                    </div>
                </div>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TablePersonal">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/personal/index.js') ?>"></script>