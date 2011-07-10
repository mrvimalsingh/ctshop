<script type="text/javascript" src="<?=base_url();?>js/jscharts.js"></script>
<div id="chartcontainer">This is just a replacement in case Javascript is not
    available or used for SEO purposes</div>

<script>
    var myData = new Array([10, 20], [15, 10], [20, 30], [25, 10], [30, 5]);
    var myChart = new JSChart('chartcontainer', 'line');
    myChart.setDataArray(myData);
    myChart.draw();
</script>