<script type="text/javascript" src="<?php echo base_url(); ?>js/highcharts.js"></script>
<div id="chartcontainer">This is just a replacement in case Javascript is not
    available or used for SEO purposes</div>

<script>
    var chart;
        $(document).ready(function() {

            // define the options
            var options = {
                chart: {
                    renderTo: 'chartcontainer'
                },
                title: {
                    text: 'Test Chart'
                },
                subtitle: {
                    text: 'Source: Confidential'
                },
                xAxis: {
                    type: 'datetime',
                    tickInterval: 24 * 3600 * 1000, // one week
                    tickWidth: 0,
                    gridLineWidth: 1,
                    labels: {
                        align: 'left',
                        x: 3,
                        y: -3
                    }
                },
                yAxis: [{ // left y axis
                    title: {
                        text: null
                    },
                    labels: {
                        align: 'left',
                        x: 3,
                        y: 16,
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0);
                        }
                    },
                    showFirstLabel: false
                }, { // right y axis
                    linkedTo: 0,
                    gridLineWidth: 0,
                    opposite: true,
                    title: {
                        text: null
                    },
                    labels: {
                        align: 'right',
                        x: -3,
                        y: 16,
                        formatter: function() {
                            return Highcharts.numberFormat(this.value, 0);
                        }
                    },
                    showFirstLabel: false
                }],
                legend: {
                    align: 'left',
                    verticalAlign: 'top',
                    y: 20,
                    floating: true,
                    borderWidth: 0
                },
                tooltip: {
                    shared: true,
                    crosshairs: true
                },
                series: [{
                    name: 'Test Value',
                    lineWidth: 4,
                    marker: {
                        radius: 4
                    }
                }]
            };

            options.series[0].data = [
                [1224043200000,3],
                [1224143300000,1],
                [1224243400000,2],
                [1224343500000,5],
                [1224443600000,6],
                [1224543700000,7],
                [1224643800000,3],
                [1224743900000,1],
                [1224844000000,3],
                [1224945300000,1],
                [1225046400000,2],
                [1225147500000,5],
                [1225248600000,6],
                [1225349700000,7],
                [1225453800000,3]
            ];

            chart = new Highcharts.Chart(options);

        });
</script>