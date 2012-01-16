<?php $this->load->view('includes/header4'); ?>
<!-- your html code here -->
<section id="user-stories" class="user-stories"><br><br>
  <div class="WP-main">
  
  
    <?php if($featherlight||$lightweight||$heavyweight){?>
    <div id="slideshow">
      <span class="control" id="leftControl" style="display: block; ">Clicking moves left</span>
      <div id="slidesContainer" style="overflow-x: hidden; overflow-y: hidden; ">
        <div id="slideInner" style="width: 2240px; margin-left: -1680px; ">
          <?php if($featherlight){?>
          <div class="slide" style="float: left; width: 860px; "> <span id="slidetitle">FeatherLight Weight Tasks</span>
            <table width="860">
              <tr>
              	<?php foreach($featherlight as $task):?>
                <td width="36%"><h3 id="h3slide">RM <?=$task['cost']?></h3>
                  <br />
                  <p id="contentslide"><a href="/story/<?=$task['work_id'];?>"><?=$task['project']?> --> <?=$task['title']?>
                    BID Deadline: <?=date('d M Y',strtotime($task['bid_deadline']))?></a></p>
                </td>
                <?php endforeach;?>
              </tr>
            </table>
          </div>
          <?php }?>
          <?php if($lightweight){?>
          <div class="slide" style="float: left; width: 860px; "> <span id="slidetitle">Lightweight Weight Tasks</span>
            <table width="860">
              <tr>
              	<?php foreach($lightweight as $task):?>
                <td width="36%"><h3 id="h3slide">RM <?=$task['cost']?></h3>
                  <br />
                  <p id="contentslide"><a href="/story/<?=$task['work_id'];?>"><?=$task['project']?> --> <?=$task['title']?><br />
                    BID Deadline: <?=date('d M Y',strtotime($task['bid_deadline']))?></a></p>
                </td>
                <?php endforeach;?>
              </tr>
            </table>
          </div>
          <?php }?>
          <?php if($heavyweight){?>
          <div class="slide" style="float: left; width: 860px; "> <span id="slidetitle">Heavy Weight Tasks</span>
            <table width="860">
              <tr>
                <?php foreach($heavyweight as $task):?>
              	<td width="36%"><h3 id="h3slide">RM 1200</h3>
                  <br />
                  <p id="contentslide"><a href="/story/<?=$task['work_id'];?>"><?=$task['project']?> --> <?=$task['title']?><br />
                    BID Deadline: <?=date('d M Y',strtotime($task['bid_deadline']))?></a></p>
                </td>
                <?php endforeach;?>
              </tr>
            </table>
          </div>
          <?php }?>
        </div>
      </div>
      <span class="control" id="rightControl" style="display: none; ">Clicking moves right</span>
    </div>
    <?php }?>
    <span id="title">Search Contracts</span>
    <div class="WP-searchbar">
      <?php echo form_open('/stories/browse' , array('class'=>'search-form', 'name' => "browse-tools-form")); ?>
      <label>Search task</label>
      <input class="hint_step1" id="input-search" type="text" name="search">
      <input id="search-button" name="Submit" type="button">
      <?php echo form_close(); ?>
    </div>
    <div class="WP-contract-placeholder">
      <div id="heading"><span id="title">Deadline</span><span style="width:620px;" id="title"><a href="/stories/browse/userstory">user stories</a></span> <span style="width:100px;" id="title"><a href="/stories/browse/bids">bids</a></span> <span style="width:80px;" id="title"><a href="/stories/browse/prize">prize</a></span></div>
      <?php if($stories){foreach($stories as $i=>$story):?>
      <div class="story">
          <div class="accordionButton">
            <table class="us_accordion">
              <tr>
                <?php if($story['bid_deadline']){?>
                <td width="130px"><div id="day_date"><?=date('d',strtotime($story['bid_deadline']))?></div>
                  <p><?=date('M Y',strtotime($story['bid_deadline']))?></p></td>
                <?php }else{?>
                <td width="130px"><div id="day_date">&nbsp;</div>
                  <p>&nbsp;</p></td>            
                <?php }?>
                <td width="650px"><?=$story['project_name']?> -> <?=$story['title']?></td>
                <td width="90px"><?=$story['bids']?></td>
                <td class="hint_dev_step2">RM<?=$story['cost']?>
                <!-- BID indicator -->
                <?= in_array($story['work_id'],$my_bids)?'<img src="/public/images/bid_indicator.png" class="bid_indicator">':'' ?>
              	</td>
              </tr>
            </table>
          </div>
          <div class="accordionContent" style="display: none; ">
            <table class="accordion-table">
              <tr>
                <td style="border:0;" width="390px">Summary<br />
                  <br />
                  <?=substr(strip_tags($story['description']),0,255).'...'?></td>
                <td style="border:0;" ><table id="us-content">
                    <tr>
                      <td width="80%">Category</td>
                      <td><?=$story['category_name']?></td>
                    </tr>
                    <tr>
                      <td width="80%">Comments</td>
                      <td><?=$story['comments']?></td>
                    </tr>
                    <tr>
                      <td width="80%">Points</td>
                      <td><?=$story['points']?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <div class="bid-more"><a href="/story/<?=$story['work_id']?>">Bid & More</a></div>
          </div>
      </div>
      <?php endforeach;}else{?>
      	<div class="empty-search-res">
        	Oopse!There's nothing to do <?php if(isset($_POST['type'])&&$_POST['type']!='0'){?>under '<?=$_POST['type']?>' user stories<?php }?>
            to match your search criteria.
        </div>
      <?php }?>
      <br />
      &nbsp; </div>
  </div>
</section>
<div id="push-down">&nbsp;</div>
<script type="text/javascript">
	$('.accordionButton').click(function(){
		$(this).next('.accordionContent').slideToggle();
	});
	$('header').localScroll();
	var currentPage=0;
	$('#page'+currentPage).show();
	page_numbers="<ul class='wp-pagination'>";
	for(i=1;i<=Math.min(5, lastPage+1);i++){
		page_numbers+="<li class='wp-page-num' id='wp-page-num-"+i+"'><a href='javascript:goto_page("+(i-1)+");'>"+i+"</a></li>";
	}
	page_numbers+="</ul>";
	$('.page').append("<div class='wp-pagination'><div class='wp-previous-page'><a href='javascript: void(0);' class='pre-page'>&lt; Previous Page</a></div><div class='wp-page-numbers'>"+page_numbers+"</div><div class='wp-next-page'><a href='javascript: void(0);' class='nxt-page'>Next Page &gt;</a></div></div>");
	//$('.page').prepend("<div class='wp-previous-page'><a href='javascript: void(0);' class='pre-page'>&lt; Previous Page</a></div>");
	managePagination(currentPage);
	function managePagination(currentPage){
		if(currentPage==0)$('.pre-page','#page'+currentPage).hide(); else $('.wp-previous-page','#page'+currentPage).show();
		if(currentPage==lastPage)$('.nxt-page','#page'+currentPage).hide(); else $('.wp-next-page','#page'+currentPage).show();
		page_numbers="<ul class='wp-pagination'>";
		for(i=Math.max(1,Math.min(lastPage-5,currentPage-1));i<=Math.min(lastPage+1, Math.max(5,currentPage+3));i++){
			page_numbers+="<li class='wp-page-num' id='wp-page-num-"+i+"'><a href='javascript:goto_page("+(i-1)+");'>"+i+"</a></li>";
		}
		page_numbers+="</ul>";
		$('.wp-page-numbers').html(page_numbers);
		$('.wp-page-num').removeClass('active');
		$('#wp-page-num-'+(currentPage+1)).addClass('active');
	}
	$('.nxt-page').click(function(){
			$('#page'+currentPage).slideUp();
			currentPage++;
			managePagination(currentPage);
			if(currentPage>lastPage)currentPage=0;
			$('#page'+currentPage).slideDown();
		});
	$('.pre-page').click(function(){
			$('#page'+currentPage).slideUp();
			currentPage--;
			managePagination(currentPage);
			if(currentPage<0)currentPage=lastPage;
			$('#page'+currentPage).slideDown();
		});
	function goto_page(i){
		$('#page'+currentPage).slideUp();
		currentPage=i;
		managePagination(currentPage);
		if(currentPage<0)currentPage=lastPage;
		$('#page'+currentPage).slideDown();
	}
</script>
<?php $this->load->view('includes/footer4'); ?>