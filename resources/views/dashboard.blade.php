<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">

            <!-- TARJETAS DE RESUMEN -->
            <div class="row g-4 mb-5">
                <!-- TARJETA: Total Categorías -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Total de categorías</h6>
                                    <h2 class="mb-0 fw-bold">{{ $total_categorias ?? 0 }}</h2>
                                </div>
                                <div class="bg-primary bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-folder text-primary fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TARJETA: Total Productos -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Total de productos</h6>
                                    <h2 class="mb-0 fw-bold">{{ $total_productos ?? 0 }}</h2>
                                </div>
                                <div class="bg-success bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-box-seam text-success fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TARJETA: Total Ventas -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Total de ventas</h6>
                                    <h2 class="mb-0 fw-bold">{{ $total_ventas ?? 0 }}</h2>
                                </div>
                                <div class="bg-warning bg-opacity-10 p-3 rounded">
                                    <i class="bi bi-cart-check text-warning fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GRÁFICAS -->
            <div class="row g-4">

                <!-- GRÁFICA DE VENTAS MENSUALES -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Ventas Mensuales</h5>
                            <div id="chart"></div>
                        </div>
                    </div>
                </div>

                <!-- GRÁFICA DE PARTICIPACIÓN (DOUGHNUT) -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Participación por Producto</h5>
                            <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                                <canvas id="chartParticipacion"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GRÁFICA DE PRODUCTOS MÁS VENDIDOS -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Productos Más Vendidos</h5>
                            <div id="graficoProductos"></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // GRÁFICA DE VENTAS MENSUALES (ApexCharts)
        var options = {
            series: [{
                name: 'Ventas S/',
                data: @json($totales)
            }],
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    dataLabels: {
                        position: 'top'
                    },
                    columnWidth: '60%'
                }
            },
            colors: ['#0d6efd'],
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return "S/ " + val.toFixed(2);
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            xaxis: {
                categories: @json($meses),
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return "S/ " + val.toFixed(0);
                    }
                }
            },
            grid: {
                borderColor: '#f1f1f1',
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>

    <script>
        // GRÁFICA DE PRODUCTOS MÁS VENDIDOS (ApexCharts)
        document.addEventListener("DOMContentLoaded", () => {
            var opcionesProductos = {
                series: [{
                    name: "Cantidad vendida",
                    data: @json($totalesProductos)
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        distributed: true,
                        horizontal: false,
                        borderRadius: 8,
                        columnWidth: '50%'
                    }
                },
                dataLabels: {
                    enabled: true
                },
                xaxis: {
                    categories: @json($nombresProductos),
                },
                legend: {
                    show: false
                },
                grid: {
                    borderColor: '#f1f1f1',
                }
            };

            var graficoProductos = new ApexCharts(
                document.querySelector("#graficoProductos"),
                opcionesProductos
            );

            graficoProductos.render();
        });
    </script>

    <script>
        // GRÁFICA DE PARTICIPACIÓN (Chart.js - Doughnut)
        const ctx = document.getElementById('chartParticipacion');
        const dataLabels = @json($participacion->pluck('producto'));
        const dataValues = @json($participacion->pluck('total'));

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: dataLabels,
                datasets: [{
                    data: dataValues,
                    backgroundColor: [
                        '#0d6efd',
                        '#198754',
                        '#ffc107',
                        '#dc3545',
                        '#0dcaf0',
                        '#6f42c1',
                        '#fd7e14',
                        '#20c997'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed + ' unidades';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>

</x-app-layout>
