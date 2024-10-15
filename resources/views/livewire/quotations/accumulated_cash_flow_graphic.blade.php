<div>
    <canvas id="accumulatedCashFlow" style="height: 300px; width: 300px;"></canvas>
</div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Datos de flujo de caja acumulado (estos datos son dinámicos y vienen desde el backend)
    const accumulatedCashFlow = @json($accumulatedCashFlow); // Convertir PHP a JavaScript

    const ctx = document.getElementById('accumulatedCashFlow');

    // Generar etiquetas para los años (del 1 al 25)
    const labels = Array.from({length: accumulatedCashFlow.length}, (_, i) => `Año ${i + 1}`);

    // Crear la gráfica usando Chart.js
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Flujo de Caja Acumulado',
                data: accumulatedCashFlow,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    beginAtZero: true, // Asegura que la gráfica comience en la primera etiqueta
                    ticks: {
                        autoSkip: true, // Evitar saltar etiquetas
                    }
                },
                y: {
                    beginAtZero: false, // Empieza desde 0 en el eje Y
                    ticks: {
                        // Configuración para mostrar las etiquetas de los valores
                        callback: function(value) {
                            return value; // Retorna el valor como etiqueta
                        },
                        stepSize: 50000 // Cambia esto según el rango de tus valores
                    }
                }
            },
            animation: true,
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    enabled: true
                }
            },
            responsive: true,
            maintainAspectRatio: false // Permite que la gráfica se ajuste mejor al contenedor
        }
    });
</script>

