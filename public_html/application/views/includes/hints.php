<!-- 
Format of hint is: 
<div id="My_CUSTOM_ID" class="hint" highlight="class1 class2 ..." exclude="clss1 clss2 ..."> ... </div>
This hint will be activated if there is a dom object within body having class hint_MY_CUSTOM_ID and it will attach itself to the selected object.
Selected object and all items with classes located in highlight attribute will be highlighted. 
All items with classed located in exclude attribute will remain enabled.
-->
<?php if($this->session->userdata('tutorial')=='1' && $this->session->userdata('user_id')>0 && floor($me['exp'] / points_per_level)<100){?>
<!-- homepage -->
<div id="dev_step1" class="hint" exclude="user-stories">
  <div>
    <div class="left-column"><img height="40px" src="/public/images/step1.jpg" /></div>
    <div class="right-column">
      <h3>Browse!</h3>
      Click here to go to browse story page.
      <p class="dialog-hint">Hint: You can refer to user stories located at bottom of page for a quick browse.</p>
    </div>
  </div>
</div>
<!-- -->
<div id="dev_step2" class="hint" highlight="bid-more" exclude="user-stories">
  <div>
    <div class="left-column"><img height="40px" src="/public/images/step2.jpg" /></div>
    <div class="right-column">
      <h3>Select a Job!</h3>
      Just click/expand a user story, view its summary and if you are intrested click on 'Bid & More'.
      <p class="dialog-hint">Hint: Use search and filtering tools to refine your selection</p>
    </div>
  </div>
</div>

<div id="dev_step3" class="hint" highlight="WP-qualification-placeholder" exclude="WP-allbid-placeholder WP-comment-placeholder">
  <div>
    <div class="left-column"><img height="40px" src="/public/images/step3.jpg" /></div>
    <div class="right-column">
      <h3>Bid!</h3>
      Read it. Interested? Say how much and how long you need to finish it then click on Bid button.
      <p class="dialog-hint">1)Use discussion area for more info.<br />2)Compare your bidding against other competitors.</p>
    </div>
  </div>
</div>
<?php }?>