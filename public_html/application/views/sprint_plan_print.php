<?php 
header('Content-type: text/csv');
header('Content-disposition: attachment;filename=MyVerySpecial.csv');
$i=0; 
foreach($works as $sprint=>$work_list): 
$i++;?>
Sprint <?=$i?>,From,<?=$work_list['from']?>,to,<?=$work_list['to']?>,Points:,<?=$work_list['point']?>
,Work List:,,,,,
,No:,Title:,Points,Status,,
<?php $j=0;foreach($work_list['list'] as $j=>$work):?>
,#<?=$j?>,<?= $work['title']?>,<?= $work['points']?>,<?= $work['status']?>,,
<?php endforeach;?>
,,,,,,
<?php endforeach;?>