<div id="bar_chart_container">

</div>

<script type="text/javascript">
    var subtitle = '<?php echo $start . " a " . $end ?>';
    var data = JSON.parse('<?php echo json_encode($data) ?>');
    var categories = JSON.parse('<?php echo json_encode($categories) ?>');
    var marker = {
        lineWidth: 2,
        lineColor: Highcharts.getOptions().colors[3],
        fillColor: 'white'
    };
    var spline={
        type: 'spline',
        name: 'Custo Fixo Medio',
        data: JSON.parse('<?php echo json_encode($custoFixoData) ?>'),
        marker:marker
    };
    data.push(spline);
    console.log(data);

    Highcharts.chart('bar_chart_container', {
        chart: {
            type: 'column'
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
            title: {
                text: 'R$'
            }
        },
        tooltip: {
            valueSuffix: ''
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: data
    });
</script>