<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Total de categorias</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">{{ $total_categorias ?? 0 }}</h6>

                    </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Total de productos</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">{{ $total_productos ?? 0 }}</h6>

                    </div>
                    </div>
                </div>
                  <div class="col-4">
                    <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Total de ventas</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">{{ $total_ventas ?? 0 }}</h6>

                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

                    <div id="chart" class="mt-4"></div>

                    <script>
                          var options = {
                                series: [{
                                name: 'Inflation',
                                data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]
                                }],
                                chart: {
                                height: 350,
                                type: 'bar',
                                },
                                plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    dataLabels: {
                                    position: 'top', // top, center, bottom
                                    },
                                }
                                },
                                dataLabels: {
                                enabled: true,
                                formatter: function (val) {
                                    return val + "%";
                                },
                                offsetY: -20,
                                style: {
                                    fontSize: '12px',
                                    colors: ["#304758"]
                                }
                                },

                                xaxis: {
                                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                                position: 'top',
                                axisBorder: {
                                    show: false
                                },
                                axisTicks: {
                                    show: false
                                },
                                crosshairs: {
                                    fill: {
                                    type: 'gradient',
                                    gradient: {
                                        colorFrom: '#D8E3F0',
                                        colorTo: '#BED1E6',
                                        stops: [0, 100],
                                        opacityFrom: 0.4,
                                        opacityTo: 0.5,
                                    }
                                    }
                                },
                                tooltip: {
                                    enabled: true,
                                }
                                },
                                yaxis: {
                                axisBorder: {
                                    show: false
                                },
                                axisTicks: {
                                    show: false,
                                },
                                labels: {
                                    show: false,
                                    formatter: function (val) {
                                    return val + "%";
                                    }
                                }

                                },
                                title: {
                                text: 'Monthly Inflation in Argentina, 2002',
                                floating: true,
                                offsetY: 330,
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
</x-app-layout>
