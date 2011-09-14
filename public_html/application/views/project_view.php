<?php $this->load->view('includes/header_view'); ?>

<div id="worklist-wrapper">
<div id="content">
<?php if($create_button == true) { ?>
<span class="button_add"><a href="<?php echo base_url() ?>stories/create/<?php echo $pro_id; ?>" id="dashboardButton">Create User Stories</a></span>
<?php } ?>
	<table>
	<tr>
	<th width="5%">Priority</th>
    <th width="5%">ID</th>
	<th width="62%">Story Name</th>
	<th>Status</th>
	<th>Created at</th>
    <th>Cost</th>
    <th>Points</th>
	<th>Actions</th>
	</tr>
		<?php if(isset($worklist))foreach ($worklist as $work_data) { ?>
			<tr>
			<td>
			<?php if($create_button == true) { ?>
			<?php echo form_open('projects/priority'); ?>
			<input type="hidden" name="work_id" value="<?php echo $work_data['work_id']; ?>">
			<select name="priority" onChange="this.form.submit();">
			<?php 
					$select = "";
						for($x=1; $x < 11; $x++) {
							if($x == $work_data['priority']) {
								$y = "selected";
							}
							else {
								$y = "";
							}
							$select .= "<option value='".$x."' ".$y.">".$x."</option>";
						}		
					echo $select; 
			?>
			</select>
			<div class="button"><input type="hidden" name="project_id" value="<?php echo $pro_id; ?>"></div>
				<?php echo form_close();?>
			<?php }
			else {
				echo $work_data['priority'];
			}
			?>
			</td>
            <td>
            	<?php echo $work_data['work_id'];?>
            </td>
			<td><a href="/story/<?php echo $work_data["work_id"]; ?>"><?php echo $work_data["title"]; ?></a></td><td><?php echo $work_data["status"]; ?></td><td><?php echo date('j M Y', strtotime($work_data["created_at"])); ?></td><td align="center"><?php echo $work_data["cost"];?></td><td align="center"><?php echo $work_data["points"];?></td><td><a href="/story/edit/<?php echo $work_data["work_id"]; ?>">Edit</a> | <a href="/story/delete/<?php echo $pro_id; ?>/<?php echo $work_data["work_id"]; ?>">Delete</a></td>
			</tr>
		<?php } ?>
	</table>
</div>

</div>
<?php $this->load->view('includes/footer_view'); ?>