import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormRutas = document.getElementById('FormRutas');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnMostrarRegistros = document.getElementById('BtnMostrarRegistros');
const SeccionTabla = document.getElementById('SeccionTablaRutas');

const MostrarRegistros = () => {
    const estaOculto = SeccionTabla.style.display === 'none';
    
    if (estaOculto) {
        SeccionTabla.style.display = 'block';
        BtnMostrarRegistros.innerHTML = '<i class="bi bi-eye-slash me-2"></i>Ocultar Registros';
        BtnMostrarRegistros.classList.remove('btn-info');
        BtnMostrarRegistros.classList.add('btn-warning');
        BuscarRutas(true);
    } else {
        SeccionTabla.style.display = 'none';
        BtnMostrarRegistros.innerHTML = '<i class="bi bi-eye me-2"></i>Mostrar Registros';
        BtnMostrarRegistros.classList.remove('btn-warning');
        BtnMostrarRegistros.classList.add('btn-info');
    }
}

const GuardarRuta = async (event) => {

    event.preventDefault();
    BtnGuardar.disabled = true;

    // Validar campos manualmente
    const aplicacion = document.getElementById('rut_aplicacion').value.trim();
    const ruta = document.getElementById('rut_ruta').value.trim();
    const descripcion = document.getElementById('rut_descripcion').value.trim();

    if (!aplicacion || !ruta || !descripcion) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe completar todos los campos obligatorios",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    if (aplicacion.length > 50) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de validación",
            text: "La aplicación no puede exceder 50 caracteres",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    if (ruta.length > 100) {
        Swal.fire({
            position: "center",
            icon: "error", 
            title: "Error de validación",
            text: "La ruta no puede exceder 100 caracteres",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    if (descripcion.length > 200) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de validación", 
            text: "La descripción no puede exceder 200 caracteres",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormRutas);

    const url = '/martinez_final_ComisionBrigada/rutas/guardarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {

        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();

        const { codigo, mensaje } = datos

        if (codigo == 1) {

            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Exito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarRutas(false);

        } else {

            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });

        }

    } catch (error) {
        console.log(error)
    }
    BtnGuardar.disabled = false;

}

const BuscarRutas = async (mostrarMensaje = false) => {

    const url = '/martinez_final_ComisionBrigada/rutas/buscarAPI';
    const config = {
        method: 'GET'
    }

    try {

        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos

        if (codigo == 1) {

            if (mostrarMensaje) {
                await Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Exito",
                    text: `Se cargaron ${data.length} ruta(s) correctamente`,
                    showConfirmButton: true,
                    timer: 2000
                });
            }

            datatable.clear().draw();
            datatable.rows.add(data).draw();

        } else {

            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.log(error)
    }
}

const datatable = new DataTable('#TableRutas', {
    dom: `
        <"row mt-3 justify-content-between" 
            <"col" l> 
            <"col" B> 
            <"col-3" f>
        >
        t
        <"row mt-3 justify-content-between" 
            <"col-md-3 d-flex align-items-center" i> 
            <"col-md-8 d-flex justify-content-end" p>
        >
    `,
    language: lenguaje,
    data: [],
    columns: [
        {
            title: 'No.',
            data: 'rut_id',
            width: '%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Aplicación', data: 'rut_aplicacion' },
        { title: 'Ruta', data: 'rut_ruta' },
        { title: 'Descripción', data: 'rut_descripcion' },
        {
            title: 'Acciones',
            data: 'rut_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-aplicacion="${row.rut_aplicacion}"  
                         data-ruta="${row.rut_ruta}"  
                         data-descripcion="${row.rut_descripcion}">   
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

const llenarFormulario = (event) => {

    const datos = event.currentTarget.dataset

    document.getElementById('rut_id').value = datos.id
    document.getElementById('rut_aplicacion').value = datos.aplicacion
    document.getElementById('rut_ruta').value = datos.ruta
    document.getElementById('rut_descripcion').value = datos.descripcion

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0
    });
}

const limpiarTodo = () => {

    FormRutas.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    
    // Limpiar las validaciones visuales
    FormRutas.querySelectorAll('.form-control, .form-select').forEach(element => {
        element.classList.remove('is-valid', 'is-invalid');
        element.title = '';
    });
}

const ModificarRuta = async (event) => {

    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormRutas, [''])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe de validar todos los campos",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormRutas);

    const url = '/martinez_final_ComisionBrigada/rutas/modificarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {

        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos

        if (codigo == 1) {

            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Exito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarRutas(true);

        } else {

            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });

        }

    } catch (error) {
        console.log(error)
    }
    BtnModificar.disabled = false;

}

const EliminarRutas = async (e) => {

    const idRuta = e.currentTarget.dataset.id

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "info",
        title: "¿Desea ejecutar esta acción?",
        text: 'Esta completamente seguro que desea eliminar este registro',
        showConfirmButton: true,
        confirmButtonText: 'Si, Eliminar',
        confirmButtonColor: 'red',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {

        const url = `/martinez_final_ComisionBrigada/rutas/eliminarAPI?id=${idRuta}`;
        const config = {
            method: 'GET'
        }

        try {

            const consulta = await fetch(url, config);
            const respuesta = await consulta.json();
            const { codigo, mensaje } = respuesta;

            if (codigo == 1) {

                await Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Exito",
                    text: mensaje,
                    showConfirmButton: true,
                });
                
                BuscarRutas(true);
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
            console.log(error)
        }

    }
}


BuscarRutas(); 
datatable.on('click', '.eliminar', EliminarRutas);
datatable.on('click', '.modificar', llenarFormulario);
FormRutas.addEventListener('submit', GuardarRuta);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarRuta);
BtnMostrarRegistros.addEventListener('click', MostrarRegistros);