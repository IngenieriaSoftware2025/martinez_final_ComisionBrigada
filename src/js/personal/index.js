import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormPersonal = document.getElementById('FormPersonal');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnMostrarRegistros = document.getElementById('BtnMostrarRegistros');
const SeccionTabla = document.getElementById('SeccionTablaPersonal');
const perso_grado = document.getElementById('perso_grado');
const perso_nombre = document.getElementById('perso_nombre');
const perso_apellidos = document.getElementById('perso_apellidos');
const perso_unidad = document.getElementById('perso_unidad');

// Validaciones de campos obligatorios
const ValidarGrado = () => {
    const grado = perso_grado.value.trim();
    
    if (grado.length < 2) {
        perso_grado.classList.remove('is-valid');
        perso_grado.classList.add('is-invalid');
        return false;
    } else if (grado.length > 50) {
        perso_grado.classList.remove('is-valid');
        perso_grado.classList.add('is-invalid');
        return false;
    } else {
        perso_grado.classList.remove('is-invalid');
        perso_grado.classList.add('is-valid');
        return true;
    }
}

const ValidarNombre = () => {
    const nombre = perso_nombre.value.trim();
    
    if (nombre.length < 2) {
        perso_nombre.classList.remove('is-valid');
        perso_nombre.classList.add('is-invalid');
        return false;
    } else if (nombre.length > 50) {
        perso_nombre.classList.remove('is-valid');
        perso_nombre.classList.add('is-invalid');
        return false;
    } else {
        perso_nombre.classList.remove('is-invalid');
        perso_nombre.classList.add('is-valid');
        return true;
    }
}

const ValidarApellidos = () => {
    const apellidos = perso_apellidos.value.trim();
    
    if (apellidos.length < 2) {
        perso_apellidos.classList.remove('is-valid');
        perso_apellidos.classList.add('is-invalid');
        return false;
    } else if (apellidos.length > 50) {
        perso_apellidos.classList.remove('is-valid');
        perso_apellidos.classList.add('is-invalid');
        return false;
    } else {
        perso_apellidos.classList.remove('is-invalid');
        perso_apellidos.classList.add('is-valid');
        return true;
    }
}

const ValidarUnidad = () => {
    const unidad = perso_unidad.value.trim();
    
    if (unidad.length > 100) {
        perso_unidad.classList.remove('is-valid');
        perso_unidad.classList.add('is-invalid');
        return false;
    } else {
        perso_unidad.classList.remove('is-invalid');
        perso_unidad.classList.add('is-valid');
        return true;
    }
}

// Validación completa del formulario
const ValidarFormularioCompleto = () => {
    let esValido = true;
    
    if (!ValidarGrado()) esValido = false;
    if (!ValidarNombre()) esValido = false;
    if (!ValidarApellidos()) esValido = false;
    if (!ValidarUnidad()) esValido = false;
    
    return esValido;
}

const datatable = new DataTable('#TablePersonal', {
    dom: `<"row mt-3 justify-content-between" <"col" l> <"col" B> <"col-3" f>>t<"row mt-3 justify-content-between" <"col-md-3 d-flex align-items-center" i> <"col-md-8 d-flex justify-content-end" p>>`,
    language: lenguaje,
    data: [],
    columns: [
        { title: 'No.', data: 'perso_id', render: (data, type, row, meta) => meta.row + 1 },
        { title: 'Grado', data: 'perso_grado' },
        { title: 'Nombre', data: 'perso_nombre' },
        { title: 'Apellidos', data: 'perso_apellidos' },
        { title: 'Unidad', data: 'perso_unidad', render: (data) => data || 'No asignada' },
        {
            title: 'Acciones',
            data: 'perso_id',
            searchable: false,
            orderable: false,
            render: (data, type, row) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-grado="${row.perso_grado}"  
                         data-nombre="${row.perso_nombre}"  
                         data-apellidos="${row.perso_apellidos}"  
                         data-unidad="${row.perso_unidad || ''}">   
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
        BuscarPersonal(true);
    } else {
        SeccionTabla.style.display = 'none';
        BtnMostrarRegistros.innerHTML = '<i class="bi bi-eye me-2"></i>Mostrar Registros';
        BtnMostrarRegistros.classList.remove('btn-warning');
        BtnMostrarRegistros.classList.add('btn-info');
    }
}

const limpiarTodo = () => {
    FormPersonal.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    FormPersonal.querySelectorAll('.form-control').forEach(element => {
        element.classList.remove('is-valid', 'is-invalid');
    });
}

const BuscarPersonal = async (mostrarMensaje = false) => {
    const url = '/martinez_final_ComisionBrigada/personal/buscarAPI';
    const config = { method: 'GET' };
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos;
        if (codigo == 1) {
            const personal = data || [];
            datatable.clear().draw();
            datatable.rows.add(personal).draw();
            if (mostrarMensaje) {
                await Swal.fire({ 
                    position: "center", 
                    icon: "success", 
                    title: "¡Personal cargado!", 
                    text: `Se cargaron ${personal.length} registro(s) correctamente`, 
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

const GuardarPersonal = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    // Verificar que todos los campos obligatorios estén llenos
    if (!perso_grado.value || !perso_nombre.value || !perso_apellidos.value) {
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

    const body = new FormData(FormPersonal);
    const url = '/martinez_final_ComisionBrigada/personal/guardarAPI';
    const config = { method: 'POST', body };
    
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;
        
        if (codigo == 1) {
            await Swal.fire({ 
                position: "center", 
                icon: "success", 
                title: "¡Personal guardado exitosamente!", 
                text: mensaje, 
                showConfirmButton: false, 
                timer: 2000 
            });
            limpiarTodo();
            await BuscarPersonal(false);
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

const ModificarPersonal = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    // Verificar que todos los campos obligatorios estén llenos
    if (!perso_grado.value || !perso_nombre.value || !perso_apellidos.value) {
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

    const body = new FormData(FormPersonal);
    const url = '/martinez_final_ComisionBrigada/personal/modificarAPI';
    const config = { method: 'POST', body };
    
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;
        
        if (codigo == 1) {
            await Swal.fire({ 
                position: "center", 
                icon: "success", 
                title: "¡Personal modificado exitosamente!", 
                text: mensaje, 
                showConfirmButton: false, 
                timer: 2000 
            });
            limpiarTodo();
            await BuscarPersonal(false);
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
    
    document.getElementById('perso_id').value = datos.id;
    document.getElementById('perso_grado').value = datos.grado;
    document.getElementById('perso_nombre').value = datos.nombre;
    document.getElementById('perso_apellidos').value = datos.apellidos;
    document.getElementById('perso_unidad').value = datos.unidad;
    
    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');
    
    window.scrollTo({ top: 0 });
}

const EliminarPersonal = async (e) => {
    const idPersonal = e.currentTarget.dataset.id;

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "warning",
        title: "¿Desea ejecutar esta acción?",
        text: 'Esta completamente seguro que desea eliminar este registro',
        showConfirmButton: true,
        confirmButtonText: 'Si, Eliminar',
        confirmButtonColor: '#d33',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/martinez_final_ComisionBrigada/personal/eliminarAPI?id=${idPersonal}`;
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
                BuscarPersonal(false);
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

// Event Listeners
BuscarPersonal(false);
FormPersonal.addEventListener('submit', GuardarPersonal);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarPersonal);
BtnMostrarRegistros.addEventListener('click', MostrarRegistros);
datatable.on('click', '.modificar', llenarFormulario);
datatable.on('click', '.eliminar', EliminarPersonal);

// Validaciones en tiempo real
perso_grado.addEventListener('blur', ValidarGrado);
perso_nombre.addEventListener('blur', ValidarNombre);
perso_apellidos.addEventListener('blur', ValidarApellidos);
perso_unidad.addEventListener('blur', ValidarUnidad);