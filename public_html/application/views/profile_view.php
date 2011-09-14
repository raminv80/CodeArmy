<?php $this->load->view('includes/header_view'); ?>
<?php 
		$contact = json_decode($profile["contact"]);
		$urls = json_decode($profile["urls"]);	

?>

	<!-- profile content container start -->
	<div id="prof-wrapper">
		
		<div id="content">
		<span class="header"><h2><?php echo $username; ?></h2></span>
		
		<div id="profile_form">
			<div class="avatar">
				<img align="left" src="/public/images/ranks/warrior.png">
                <?php if($profile['avatar']){?><img width="40px" height="40px" src="/public/<?php echo $profile['avatar'];?>" /><?php }?>
			</div>
			<div class="profile-info">
				<div class="prof-rank"><?php if($rank != "") { echo $rank; } else { echo "N/A"; }?></div>
				<div class="prof-exp">EXP: <?php if($exp != "") { echo $exp; } else { echo "0"; }?></div>
				
			<table>
			<tr>
				<th>Name</th>
				<td><?php if($profile["full_name"] != "") { echo $profile["full_name"]; } else { echo "N/A"; }?></td>
			</tr>
			
			<?php if(isset($contact->mobile_no)) { ?>
			<tr>
				<th>Mobile No.</th>
				<td><?php echo $contact->mobile_no; ?></td>
			</tr>
			<?php } ?>
			
			<?php if(isset($contact->city)) { ?>
			<tr>
				<th>City</th>
				<td><?php echo $contact->city; ?></td>
			</tr>
			<?php } ?>
			
			<?php if(isset($contact->country)) { ?>
			<tr>
				<th>Country</th>
				<td><?php echo $contact->country; ?></td>
			</tr>
			<?php } ?>
			
			<?php if($profile["bank_name"] != "") { ?>
			<tr>
				<th>Bank Name</th>
				<td><?php echo $profile["bank_name"]; ?></td>
			</tr>
			<?php } ?>
			
			<?php if($profile["bank_acc"] != "") { ?>
			<tr>
				<th>Bank Account Number</th>
				<td><?php echo $profile["bank_acc"]; ?></td>
			</tr>
			<?php } ?>
			
			<?php if($profile["paypal_acc"] != "") { ?>
			<tr>
				<th>Paypal</th>
				<td><?php echo $profile["paypal_acc"]; ?></td>
			</tr>
			<?php } ?>
			
			<?php if(isset($urls->facebook)) { ?>
			<tr>
				<th>Facebook</th>
				<td><?php echo $urls->facebook; ?></td>
			</tr>
			<?php } ?>
			
			<?php if(isset($urls->twitter)) { ?>
			<tr>
				<th>Twitter</th>
				<td><?php echo $urls->twitter; ?></td>
			</tr>
			<?php } ?>
			
			<?php if(isset($urls->linkedin)) { ?>
			<tr>
				<th>LinkedIn</th>
				<td><?php echo $urls->linkedin; ?></td>
			</tr>
			<?php } ?>
			
			<?php if(isset($urls->github)) { ?>
			<tr>
				<th>Github URL</th>
				<td><?php echo $urls->github; ?></td>
			</tr>
			<?php } ?>
			
			<?php if(isset($urls->portfolio)) { ?>
			<tr>
				<th>Portfolio URL</th>
				<td><?php echo $urls->portfolio; ?></td>
			</tr>
			<?php } ?>
			
		</table>	
				
			</div>
			
		</div>
		
		
				
		<div class="profile_view">
				<a href="<?php echo base_url()?>profile/edit">Edit Profile</a>
				<a href="<?php echo base_url()?>profile/edit_password">Change Password</a>
		</div>
			
		</div>
	</div>
	<!-- / profile content container ends -->
		
<?php $this->load->view('includes/footer_view'); ?>