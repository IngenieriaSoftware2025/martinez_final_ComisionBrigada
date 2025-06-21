<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h3 class="text-center mb-2">BIENVENIDO</h3>
                    <h4 class="text-center mb-2 text-primary">Registro de Rutas</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">

                    <form id="FormRutas">
                        <input type="hidden" id="rut_id" name="rut_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="rut_aplicacion" class="form-label">Aplicación</label>
                                <input type="text" class="form-control" id="rut_aplicacion" name="rut_aplicacion" placeholder="Ingrese la aplicación">
                            </div>
                            <div class="col-lg-6">
                                <label for="rut_ruta" class="form-label">Ruta</label>
                                <input type="text" class="form-control" id="rut_ruta" name="rut_ruta" placeholder="Ingrese la ruta">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-12">
                                <label for="rut_descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="rut_descripcion" name="rut_descripcion" rows="3" placeholder="Ingrese la descripción de la ruta"></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-5">
                            <div class="col-auto">
                                <button class="btn btn-success" type="submit" id="BtnGuardar"><i class="bi bi-floppy me-2"></i>
                                    Guardar
                                </button>
                            </div>

                            <div class="col-auto ">
                                <button class="btn btn-warning d-none" type="button" id="BtnModificar"><i class="bi bi-pencil me-2"></i>
                                    Modificar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-secondary" type="reset" id="BtnLimpiar"><i class="bi bi-arrow-clockwise me-2"></i>
                                    Limpiar
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

<div class="row justify-content-center p-3" id="SeccionTablaRutas" style="display:none;">
    <div class="col-lg-12">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <h3 class="text-center">RUTAS REGISTRADAS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableRutas">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/rutas/index.js') ?>"></script>