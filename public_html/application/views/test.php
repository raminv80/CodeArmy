<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>iNettuts - Welcome!</title>
        
        <link href="inettuts.css" rel="stylesheet" type="text/css" />
</head>
<body>

    <div id="columns">
        
        <ul id="column1" class="column">
            <li class="widget color-green" id="intro">
                <div class="widget-head">
                    <h3>Open</h3>
                </div>
                <div class="widget-content">
                
			<table id="myTable" cellpadding="0" cellpadding="0" class="listing" width="100%">
			<tr>
				<th class="" width="5%">Priority</th>
				<th class="" width="50%">Title</th>
				<th class="" width="10%">Points</th>
				<th class="" width="15%">Cost RM</th>
			</tr>
			
			<tr class='item'>
				<td>10</td>
				<td>This is my story 2</td>
				<td>100 Points</td>
				<td>RM 300</td>
			</tr>
			
			<tr class='details'>
				<td colspan="8">
					<div class="test">
						<p>kjash dlkj sahdl kajsh dlkajh,zxmnckj kdsjhfklsjdhf lkjhslkjfh lkjshdkl jhksjdhfklsjdh kjsdhklfdj hks jdhdksjfhskl jhskdjfhkjdshf lkjhdsklj</p><br />
						<a href="/story/<?php echo $work_list_progress[$i]['work_id'] ?>">More details</a>
						
						<a href="/story/bid/<?php echo $work_list_progress[$i]['work_id'] ?>">Bid for this story</a>
						<?php endif; ?>
					</div>
				</td>
			</tr>
				
			<?php endfor; ?>	
</table>
                    
                    
                    
                </div>
            </li>
            <li class="widget color-red">  
                <div class="widget-head">
                    <h3>In progress</h3>
                </div>
                <div class="widget-content">
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam magna sem, fringilla in, commodo a, rutrum ut, massa. Donec id nibh eu dui auctor tempor. Morbi laoreet eleifend dolor. Suspendisse pede odio, accumsan vitae, auctor non, suscipit at, ipsum. Cras varius sapien vel lectus.</p>
                </div>
            </li>
            <li class="widget color-yellow">  
                <div class="widget-head">
                    <h3>Done</h3>
                </div>
                <div class="widget-content">
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam magna sem, fringilla in, commodo a, rutrum ut, massa. Donec id nibh eu dui auctor tempor. Morbi laoreet eleifend dolor. Suspendisse pede odio, accumsan vitae, auctor non, suscipit at, ipsum. Cras varius sapien vel lectus.</p>
                </div>
            </li>
            <li class="widget color-blue">  
                <div class="widget-head">
                    <h3>Paid</h3>
                </div>
                <div class="widget-content">
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam magna sem, fringilla in, commodo a, rutrum ut, massa. Donec id nibh eu dui auctor tempor. Morbi laoreet eleifend dolor. Suspendisse pede odio, accumsan vitae, auctor non, suscipit at, ipsum. Cras varius sapien vel lectus.</p>
                </div>
            </li>
            
        </ul>
        
    </div>
    
    

</body>
</html>