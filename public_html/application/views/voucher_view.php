<?php $this->load->view('includes/header4'); ?>
<section id="Projects">

<div class="WP-main" style="margin-top:100px;">
  <div id="projects-wrapper">
    <div id="content">
    	Create 
    	<?=form_open('/admin/voucher')?>
        	<input name="number" value="1">
            <input type="submit" name="submit" value="Submit">
        <?=form_close()?>
        new vouchers.
        <hr>
        List of vouchers:<br>
        <ul>
        <?php foreach($vouchers as $voucher):?>
        	<li><?=$voucher?></li>
        <?php endforeach;?>
        </ul>
    </div>
  </div>
</div>
<?php $this->load->view('includes/footer5'); ?>