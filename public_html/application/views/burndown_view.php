<?php $this->load->view('includes/header4'); ?>
<?php if($sprint_sel==0){?>

<section id="sprints" style="margin: 70px;">
  <div id="wrapper">
    <ul>
      <?php foreach($sprints as $i=>$sprint):?>
      <li><a href="/project/burndown_chart/<?=$project_sel?>/<?=$sprint['id']?>">Sprint
        <?=$i?>
        </a></li>
      <?php endforeach;?>
    </ul>
  </div>
</section>
<?php 
	}else{
		//find srint number
		foreach($sprints as $i=>$sprint)if($sprint['id']==$sprint_sel)break;
		$sprint_num=$i;
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', 'Burned Points');
        data.addColumn('number', 'Expected Burndown');
		startTime = new Date(<?=($cur_sprint['start'])? strtotime($cur_sprint['start']):time()?>*1000);
		endTime = new Date(<?=($cur_sprint['end'])? strtotime($cur_sprint['end']):time()?>*1000);
		var chart = new Array();
		chart.push([startTime, <?=$sprint_points?>,<?=$sprint_points?>]);
		<?php foreach($chart as $data):?>
		d = new Date(<?=strtotime($data['day'])*1000?>);
		if(d!=endTime)
			chart.push([d, <?=$data['points']?>, null]);
		<?php endforeach;?>
		<?php if(count($chart)>0){?>
		chart.push([endTime, <?=$data['points']?>,0]);
		<?php }else{?>
		chart.push([endTime, null,0]);
		<?php }?>
        data.addRows(chart);
        var options = {
          width: 800, height: 420,
          title: 'Sprint <?=$sprint_num+1?>',
		  strictFirstColumnType: true,
		  pointSize: 5,
		  interpolateNulls:true,
		  backgroundColor: '#ffffff',
		  hAxis: {title: 'Date', format: 'dMMMyy', gridlines: {count:5}, minValue: startTime, maxValue: endTime},
        };
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
<section id="chart" style="margin: 70px;">
  <div id="wrapper">
    <div id="chart_div" style="margin:0 auto; width:800px"></div>
  </div>
</section>
<?php }?>
<?php $this->load->view('includes/footer4'); ?>
