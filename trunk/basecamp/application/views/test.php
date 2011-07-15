<html>
<head>
    <title>TEST Page for all sorts of stuff</title>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.2.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jsonrpc.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/highcharts.js"></script>
    <script>
        baseUri = '<?=base_url();?>';
        function chekUserLoggedIn() {
            makeJsonRpcCall('', 'check_user_logged_in', null, function (data) {
                if (data.error != null) {
                    alert(data.error.message);
                } else {
                    alert("user_id: "+data.result.user_id);
                }
            });
        }

        var chart;
        $(document).ready(function() {

            // define the options
            var options = {
                chart: {
                    renderTo: 'testChart'
                },
                title: {
                    text: 'Test Chart'
                },
                subtitle: {
                    text: 'Source: Confidential'
                },
                xAxis: {
                    type: 'datetime',
                    tickInterval: 7 * 24 * 3600 * 1000, // one week
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
                plotOptions: {
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function() {
                                    hs.htmlExpand(null, {
                                                pageOrigin: {
                                                    x: this.pageX,
                                                    y: this.pageY
                                                },
                                                headingText: this.series.name,
                                                maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) +':<br/> '+
                                                        this.y +' visits',
                                                width: 200
                                            });
                                }
                            }
                        },
                        marker: {
                            lineWidth: 1
                        }
                    }
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
                [1224043300000,1],
                [1224043400000,2],
                [1224043500000,5],
                [1224043600000,6],
                [1224043700000,7],
                [1224043800000,3],
                [1224043900000,1]
            ];

            chart = new Highcharts.Chart(options);

        });
    </script>
</head>
<body>

<div id="ajaxResult"></div>

<input type="button" value="Test" onclick="chekUserLoggedIn()" />
<div id="testChart" style="width:500px"></div>

</body>
</html>