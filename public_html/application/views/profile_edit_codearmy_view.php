<?php $this->load->view('includes/CAProfileHeader.php'); ?>
<div id="profile-edit-content-area">

  <!-- START - Save Profile Block - Dev. by Reza  -->
<div class="block-save-profile">

<div id="save-profile">
Save Profile or <a href="#">Cancel</a>
</div>

<div id="profile-completion">

Profile Completion: 45%

<div id="profile-completion-bar">
      <div id="profile-completion-progress"> </div>
    </div>
</div>

</div>
<br />
<hr style="margin-top:50px" />

<!-- START - Level Block - Dev. by Reza  -->
  <div id="block-level"> Level 1
  </div>

<!-- START - Avatar Block - Dev. by Reza  -->
  <div id="block-avatar">
    <div id="avatar-pic"> <img src="/public/images/codeArmy/profile/default-avatar.png" alt="Avatar Picture" /> </div>
    <div id="profile-desc"> </div>
  </div>

</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>