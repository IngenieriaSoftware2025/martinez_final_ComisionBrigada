import Swal from "sweetalert2";
import Chart from 'chart.js/auto';

const grafico1 = document.getElementById('grafico1').getContext('2d');
const grafico2 = document.getElementById('grafico2').getContext('2d');
const grafico3 = document.getElementById('grafico3').getContext('2d');
const grafico4 = document.getElementById('grafico4').getContext('2d');
const grafico5 = document.getElementById('grafico5').getContext('2d');

// GRÁFICA 1 
window.graficaComisionesFecha = new Chart(grafico1, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: 'Comisiones por Fecha',
            data: [],
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// GRÁFICA 2 
window.graficaComisionesFechaPie = new Chart(grafico2, {
    type: 'pie',
    data: {
        labels: [],
        datasets: [{
            data: [],
            backgroundColor: [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
                '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
            ]
        }]
    },
    options: {
        responsive: true
    }
});

// GRÁFICA 3 
window.graficaInformatica = new Chart(grafico3, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: 'Comisiones Informática',
            data: [],
            backgroundColor: 'rgba(75, 192, 192, 0.8)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// GRÁFICA 4 
window.graficaInformaticaPie = new Chart(grafico4, {
    type: 'pie',
    data: {
        labels: [],
        datasets: [{
            data: [],
            backgroundColor: [
                '#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0',
                '#9966FF', '#FF9F40', '#C9CBCF', '#FF6384'
            ]
        }]
    },
    options: {
        responsive: true
    }
});

// GRÁFICA 5 
window.graficaTransmisiones = new Chart(grafico5, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: 'Comisiones Transmisiones',
            data: [],
            backgroundColor: 'rgba(255, 99, 132, 0.8)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Función para buscar comisiones por fecha
const BuscarComisionesPorFecha = async () => {
    const url = '/martinez_final_ComisionBrigada/estadistica/buscarComisionesPorFechaAPI';
    const config = { method: 'GET' };

    try {
        const respuesta = await fetch(url, config);        
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos;

        if (codigo == 1 && data.length > 0) {
            const fechas = data.map(d => d.fecha);
            const cantidades = data.map(d => parseInt(d.cantidad));


            // actualizar grafica de barras
            window.graficaComisionesFecha.data.labels = fechas;
            window.graficaComisionesFecha.data.datasets[0].data = cantidades;
            window.graficaComisionesFecha.update();

            // actualizar grafica de pie
            window.graficaComisionesFechaPie.data.labels = fechas;
            window.graficaComisionesFechaPie.data.datasets[0].data = cantidades;
            window.graficaComisionesFechaPie.update();
        }

    } catch (error) {
        console.error('Error completo:', error);
        Swal.close();
        await Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al cargar estadísticas: ' + error.message
        });
    }
};

// buscar comisiones de informatica
const BuscarComisionesInformatica = async () => {
    const url = '/martinez_final_ComisionBrigada/estadistica/buscarComisionesInformaticaAPI';
    const config = { method: 'GET' };

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        
        const { codigo, mensaje, data } = datos;

        if (codigo == 1 && data && data.length > 0) {
            const destinos = data.map(d => d.com_destino);
            const cantidades = data.map(d => parseInt(d.cantidad));

            // actualizar grafica de barras
            window.graficaInformatica.data.labels = destinos;
            window.graficaInformatica.data.datasets[0].data = cantidades;
            window.graficaInformatica.update();

            // actualizar grafica de pie
            window.graficaInformaticaPie.data.labels = destinos;
            window.graficaInformaticaPie.data.datasets[0].data = cantidades;
            window.graficaInformaticaPie.update();
        }

    } catch (error) {
        console.error('Error en Informática:', error);
    }
};

// buscar comisiones de transmisiones
const BuscarComisionesTransmisiones = async () => {
    const url = '/martinez_final_ComisionBrigada/estadistica/buscarComisionesTransmisionesAPI';
    const config = { method: 'GET' };

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos;

        if (codigo == 1 && data && data.length > 0) {
            const destinos = data.map(d => d.com_destino);
            const cantidades = data.map(d => parseInt(d.cantidad));

            // actualizar grafica
            window.graficaTransmisiones.data.labels = destinos;
            window.graficaTransmisiones.data.datasets[0].data = cantidades;
            window.graficaTransmisiones.update();
        }

    } catch (error) {
        console.error('Error en Transmisiones:', error);
    }
};

// Cargar todas las gráficas
const cargarGraficas = async () => {
    try {
        Swal.fire({
            title: 'Cargando...',
            text: 'Generando estadísticas',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        await BuscarComisionesPorFecha();
        await BuscarComisionesInformatica();
        await BuscarComisionesTransmisiones();

        Swal.close();
        
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Estadísticas cargadas",
            showConfirmButton: false,
            timer: 1500
        });
    } catch (error) {
        console.error('Error general en cargarGraficas:', error);
        Swal.close();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al cargar las estadísticas'
        });
    }
};

// Esperar a que el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, iniciando estadísticas...');
    cargarGraficas();
});

// También ejecutar inmediatamente por si acaso
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded');
} else {
    cargarGraficas();
}