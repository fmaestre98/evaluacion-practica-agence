<div>
@if($showComponent) 
    <div id="pie_chart_container"></div>

    <script>
        var data = JSON.parse('<?php echo json_encode($data) ?>');
        var subtitle = '<?php echo $start . " a " . $end ?>';

        const pieChart = Highcharts.chart('pie_chart_container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                with: null,
                height: null,
            },
            title: {
                text: 'Percent Receita Liquida',
                align: 'center'
            },
            subtitle: {
                text: subtitle,
                align: 'center'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
                outside: true
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Percent',
                colorByPoint: true,
                data: data
            }],
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: [
                            'viewFullscreen', 'separator', 'downloadPNG',
                            'downloadSVG', 'downloadPDF', 'separator', 'downloadXLS'
                        ]
                    },
                },
                enabled: true,
            },
            navigation: {
                buttonOptions: {
                    align: 'right',
                    verticalAlign: 'top',
                    y: 0
                }
            },
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        chart: {
                            height: 300
                        },
                        title: {
                            text: 'Percent Receita Liquida',
                            align: 'center',
                            style: {
                                fontSize: '14px' // cambia el tamaño del título a 24px
                            }
                        },
                        subtitle: {
                            text: subtitle,
                            align: 'center',
                            style: {
                                fontSize: '9px' // cambia el tamaño del título a 24px
                            }
                        },
                        navigator: {
                            enabled: false
                        }
                    }
                }]
            }
        });
    </script>
    @endif
</div>