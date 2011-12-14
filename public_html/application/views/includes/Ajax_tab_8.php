						<div class="tab-holder">
							<div class="tab-frame">
								<div class="content">
                                	<h1>Project Management</h1>
                                    <div class="WP-main">My Current Project
                                    <div class="WP-prof-mgmt-placeholder">
									<table id="prof-mgmt-table">
                                 	<tr><th>Project Name</th><th>Status</th></tr>
                                    <tr><td style="text-align:left">My current Projects:<ul>
                                    <?php foreach($projects as $project):?>
                                    <li>
                                    	Project name: <a href="/project/<?=$project['project_id']?>"><?=$project['project_name']?></a>
                                        <ul>
                                        	<li><a href="/project/burndown_chart">Burn Down Chart</a></li>
                                        	<li><a href="/project/sprint_planner/<?=$project['project_id']?>">Sprint Planning</a></li>
                                        	<li><a href="/project/scrum_board/<?=$project['project_id']?>">Scrum borad</a></li>
                                        </ul>
                                    </li>
                                    <?php endforeach;?>
                                    </ul></td><td width="120">status here</td></tr><tr><td style="text-align:left"><a href="http://ver2.workpad.my/#addnewPrj">Add a new project</a><br></td><td width="120">status here</td></tr>
                                   </table><div id="addnewproject"><a href="#">add new projects</a></div>
								</div></div>
							</div>
						</div>