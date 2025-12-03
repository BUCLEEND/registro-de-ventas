<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">

                <!-- TARJETA: Total Categorías -->
                <div class="col-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Total de categorías</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">
                                {{ $total_categorias ?? 0 }}
                            </h6>
                        </div>
                    </div>
                </div>

                <!-- TARJETA: Total Productos -->
                <div class="col-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Total de productos</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">
                                {{ $total_productos ?? 0 }}
                            </h6>
                        </div>
                    </div>
                </div>

                <!-- TARJETA: Total Ventas -->
                <div class="col-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Total de ventas</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">
                                {{ $total_ventas ?? 0 }}
                            </h6>
                        </div>
                    </div>
                </div>

            </div>


            <!-- ==========================
                 GRÁFICA DE VENTAS POR MES
            =========================== -->
            <div class="row mt-5">
                <div class="col-12">

                    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

                    <div id="chart" class="mt-4"></div>

                    <script>
                        var options = {
                            series: [{
                                name: 'Ventas S/',
                                data: @json($totales)
                            }],
                            chart: {
                                height: 350,
                                type: 'bar',
                            },
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    dataLabels: {
                                        position: 'top'
                                    }
                                }
                            },
                            dataLabels: {
                                enabled: true,
                                formatter: function (val) {
                                    return "S/ " + val;
                                },
                                offsetY: -20,
                                style: {
                                    fontSize: '12px',
                                    colors: ["#304758"]
                                }
                            },
                            xaxis: {
                                categories: @json($meses),
                                position: 'top',
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
                                        return "S/ " + val;
                                    }
                                }
                            },
                            title: {
                                text: 'Ventas Mensuales',
                                align: 'center',
                                style: {
                                    color: '#444'
                                }
                            }
                        };

                        var chart = new ApexCharts(document.querySelector("#chart"), options);
                        chart.render();
                    </script>

                </div>
            </div>

        </div>
    </div>
    <div class="py-12">
        <div class="container">
            <div class="row">
            <!-- ==========================
                 GRÁFICA DE VENTAS POR MES
            =========================== -->
            <div class="row mt-5">
                <div class="col-12">

                    <div id="graficoProductos" class="mt-5"></div>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {

                            var opcionesProductos = {
                                series: [{
                                    name: "Cantidad vendida",
                                    data: @json($totalesProductos)
                                }],
                                chart: {
                                    type: 'bar',
                                    height: 350
                                },
                                plotOptions: {
                                    bar: {
                                        distributed: true,
                                    }
                                },
                                dataLabels: {
                                    enabled: true
                                },
                                xaxis: {
                                    categories: @json($nombresProductos),
                                },
                                title: {
                                    text: 'Productos más vendidos',
                                    align: 'center'
                                }
                            };

                            var graficoProductos = new ApexCharts(
                                document.querySelector("#graficoProductos"),
                                opcionesProductos
                            );

                            graficoProductos.render();
                        });
                    </script>


                </div>
            </div>

        </div>
    </div>

</x-app-layout>
