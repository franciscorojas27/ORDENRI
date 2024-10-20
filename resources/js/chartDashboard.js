import { Chart, registerables } from "chart.js";
Chart.register(...registerables);

/**
 * Función para crear un gráfico
 * @param {string} chartId - El ID del elemento canvas donde se dibujará el gráfico.
 * @param {string} dataUrl - La URL para obtener los datos del gráfico.
 * @param {string[]} labels - Las etiquetas para el eje X del gráfico.
 * @param {string} datasetLabel - La etiqueta para el dataset.
 */
async function createChart(chartId, dataUrl, labels, datasetLabel,dataSelector) {
    const ctx = document.getElementById(chartId).getContext("2d");
    let chartData = [0, 0, 0, 0, 0, 0, 0]; // Cambiar según el tamaño de tus datos

    try {
        const response = await fetch(dataUrl, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });
        const data = await response.json();
        chartData = data[0]; // Asegúrate de que el formato de datos sea correcto
    } catch (error) {
        console.log("No se pudo obtener los datos de la API");
    }

    let selectedDays = 30; // Valor inicial para el rango de días

    const myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: datasetLabel,
                    data: chartData[selectedDays],
                    backgroundColor: "rgba(54, 162, 235, 0.2)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 2,
                    fill: false,
                    pointBackgroundColor: "rgba(54, 162, 235, 1)",
                    pointRadius: 5,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
    document
        .getElementById(dataSelector)
        .addEventListener("change", function (event) {
            selectedDays = parseInt(event.target.value);

            // Actualiza los datos del gráfico
            myChart.data.datasets[0].data = chartData[selectedDays];
            myChart.update();
        });
}

document.addEventListener("DOMContentLoaded", function () {
    createChart("myChart", document.getElementById("myChart").getAttribute("data-url"), 
                ["Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"], 
                "Órdenes Terminadas","dayRange-1");
    
    createChart("myChart2", document.getElementById("myChart2").getAttribute("data-url"), 
                ["Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"], 
                "Órdenes Pendientes","dayRange-2");
});