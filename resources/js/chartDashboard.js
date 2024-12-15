import { Chart, registerables } from "chart.js";
Chart.register(...registerables);

/**
 * Función para crear un gráfico
 * @param {string} chartId - El ID del elemento canvas donde se dibujará el gráfico.
 * @param {string} dataUrl - La URL para obtener los datos del gráfico.
 * @param {string[]} labels - Las etiquetas para el eje X del gráfico.
 * @param {string} datasetLabel - La etiqueta para el dataset.
 */
const DEFAULT_SELECTED_DAYS = [
    "Lunes",
    "Martes",
    "Miércoles",
    "Jueves",
    "Viernes",
    "Sábado",
    "Dom",
];

async function createBarChart(
    chartId,
    dataUrl,
    labels,
    datasetLabel,
    dataSelector
) {

    const chartValues = document.getElementById(chartId);

    const chartAt = JSON.parse(chartValues.dataset.values);
    const month = chartAt[0];
    const year = chartAt[1];
    var ctx = chartValues.getContext("2d");    
    let chartData = [0, 0, 0, 0, 0, 0, 0];
    try {
        const response = await fetch(`${dataUrl}?month=${month}&year=${year}`, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });
        const data = await response.json();
        chartData = data; 
    } catch (error) {
        console.log("FATAL ERROR API");
    }
    let selectedDays = 30; 

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
function createPieChart(TitleText, PieChartID, LabelsValues) {
    const canvas = document.getElementById(PieChartID);

    const values = JSON.parse(canvas.dataset.values);

    var ctx = canvas.getContext("2d");
    const myPieChart = new Chart(ctx, {
        type: "pie",
        data: {
            labels: LabelsValues,
            datasets: [
                {
                    label: "Valor",
                    data: values,
                    backgroundColor: [
                        "rgb(255, 99, 132)",
                        "rgb(54, 162, 235)",
                        "rgb(255, 205, 86)",
                    ],
                    hoverOffset: 4,
                },
            ],
        },
        options: {
            responsive: false,
            plugins: {
                title: {
                    display: true,
                    text: TitleText,
                    font: {
                        size: 24,
                        weight: "bold",
                    },
                    padding: {
                        top: 20,
                        bottom: 20,
                    },
                },
                aspectRatio: 1,
                legend: {
                    position: "top",
                    labels: {
                        generateLabels: function (chart) {
                            const data = chart.data;
                            return data.labels.map((label, index) => {
                                const value = data.datasets[0].data[index];
                                return {
                                    text: `${label}: ${value}`,
                                    fillStyle:
                                        data.datasets[0].backgroundColor[index],
                                };
                            });
                        },
                        font: {
                            size: 20,
                        },
                    },
                },
                tooltip: {
                    bodyFont: {
                        size: 19,
                    },
                },
            },
        },
    });
}
document.addEventListener("DOMContentLoaded", function () {
    createBarChart(
        "myChart",
        "/api/metrics",
        DEFAULT_SELECTED_DAYS,
        "Órdenes Terminadas",
        "dayRange-1"
    );
    createPieChart("PORCENTAJE DE ORDENES CREADAS Y FINALIZADAS", "PieChart1", [
        "Creadas",
        "Finalizadas",
    ]);
    createPieChart("PORCENTAJE ORDENES M/S y FALLAS", "PieChart2", [
        "M/S",
        "FALLAS",
    ]);
});


// mensaje de error si no consigue ninguna orden en el mes
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        const element = document.querySelector(".bg-green-100");
        if (element) {
            element.remove();
        }
    }, 3000);
});
