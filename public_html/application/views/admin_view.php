<?php $this->load->view('includes/header4'); ?>
<style type="text/css">
table#project-list, table#user-list {border-spacing: 0;width:1000px; }
#project-list th, #user-list th {padding: 7px;background: #494949;border: 1px solid #3D3D3D;color: white;font-family: DINlightalternate;text-align: left;font-size: 16px; }
#project-list td, #user-list td {background: white;
color: #3d3d3d;
padding: 5px 10px 5px 10px;
border: 1px solid #B2B2B2;
border-spacing: 0;}
#project-list td a {color:#3d3d3d;}
#user-list td a {color:#000099}
#project-list td a:hover, #user-list td a:hover {color:#000;}
#project-heading {
border-top-left-radius: 10px;
border-top-right-radius: 10px;
background: #3D3D3D;
color: white;
width: 980px;
height: 42px;
padding: 10px 0 0 20px;
font-size: 23px;
text-shadow: 0 1px 10px white;
}
#userstatus {text-align: center;
width: 60px;
float: left;}
#user-list ul {list-style:none;margin-left:-50px;}
#user-list li {padding: 0 5px 0 10px;
width: 64px;}
#user-list li:hover {background:#2fb4e0;}
</style>
<section id="Projects">

<div class="WP-main" style="margin-top:100px;">
  <!--<ul class="project-tools">
    <li><a href="/admin/new_project">Create Project</a></li>
  </ul>-->
  <div id="projects-wrapper">
    <div id="content">
      <?php if(!empty($projects)) { ?>
      <div id="project-heading">PROJECT LIST</div>
      <table border="0" id="project-list">
        <tr>
          <th>Project Name</th>
          <th>Product Owner</th>
          <th>Scrum Master</th>
          <th>Created at</th>
          <th>Actions</th>
        </tr>
        <?php foreach ($projects as $pro_data) { ?>
        <tr>
          <td><a href="/project/show/<?php echo $pro_data["project_id"]; ?>"><?php echo $pro_data["project_name"]; ?></a></td>
          <td><a href="/user/<?=$pro_data['po_user_id']?>">
            <?=$pro_data['po_username']?></td>
            </td>
          <td><a href="/user/<?=$pro_data['sm_user_id']?>">
            <?=$pro_data['sm_username']?></td>
            </td>
          <td><?php echo date('j M Y', strtotime($pro_data["project_created_at"])); ?></td>
          <td><ul class="project-option">
              <li><a href="/project/show/<?php echo $pro_data["project_id"]; ?>">view</a></li>
              <li><a href="/admin/edit_project/<?php echo $pro_data["project_id"]; ?>">Edit</a></li>
            </ul></td>
        </tr>
        <?php } ?>
      </table>
      <br>
      <div id="addnewproject">
      	<a style="margin: 0 auto;" href="/admin/new_project">Create Project</a>
      </div>
      <br /><a style="margin: 0 auto;" href="/admin/voucher">Create voucher</a>
      <?php }
            else {
            ?>
      <span class="notification"><?php echo $error; ?></span>
      <?php } ?>
    </div>
  </div>
</div>
</section>
<section id="users">
<div class="WP-main">
<div id="project-heading">USER LIST</div>
  <table width="1000px" id="user-list" style="font-size:14px !important; padding-bottom:200px">
    <tr>
      <th width="40">No</th>
      <th width="140px"><a href="/admin/index/user_id">ID</a></th>
      <th><a href="/admin/index/username">User name</a></th>
      <th>Email</th>
      <th><a href="/admin/index/role">Role</a></th>
      <th style="width:40px"><a href="/admin/index/status">Project Control</a></th>
      <th><a href="/admin/index/created">Created</a></th>
      <th><a href="/admin/index/login">Last login</a></th>
      <th>Options</th>
    </tr>
    <?php foreach ($users as $i=>$user):?>
    <tr id="user_<?=$user['user_id']?>">
      <td><?=$i+1?></td>
      <td>
        <?=$user['user_id']?>
      </td>
      <td>
       <?=$user['username']?>
      </td>
      <td>
	  	<?=$user['email']?>
      </td>
      <td>
        <span style="width:38px;" id="userstatus"><?=$user['role']?></span>
      </td>
      <td>
        <span id="userstatus"><?=$user['user_status']?>
        </a></span></td>
      <td>
        <?=$user['created_at']?>
      </td>
      <td>
        <?=$user['last_login']?>
      </td>
      <td><ul>
          <li><a href="/user/<?=$user['user_id']?>">View</a></li>
          <li><a href="/admin/promote/<?=$user['user_id']?>">Promote</a></li>
          <li><a href="/admin/demote/<?=$user['user_id']?>">Demote</a></li>
        </ul></td>
    </tr>
    <?php endforeach;?>
  </table>
</section>
<?php $this->load->view('includes/footer5'); ?>
