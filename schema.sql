SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE `achievements` (
  `achievement_id` int(11) NOT NULL AUTO_INCREMENT,
  `achievement_name` varchar(255) NOT NULL,
  `achievement_desc` varchar(255) NOT NULL,
  `achievement_pic` varchar(255) NOT NULL,
  PRIMARY KEY (`achievement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

CREATE TABLE `achievement_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(48) NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `achievement_id` (`achievement_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

CREATE TABLE `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `action` enum('pass') NOT NULL,
  `user_id` varchar(48) NOT NULL,
  `validity` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

CREATE TABLE `arrangement_budget` (
  `budget_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `amount_cal` int(11) NOT NULL,
  PRIMARY KEY (`budget_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

CREATE TABLE `arrangement_time` (
  `time_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `duration` varchar(15) NOT NULL,
  `time_cal` float NOT NULL,
  PRIMARY KEY (`time_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

CREATE TABLE `arrangement_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('hourly','daily','weekly','monthly') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

CREATE TABLE `bids` (
  `bid_id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` varchar(40) DEFAULT NULL,
  `user_id` varchar(40) DEFAULT NULL,
  `bid_cost` float DEFAULT NULL,
  `bid_time` int(11) NOT NULL,
  `bid_desc` varchar(255) NOT NULL,
  `bid_status` varchar(16) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`bid_id`),
  KEY `user_id` (`user_id`),
  KEY `work_id` (`work_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=189 ;

CREATE TABLE `captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

CREATE TABLE `chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(255) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recd` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL DEFAULT '1',
  `class_name` varchar(100) NOT NULL,
  `sign` char(1) NOT NULL DEFAULT '#',
  PRIMARY KEY (`class_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

CREATE TABLE `comments` (
  `comment_id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `comment_body` text NOT NULL,
  `comment_file` varchar(255) DEFAULT NULL,
  `comment_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `story_id` varchar(40) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `story_id` (`story_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

CREATE TABLE `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(48) NOT NULL,
  `friend_id` varchar(48) NOT NULL,
  `status` enum('approved','declined','request') NOT NULL,
  `group` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `friend_id` (`friend_id`),
  KEY `group` (`group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='holds friends relationships' AUTO_INCREMENT=1 ;

CREATE TABLE `friend_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(48) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='user can group his friends.' AUTO_INCREMENT=1 ;

CREATE TABLE `game_v3` (
  `player_level` int(11) NOT NULL AUTO_INCREMENT,
  `level_up_xp` int(11) NOT NULL COMMENT 'This shows the XP difference between one level to the next',
  `small_action_xp` int(11) NOT NULL COMMENT ' The XP awarded to the players at their respective levels for doing "Small Actions" which would be defined as the smallest type of action for which points can be awarded.',
  `big_action_xp` int(11) NOT NULL COMMENT ' The XP awarded to the players at their respective levels for doing "Big Actions" - these actions are of greater value than "Small Actions" and thus have higher point rewards.',
  `small_action_level` int(11) NOT NULL COMMENT 'Total Small Actions needed to level up',
  `big_action_level` int(11) NOT NULL COMMENT 'Total big actions to level up',
  `projected_hour` int(11) NOT NULL COMMENT ' Projected project length players would do at each level, represented in hours',
  `job_hour_xp` int(11) NOT NULL COMMENT 'The best way to earn XP is to work on projects. While working, this is the amount of XP players earn per hour at their respective level.  Project XP will be kept in a "bucket" which will be awarded to the player once a project is completed and project rew',
  `lifetime_xp` int(11) NOT NULL COMMENT 'Lifetime earned XP totals',
  `skill_point` int(11) NOT NULL COMMENT 'Skill points are awarded at Level Up events. Players have 20 Skill points to start with that they can allocate across 3 Skills.  To unlock an additional skill, players can save up and cash in 80 skill points.  Each skill can be leveled up to 100 maximum',
  `xp_from` int(11) NOT NULL COMMENT 'level low limit xp',
  `xp_to` int(11) NOT NULL COMMENT 'level top limit xp',
  PRIMARY KEY (`player_level`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

CREATE TABLE `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(48) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `work_id` varchar(32) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `Desc` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=292 ;

CREATE TABLE `inbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(48) NOT NULL,
  `target_id` varchar(48) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') NOT NULL DEFAULT 'unread',
  `created_at` datetime NOT NULL,
  `category` enum('bid','message','job') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=277 ;

CREATE TABLE `invitation` (
  `invite_id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` varchar(32) NOT NULL,
  `user_id` varchar(48) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('sent','viewed','accepted','rejected') NOT NULL,
  PRIMARY KEY (`invite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `from` varchar(48) NOT NULL,
  `to` varchar(48) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `category` enum('inbox','important','archive','trash','deleted') NOT NULL DEFAULT 'inbox',
  `status` enum('read','unread') NOT NULL DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`),
  KEY `from` (`from`),
  KEY `to` (`to`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

CREATE TABLE `mission_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

CREATE TABLE `project` (
  `project_id` int(255) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(40) NOT NULL,
  `project_desc` text,
  `project_owner_id` varchar(40) NOT NULL,
  `scrum_master_id` varchar(40) DEFAULT NULL,
  `deployer_id` varchar(40) DEFAULT NULL,
  `project_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`project_id`),
  KEY `project_owner_id` (`project_owner_id`),
  KEY `scrum_master_id` (`scrum_master_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

CREATE TABLE `ranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_exp` int(11) NOT NULL,
  `end_exp` int(11) NOT NULL,
  `rank` varchar(100) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `url_main` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=19 ;

CREATE TABLE `skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` enum('soft','hard','management') NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

CREATE TABLE `skill_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_level` enum('Beginner','Intermediate','Expert') NOT NULL,
  `skill_point` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

CREATE TABLE `skill_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(48) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `point` int(11) NOT NULL DEFAULT '0',
  `claim` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `skill_id` (`skill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

CREATE TABLE `sprints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `desc` text,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

CREATE TABLE `subclass` (
  `subclass_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL DEFAULT '1',
  `subclass_name` varchar(100) NOT NULL,
  PRIMARY KEY (`subclass_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

CREATE TABLE `subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `agent` varchar(255) NOT NULL,
  `ip` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

CREATE TABLE `subscription_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(48) NOT NULL,
  `work_id` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

CREATE TABLE `users` (
  `user_id` varchar(48) NOT NULL DEFAULT '',
  `username` varchar(40) NOT NULL,
  `role` enum('user','po','admin') DEFAULT NULL,
  `secret` varchar(40) NOT NULL DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `exp` int(11) NOT NULL DEFAULT '0',
  `hour_spent` int(11) NOT NULL DEFAULT '0',
  `done` int(11) NOT NULL,
  `early_done` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `user_status` enum('enable','disable') DEFAULT NULL COMMENT 'Is user a PO?',
  `show_tutorial` smallint(6) NOT NULL DEFAULT '1' COMMENT '1:bidding, 2:submit, 3:dev-tut-done, 4:dev-waiting-accept-bid',
  `attempt` tinyint(4) NOT NULL DEFAULT '0',
  `claims` int(11) NOT NULL DEFAULT '3' COMMENT 'skill point claims',
  `remember_me_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user_profiles` (
  `id` int(11) DEFAULT NULL,
  `user_id` varchar(40) NOT NULL,
  `full_name` varchar(60) NOT NULL,
  `contact` text NOT NULL,
  `urls` text NOT NULL,
  `status_msg` varchar(255) NOT NULL,
  `bank_name` varchar(40) NOT NULL,
  `bank_acc` varchar(40) NOT NULL,
  `bank_country` varchar(3) NOT NULL,
  `bank_swift` varchar(40) NOT NULL,
  `bank_firstname` varchar(255) NOT NULL,
  `bank_lastname` varchar(255) NOT NULL,
  `paypal_acc` varchar(255) NOT NULL,
  `lan_speak` varchar(100) DEFAULT NULL,
  `lan_rw` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `specialization` enum('employer','designer','developer','copywriter','unknown','product owner') DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `voucher_po` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(12) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `user_id` varchar(48) DEFAULT NULL,
  `redemption_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

CREATE TABLE `works` (
  `work_id` varchar(32) NOT NULL DEFAULT '',
  `priority` double NOT NULL DEFAULT '1',
  `sprint` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `class` int(11) DEFAULT NULL,
  `subclass` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `description` text,
  `note` text,
  `input` varchar(30) DEFAULT NULL,
  `output` varchar(30) DEFAULT NULL,
  `points` int(4) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `status` enum('draft','open','assigned','In Progress','Done','Redo','Verify','Signoff','Reject') DEFAULT NULL,
  `creator` varchar(48) DEFAULT NULL COMMENT 'user_id of the person the created this worktask. The user is the admin for this worktask',
  `owner` varchar(48) DEFAULT NULL COMMENT 'user_id for the onwer of this worktask',
  `project_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `work_horse` varchar(40) DEFAULT NULL,
  `bid_deadline` datetime DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `assigned_at` datetime DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `done_at` datetime DEFAULT NULL,
  `tutorial` text,
  `attach` varchar(256) DEFAULT NULL,
  `git` varchar(256) DEFAULT NULL,
  `link` varchar(256) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `manageable` tinyint(4) DEFAULT NULL,
  `est_arrangement` varchar(100) DEFAULT NULL,
  `est_time_frame` varchar(100) DEFAULT NULL,
  `est_budget` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`work_id`),
  KEY `creator` (`creator`),
  KEY `owner` (`owner`),
  KEY `project_id` (`project_id`),
  KEY `work_horse` (`work_horse`),
  KEY `category` (`category`),
  KEY `subclass` (`subclass`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `work_files` (
  `file_id` varchar(48) NOT NULL DEFAULT '',
  `file_type` varchar(5) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_title` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_description` text,
  `created_at` datetime DEFAULT NULL,
  `work_id` varchar(48) DEFAULT NULL,
  `session_id` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`file_id`),
  KEY `work_id` (`work_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `work_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` varchar(32) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `skill_level` varchar(100) DEFAULT NULL,
  `point` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `work_id` (`work_id`),
  KEY `skill_id` (`skill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

CREATE TABLE `mission_task` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` varchar(32) NOT NULL,
  `user_id` varchar(48) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_priority` enum('Low','Normal','High','') NOT NULL DEFAULT 'Normal',
  `task_deadline` date DEFAULT NULL,
  `task_hours` int(11) DEFAULT '0',
  `task_percentage` int(11) DEFAULT '0',
  `task_status` enum('To Do','Working','Done','') NOT NULL DEFAULT 'To Do',
  PRIMARY KEY (`task_id`),
  KEY `work_id` (`work_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `work_links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link` text NOT NULL,
  `work_id` varchar(32) NOT NULL,
  `upload_by` varchar(48) NOT NULL,
  `upload_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`link_id`),
  KEY `work_id` (`work_id`),
  KEY `upload_by` (`upload_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `calendar` (
  `calendar_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `startDate` varchar(50) NOT NULL,
  `endDate` varchar(50) NOT NULL,
  `work_id` varchar(32) NOT NULL,
  `user_id` varchar(48) NOT NULL,
  PRIMARY KEY (`calendar_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `achievement_set`
  ADD CONSTRAINT `achievement_set_ibfk_1` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`achievement_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `achievement_set_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `arrangement_budget`
  ADD CONSTRAINT `arrangement_budget_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `arrangement_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `arrangement_time`
  ADD CONSTRAINT `arrangement_time_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `arrangement_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `bids`
  ADD CONSTRAINT `bids_ibfk_1` FOREIGN KEY (`work_id`) REFERENCES `works` (`work_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bids_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `mission_category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `works` (`work_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_ibfk_3` FOREIGN KEY (`group`) REFERENCES `friend_groups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `friend_groups`
  ADD CONSTRAINT `friend_groups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `inbox`
  ADD CONSTRAINT `inbox_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`from`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`to`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `messages` (`message_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`project_owner_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `project_ibfk_2` FOREIGN KEY (`scrum_master_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `skill_set`
  ADD CONSTRAINT `skill_set_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `skill_set_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sprints`
  ADD CONSTRAINT `sprints_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `subclass`
  ADD CONSTRAINT `subclass_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `works`
  ADD CONSTRAINT `works_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `works_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `works_ibfk_3` FOREIGN KEY (`work_horse`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `works_ibfk_4` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `works_ibfk_5` FOREIGN KEY (`category`) REFERENCES `mission_category` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `works_ibfk_6` FOREIGN KEY (`subclass`) REFERENCES `subclass` (`subclass_id`);

ALTER TABLE `work_files`
  ADD CONSTRAINT `work_files_ibfk_1` FOREIGN KEY (`work_id`) REFERENCES `works` (`work_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `work_skill`
  ADD CONSTRAINT `work_skill_ibfk_3` FOREIGN KEY (`work_id`) REFERENCES `works` (`work_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `work_skill_ibfk_4` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `mission_task`
  ADD CONSTRAINT `mission_task_ibfk_1` FOREIGN KEY (`work_id`) REFERENCES `works` (`work_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mission_task_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `work_links`
  ADD CONSTRAINT `work_links_ibfk_1` FOREIGN KEY (`work_id`) REFERENCES `works` (`work_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `work_links_ibfk_2` FOREIGN KEY (`upload_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
