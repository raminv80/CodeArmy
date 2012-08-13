<?php $this->load->view('includes/CAProfileHeader.php'); ?>

<div class="po-wall-container">
  <div class="top-panel">
    <div class="top-panel-left">
      <div class="top-panel-title">C# Framework for SME Site <a href="#"><img src="/public/images/codeArmy/po/record-icon.png" /></a></div>
      <div class="proj-category">Websites IT &amp; Software > Online Store</div>
      <div class="tabs-row"> <a href="#" class="wall">Wall</a> <a class="task-active" href="#">Task</a> <a class="document" href="#">Document</a> <a class="date" href="#">Date</a> </div>
      <div class="desc-row">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam gravida feugiat feugiat. Duis adipiscing lorem a risus ullamcorper sed rhoncus risus fermentum. Suspendisse potenti. Proin eu arcu eu lectus imperdiet aliquet.</div>
    </div>
    <div class="top-panel-right">
      <div class="progress-text">Progress: 40%</div>
      <div class="wall-progress">
        <div class="wall-progress-bar"></div>
      </div>
      <div class="bg_progress_summary">
        <div class="start-hours">
          <div class="start">
            <p class="wall-box-title">Start</p>
            <p>20 Oct 12</p>
          </div>
          <div class="hours">
            <p class="wall-box-title">Hours</p>
            <p>198</p>
          </div>
        </div>
        <div class="end-budget">
          <div class="end">
            <p class="wall-box-title">End</p>
            <p>18 Nov 12</p>
          </div>
          <p class="wall-box-title">Budget</p>
          <p>$45/hour</p>
          <div class="budget"></div>
        </div>
        <div class="po-info">
          <p class="wall-box-title">Mission Captain</p>
          <p class="po-name">Mr. product Owner</p>
          <p class="level">Level 99</p>
        </div>
        <div class="po-avatar"><img src="/public/images/codeArmy/po/default-avatar.png" /></div>
      </div>
    </div>
  </div>
  <div class="wall-bottom-panel">
    
    <div class="task-taskbar">
    <a class="task-name" href="#"><img src="/public/images/codeArmy/mission/arrow-down.png" />&nbsp;PHP Awesome Fix</a>
    <div class="task-due-date">[ Due 27/10/12 ]</div>
    <div class="profile-n-edit-icon"><a href="#"><img src="/public/images/codeArmy/po/task/profile-icon.png" /></a><a href="#"><img src="/public/images/codeArmy/po/task/edit-icon.png" /></a></div>
    </div>
    
    
    <div class="sub-task-bar">
    <div class="add-subtask-field"><input class="add-subtask" type="text" value="Type here to add a subtask" /> <input type="submit" value="Add sub-task" class="lnkimg" /> </div>
    <div class="ta-hours"><div class="total-hrs">Total Hours: 100 hrs</div><div class="assigned-hrs">Assigned Hours: 89 hrs</div></div>
    </div>
    
    <div class="tasks-table">
    
    <div class="task-table-title">
    <div class="task-title-priority">Priority</div>
    <div class="task-title-taskname">Task Name</div>
    <div class="task-title-deadline">Deadline</div>
    <div class="task-title-hours">Hours</div>
    <div class="task-title-percent">%</div>
    <div class="task-title-status">Status</div>
    </div>
    
    <div class="task-table-row">
    <div class="task-row-priority"><span class="priority-high">High</span></div>
    <div class="task-row-taskname">Database Fix</div>
    <div class="task-row-deadline">21/10</div>
    <div class="task-row-hours">5.0</div>
    <div class="task-row-percent">0</div>
    <div class="task-row-status">To do <a href="#"><img src="/public/images/codeArmy/po/task/task-remove-icon.png" class="task-remove-icon" /></a></div>
    </div>
    
    <div class="task-table-row">
    <div class="task-row-priority"><span class="priority-low">Low</span></div>
    <div class="task-row-taskname">Testing</div>
    <div class="task-row-deadline">21/10</div>
    <div class="task-row-hours">5.0</div>
    <div class="task-row-percent">0</div>
    <div class="task-row-status">To do <a href="#"><img src="/public/images/codeArmy/po/task/task-remove-icon.png" class="task-remove-icon" /></a></div>
    </div>
    
    <div class="task-table-row">
    <div class="task-row-priority"><span class="priority-normal">Normal</span></div>
    <div class="task-row-taskname">Planning</div>
    <div class="task-row-deadline">21/10</div>
    <div class="task-row-hours">5.0</div>
    <div class="task-row-percent">0</div>
    <div class="task-row-status">To do <a href="#"><img src="/public/images/codeArmy/po/task/task-remove-icon.png" class="task-remove-icon" /></a></div>
    </div>
    
    <div class="task-table-row">
    <div class="task-row-priority"><select><option value="Low">Low</option><option value="Normal">Normal</option><option value="High">High</option></select></div>
    <div class="task-row-taskname">Coding</div>
    <div class="task-row-deadline">21/10 <a href="#"><img src="/public/images/codeArmy/po/task/task-date-icon.png" /></a></div>
    <div class="task-row-hours"><input type="text" value="3" /></div>
    <div class="task-row-percent"><input type="text" value="10" /></div>
    <div class="task-row-status"><select><option value="to-do">To Do</option><option value="working">Working</option><option value="done">Done</option></select><a href="#"><img src="/public/images/codeArmy/po/task/task-remove-icon.png" class="task-remove-icon" /></a></div>
    </div>
    
    </div>
    
    
  </div>
</div>
<?php $this->load->view('includes/CAProfileFooter.php'); ?>
