<div>
   @if($showComponent) 
    <div id="bar_chart_container"></div>

    <script type="text/javascript">

        var subtitle = '<?php echo $start . " a " . $end ?>';
        var data = JSON.parse('<?php echo json_encode($data) ?>');
        var categories = JSON.parse('<?php echo json_encode($categories) ?>');
        var marker = {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        };
        var spline = {
            type: 'spline',
            name: 'Custo Fixo Medio',
            data: JSON.parse('<?php echo json_encode($custoFixoData) ?>'),
            marker: marker
        };
        data.push(spline);
        
        console.log(data);
        
        var options={
            chart: {
                type: 'column',
                renderTo:'bar_chart_container'
            },
            title: {
                text: 'Performance Comerce',
                align: 'center'
            },
            subtitle: {
                text: subtitle,
                align: 'center'
            },
            xAxis: {
                categories: categories,
                crosshair: true,
                accessibility: {
                    description: 'Months'
                }
            },
            yAxis: {
                min: 0,
                labels: {
                    formatter: function() {
                        return ' R$ ' + Highcharts.numberFormat(this.value, 2, ',', '.'); // cambia el formato de las etiquetas del eje Y
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    return this.series.name + '  R$ ' + Highcharts.numberFormat(this.y, 2, ',', '.');
                },
                outside: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: data,
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
                            text: 'Performance Comerce',
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
    };

      var  chart = new Highcharts.Chart(options);
     
            

  
    </script>
   @endif
</div>