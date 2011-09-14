<?php $this->load->view('includes/header_view'); ?>


<div id="projects-wrapper">
<div id="content">
	<p><a href="projects/create">Create a Project</a></p>
	<?php if(!empty($projects)) { ?>

	<table>
	<tr><th>Project Name</th><th>Created at</th><th>Actions</th></tr>
		<?php foreach ($projects as $pro_data) { ?>
			<tr>
			<td><a href="/projects/view/<?php echo $pro_data["project_id"]; ?>"><?php echo $pro_data["project_name"]; ?></a></td><td><?php echo date('j M Y', strtotime($pro_data["project_created_at"])); ?></td><td><a href="projects/edit/<?php echo $pro_data["project_id"]; ?>">Edit</a></td>
			</tr>
		<?php } ?>
	</table>
	<?php }
	else {
	?>
	<span class="notification"><?php echo $error; ?></span>
	<?php } ?>
</div>
</div>	
<?php $this->load->view('includes/footer_view'); ?>