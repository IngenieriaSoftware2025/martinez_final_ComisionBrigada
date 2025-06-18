import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";

const FormComision = document.getElementById('FormComision');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnMostrarRegistros = document.getElementById('BtnMostrarRegistros');
const SeccionTabla = document.getElementById('SeccionTablaComisiones');
const com_usuario = document.getElementById('com_usuario');
const com_destino = document.getElementById('com_destino');
const com_descripcion = document.getElementById('com_descripcion');
const com_fech_inicio = document.getElementById('com_fech_inicio');
const com_fech_fin = document.getElementById('com_fech_fin');

// Validaciones de campos obligatorios
const ValidarUsuario = () => {
    const usuario = com_usuario.value.trim();
    
    if (usuario === '') {
        com_usuario.classList.remove('is-valid');
        com_usuario.classList.add('is-invalid');
        return false;
    } else {
        com_usuario.classList.remove('is-invalid');
        com_usuario.classList.add('is-valid');
        return true;
    }
}

const ValidarDestino = () => {
    const destino = com_destino.value.trim();
    
    if (destino.length < 3) {
        com_destino.classList.remove('is-valid');
        com_destino.classList.add('is-invalid');
        return false;
    } else if (destino.length > 250) {
        com_destino.classList.remove('is-valid');
        com_destino.classList.add('is-invalid');
        return false;
    } else {
        com_destino.classList.remove('is-invalid');
        com_destino.classList.add('is-valid');
        return true;
    }
}

const ValidarDescripcion = () => {
    const descripcion = com_descripcion.value.trim();
    
    if (descripcion.length < 10) {
        com_descripcion.classList.remove('is-valid');
        com_descripcion.classList.add('is-invalid');
        return false;
    } else if (descripcion.length > 500) {
        com_descripcion.classList.remove('is-valid');
        com_descripcion.classList.add('is-invalid');
        return false;
    } else {
        com_descripcion.classList.remove('is-invalid');
        com_descripcion.classList.add('is-valid');
        return true;
    }
}

const ValidarFechaInicio = () => {
    const fechaInicio = com_fech_inicio.value;
    const fechaActual = new Date();
    const fechaSeleccionada = new Date(fechaInicio);
    
    if (!fechaInicio) {
        com_fech_inicio.classList.remove('is-valid');
        com_fech_inicio.classList.add('is-invalid');
        return false;
    } else if (fechaSeleccionada < fechaActual) {
        com_fech_inicio.classList.remove('is-valid');
        com_fech_inicio.classList.add('is-invalid');
        return false;
    } else {
        com_fech_inicio.classList.remove('is-invalid');
        com_fech_inicio.classList.add('is-valid');
        return true;
    }
}

const ValidarFechaFin = () => {
    const fechaInicio = com_fech_inicio.value;
    const fechaFin = com_fech_fin.value;
    
    if (!fechaFin) {
        com_fech_fin.classList.remove('is-valid');
        com_fech_fin.classList.add('is-invalid');
        return false;
    } else if (fechaInicio && new Date(fechaFin) <= new Date(fechaInicio)) {
        com_fech_fin.classList.remove('is-valid');
        com_fech_fin.classList.add('is-invalid');
        return false;
    } else {
        com_fech_fin.classList.remove('is-invalid');
        com_fech_fin.classList.add('is-valid');
        return true;
    }
}

// Validación completa del formulario
const ValidarFormularioCompleto = () => {
    let esValido = true;
    
    if (!ValidarUsuario()) esValido = false;
    if (!ValidarDestino()) esValido = false;
    if (!ValidarDescripcion()) esValido = false;
    if (!ValidarFechaInicio()) esValido = false;
    if (!ValidarFechaFin()) esValido = false;
    
    return esValido;
}

const datatable = new DataTable('#TableComisiones', {
    dom: `<"row mt-3 justify-content-between" <"col" l> <"col" B> <"col-3" f>>t<"row mt-3 justify-content-between" <"col-md-3 d-flex align-items-center" i> <"col-md-8 d-flex justify-content-end" p>>`,
    language: lenguaje,
    data: [],
    columns: [
        { title: 'No.', data: 'com_id', render: (data, type, row, meta) => meta.row + 1 },
        { title: 'Personal', data: 'personal_completo' },
        { title: 'Unidad', data: 'perso_unidad', render: (data) => data || 'No asignada' },
        { title: 'Destino', data: 'com_destino' },
        { title: 'Descripción', data: 'com_descripcion' },
        { 
            title: 'Fecha Inicio', 
            data: 'com_fech_inicio',
            render: (data) => {
                if (data) {
                    const fecha = new Date(data);
                    return fecha.toLocaleString('es-ES', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
                return '';
            }
        },
        { 
            title: 'Fecha Fin', 
            data: 'com_fech_fin',
            render: (data) => {
                if (data) {
                    const fecha = new Date(data);
                    return fecha.toLocaleString('es-ES', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
                return '';
            }
        },
        {
            title: 'Estado',
            data: null,
            render: (data, type, row) => {
                const ahora = new Date();
                const inicio = new Date(row.com_fech_inicio);
                const fin = new Date(row.com_fech_fin);
                
                if (ahora < inicio) {
                    return 'Pendiente';
                } else if (ahora >= inicio && ahora <= fin) {
                    return 'Activa';
                } else {
                    return 'Finalizada';
                }
            }
        },
        {
            title: 'Acciones',
            data: 'com_id',
            searchable: false,
            orderable: false,
            render: (data, type, row) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-usuario="${row.com_usuario}"  
                         data-destino="${row.com_destino}"  
                         data-descripcion="${row.com_descripcion}"  
                         data-fech_inicio="${row.com_fech_inicio}"
                         data-fech_fin="${row.com_fech_fin}">   
                         <i class='bi bi-pencil-square me-1'></i> Modificar
                     </button>
                     <button class='btn btn-danger eliminar mx-1' 
                         data-id="${data}">
                        <i class="bi bi-trash3 me-1"></i>Eliminar
                     </button>
                 </div>`;
            }
        }
    ]
});

const MostrarRegistros = () => {
    const estaOculto = SeccionTabla.style.display === 'none';
    if (estaOculto) {
        SeccionTabla.style.display = 'block';
        BtnMostrarRegistros.innerHTML = '<i class="bi bi-eye-slash me-2"></i>Ocultar Registros';
        BtnMostrarRegistros.classList.remove('btn-info');
        BtnMostrarRegistros.classList.add('btn-warning');
        BuscarComisiones(true);
    } else {
        SeccionTabla.style.display = 'none';
        BtnMostrarRegistros.innerHTML = '<i class="bi bi-eye me-2"></i>Mostrar Registros';
        BtnMostrarRegistros.classList.remove('btn-warning');
        BtnMostrarRegistros.classList.add('btn-info');
    }
}

const limpiarTodo = () => {
    FormComision.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    FormComision.querySelectorAll('.form-control, .form-select').forEach(element => {
        element.classList.remove('is-valid', 'is-invalid');
    });
}

const BuscarComisiones = async (mostrarMensaje = false) => {
    const url = '/martinez_final_ComisionBrigada/comision/buscarAPI';
    const config = { method: 'GET' };
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos;
        if (codigo == 1) {
            const comisiones = data || [];
            datatable.clear().draw();
            datatable.rows.add(comisiones).draw();
            if (mostrarMensaje) {
                await Swal.fire({ 
                    position: "center", 
                    icon: "success", 
                    title: "¡Comisiones cargadas!", 
                    text: `Se cargaron ${comisiones.length} registro(s) correctamente`, 
                    showConfirmButton: false, 
                    timer: 1500 
                });
            }
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.log(error);
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo conectar con el servidor",
            showConfirmButton: true,
        });
    }
}

const GuardarComision = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    // Verificar que todos los campos obligatorios estén llenos
    if (!com_usuario.value || !com_destino.value || !com_descripcion.value || !com_fech_inicio.value || !com_fech_fin.value) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe llenar todos los campos obligatorios",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    // Validar el formulario
    const formularioValido = ValidarFormularioCompleto();
    
    if (!formularioValido) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe corregir todos los errores antes de continuar",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormComision);
    const url = '/martinez_final_ComisionBrigada/comision/guardarAPI';
    const config = { method: 'POST', body };
    
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;
        
        if (codigo == 1) {
            await Swal.fire({ 
                position: "center", 
                icon: "success", 
                title: "¡Comisión guardada exitosamente!", 
                text: mensaje, 
                showConfirmButton: false, 
                timer: 2000 
            });
            limpiarTodo();
            await BuscarComisiones(false);
        } else {
            await Swal.fire({ 
                position: "center", 
                icon: "error", 
                title: "Error al guardar", 
                text: mensaje, 
                showConfirmButton: true 
            });
        }
    } catch (error) {
        console.log(error);
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo conectar con el servidor",
            showConfirmButton: true,
        });
    }
    BtnGuardar.disabled = false;
}

const ModificarComision = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    // Verificar que todos los campos obligatorios estén llenos
    if (!com_usuario.value || !com_destino.value || !com_descripcion.value || !com_fech_inicio.value || !com_fech_fin.value) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe llenar todos los campos obligatorios",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    // Validar el formulario
    const formularioValido = ValidarFormularioCompleto();
    
    if (!formularioValido) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe corregir todos los errores antes de continuar",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormComision);
    const url = '/martinez_final_ComisionBrigada/comision/modificarAPI';
    const config = { method: 'POST', body };
    
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;
        
        if (codigo == 1) {
            await Swal.fire({ 
                position: "center", 
                icon: "success", 
                title: "¡Comisión modificada exitosamente!", 
                text: mensaje, 
                showConfirmButton: false, 
                timer: 2000 
            });
            limpiarTodo();
            await BuscarComisiones(false);
        } else {
            await Swal.fire({ 
                position: "center", 
                icon: "error", 
                title: "Error al modificar", 
                text: mensaje, 
                showConfirmButton: true 
            });
        }
    } catch (error) {
        console.log(error);
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo conectar con el servidor",
            showConfirmButton: true,
        });
    }
    BtnModificar.disabled = false;
}

const llenarFormulario = (event) => {
    const datos = event.currentTarget.dataset;
    
    document.getElementById('com_id').value = datos.id;
    document.getElementById('com_destino').value = datos.destino;
    document.getElementById('com_descripcion').value = datos.descripcion;
    
    // Convertir fechas al formato datetime-local
    const fechaInicio = new Date(datos.fech_inicio);
    const fechaFin = new Date(datos.fech_fin);
    
    document.getElementById('com_fech_inicio').value = fechaInicio.toISOString().slice(0, 16);
    document.getElementById('com_fech_fin').value = fechaFin.toISOString().slice(0, 16);
    
    // Seleccionar el usuario directamente
    document.getElementById('com_usuario').value = datos.usuario;
    
    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');
    
    window.scrollTo({ top: 0 });
}

const EliminarComision = async (e) => {
    const idComision = e.currentTarget.dataset.id;

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "warning",
        title: "¿Desea ejecutar esta acción?",
        text: 'Esta completamente seguro que desea eliminar esta comisión',
        showConfirmButton: true,
        confirmButtonText: 'Si, Eliminar',
        confirmButtonColor: '#d33',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/martinez_final_ComisionBrigada/comision/eliminarAPI?id=${idComision}`;
        const config = { method: 'GET' };

        try {
            const consulta = await fetch(url, config);
            const respuesta = await consulta.json();
            const { codigo, mensaje } = respuesta;

            if (codigo == 1) {
                await Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Éxito",
                    text: mensaje,
                    showConfirmButton: true,
                });
                BuscarComisiones(false);
            } else {
                await Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Error",
                    text: mensaje,
                    showConfirmButton: true,
                });
            }
        } catch (error) {
            console.log(error);
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error de conexión",
                text: "No se pudo conectar con el servidor",
                showConfirmButton: true,
            });
        }
    }
}


BuscarComisiones(false);
FormComision.addEventListener('submit', GuardarComision);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarComision);
BtnMostrarRegistros.addEventListener('click', MostrarRegistros);
datatable.on('click', '.modificar', llenarFormulario);
datatable.on('click', '.eliminar', EliminarComision);

// Validaciones en tiempo real
com_usuario.addEventListener('change', ValidarUsuario);
com_destino.addEventListener('blur', ValidarDestino);
com_descripcion.addEventListener('blur', ValidarDescripcion);
com_fech_inicio.addEventListener('blur', ValidarFechaInicio);
com_fech_fin.addEventListener('blur', ValidarFechaFin);

// Validar fechas cuando cambien
com_fech_inicio.addEventListener('change', () => {
    ValidarFechaInicio();
    if (com_fech_fin.value) {
        ValidarFechaFin();
    }
});

com_fech_fin.addEventListener('change', ValidarFechaFin);