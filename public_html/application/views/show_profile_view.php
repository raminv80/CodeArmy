<?php $this->load->view('includes/header_view'); ?>
<?php 
		$contact = json_decode($profile["contact"]);
		$urls = json_decode($profile["urls"]);	

?>

	<!-- profile content container start -->
	<div id="prof-wrapper">
		<div id="content">
		
		<span class="header"><h2>Get to know "<?php echo $username; ?>"</h2></span>
		
		<div id="profile_form">
			<div class="avatar">
				<img align="left" src="/public/images/ranks/warrior.png">
			</div>
			<div class="profile-info">
				<div class="prof-rank"><?php if($rank != "") { echo $rank; } else { echo "N/A"; }?></div>
				<div class="prof-exp">EXP: <?php if($exp != "") { echo $exp; } else { echo "0"; }?></div>
				<div class="prof-medal">
					<?php if($lightspeed_medal){?><img src="/public/images/ranks/main/MedalWorkPad.png" alt="Lightspeed" /><?php }?>
                    <?php if($strength){?><img src="" alt="Lightspeed" /><?php }?></div>	
		
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
			
			<?php if(isset($urls->portfolio)) { ?>
			<tr>
				<th>Portfolio URL</th>
				<td><?php echo $urls->portfolio; ?></td>
			</tr>
			<?php } ?>
            
            <tr>
            	<th>Points done:</th>
                <td><?php echo $stats['done'];?></td>
            </tr>
            <tr>
            	<th>Points verified:</th>
                <td><?php echo $stats['verify'];?></td>
            </tr>
            <tr>
            	<th>Points sign offed:</th>
                <td><?php echo $stats['signoff'];?></td>
            </tr>
            <tr>
            	<th>Points redo:</th>
                <td><?php echo $stats['redo'];?></td>
            </tr>
            <tr>
            	<th>Points rejected:</th>
                <td><?php echo $stats['reject'];?></td>
            </tr>
            <tr>
            	<th>Works bid:</th>
                <td><?php echo $stats['bid'];?></td>
            </tr>
            <tr>
            	<th>Works won:</th>
                <td><?php echo $stats['win'];?></td>
            </tr>
		</table>
			
		</div>
			
		</div>	
			
		</div>
	</div>
	<!-- / profile content container ends -->
		
<?php $this->load->view('includes/footer_view'); ?>