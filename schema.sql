-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 10, 2012 at 04:56 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `codearmy_DB`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE IF NOT EXISTS `achievements` (
  `achievement_id` int(11) NOT NULL auto_increment,
  `achievement_name` varchar(255) NOT NULL,
  `achievement_desc` varchar(255) NOT NULL,
  `achievement_pic` varchar(255) NOT NULL,
  PRIMARY KEY  (`achievement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `achievement_set`
--

CREATE TABLE IF NOT EXISTS `achievement_set` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` varchar(48) NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `achievement_id` (`achievement_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(255) NOT NULL,
  `action` enum('pass') NOT NULL,
  `user_id` varchar(48) NOT NULL,
  `validity` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE IF NOT EXISTS `bids` (
  `bid_id` int(11) NOT NULL auto_increment,
  `work_id` varchar(40) default NULL,
  `user_id` varchar(40) default NULL,
  `bid_cost` float default NULL,
  `days` int(4) NOT NULL,
  `bid_status` varchar(16) default NULL,
  `created_at` datetime default NULL,
  PRIMARY KEY  (`bid_id`),
  KEY `user_id` (`user_id`),
  KEY `work_id` (`work_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=164 ;

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

CREATE TABLE IF NOT EXISTS `captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL auto_increment,
  `captcha_time` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL default '0',
  `word` varchar(20) NOT NULL,
  PRIMARY KEY  (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL auto_increment,
  `project_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `from` varchar(255) NOT NULL default '',
  `to` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `sent` datetime NOT NULL default '0000-00-00 00:00:00',
  `recd` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(16) NOT NULL default '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text NOT NULL,
  PRIMARY KEY  (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(255) NOT NULL auto_increment,
  `username` varchar(40) NOT NULL,
  `comment_body` text NOT NULL,
  `comment_file` varchar(255) default NULL,
  `comment_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `story_id` varchar(40) NOT NULL,
  PRIMARY KEY  (`comment_id`),
  KEY `story_id` (`story_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` varchar(48) NOT NULL,
  `friend_id` varchar(48) NOT NULL,
  `status` enum('approved','declined','request') NOT NULL,
  `group` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `friend_id` (`friend_id`),
  KEY `group` (`group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='holds friends relationships' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `friend_groups`
--

CREATE TABLE IF NOT EXISTS `friend_groups` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` varchar(48) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='user can group his friends.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `game_v3`
--

CREATE TABLE IF NOT EXISTS `game_v3` (
  `player_level` int(11) NOT NULL auto_increment,
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
  PRIMARY KEY  (`player_level`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` varchar(48) default NULL,
  `event` varchar(255) default NULL,
  `status` varchar(255) default NULL,
  `work_id` varchar(32) default NULL,
  `project_id` int(11) default NULL,
  `Desc` text,
  `created_at` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=291 ;

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE IF NOT EXISTS `inbox` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` varchar(48) NOT NULL,
  `target_id` varchar(48) default NULL,
  `link` varchar(255) default NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') NOT NULL default 'unread',
  `created_at` datetime NOT NULL,
  `category` enum('bid','message','job') default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=273 ;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(255) NOT NULL auto_increment,
  `project_name` varchar(40) NOT NULL,
  `project_desc` text,
  `project_owner_id` varchar(40) NOT NULL,
  `scrum_master_id` varchar(40) default NULL,
  `deployer_id` varchar(40) default NULL,
  `project_created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`project_id`),
  KEY `project_owner_id` (`project_owner_id`),
  KEY `scrum_master_id` (`scrum_master_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE IF NOT EXISTS `ranks` (
  `id` int(11) NOT NULL auto_increment,
  `start_exp` int(11) NOT NULL,
  `end_exp` int(11) NOT NULL,
  `rank` varchar(100) NOT NULL,
  `url` varchar(255) default NULL,
  `url_main` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE IF NOT EXISTS `skill` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `type` enum('soft','hard','management') NOT NULL,
  `desc` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `skill_set`
--

CREATE TABLE IF NOT EXISTS `skill_set` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` varchar(48) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `point` int(11) NOT NULL default '0',
  `claim` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `skill_id` (`skill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Table structure for table `sprints`
--

CREATE TABLE IF NOT EXISTS `sprints` (
  `id` int(11) NOT NULL auto_increment,
  `project_id` int(11) NOT NULL,
  `title` varchar(200) default NULL,
  `start` date default NULL,
  `end` date default NULL,
  `desc` text,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE IF NOT EXISTS `subscription` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(255) NOT NULL,
  `type` varchar(50) default 'general',
  `agent` varchar(255) NOT NULL,
  `ip` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_comment`
--

CREATE TABLE IF NOT EXISTS `subscription_comment` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` varchar(48) NOT NULL,
  `work_id` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` varchar(48) NOT NULL default '',
  `username` varchar(40) NOT NULL,
  `role` enum('user','admin') default NULL,
  `secret` varchar(40) NOT NULL default '',
  `email` varchar(255) default NULL,
  `exp` int(11) NOT NULL default '0',
  `hour_spent` int(11) NOT NULL default '0',
  `done` int(11) NOT NULL,
  `early_done` int(11) NOT NULL,
  `created_at` datetime default NULL,
  `last_login` datetime default NULL,
  `user_status` enum('enable','disable') default NULL,
  `show_tutorial` smallint(6) NOT NULL default '1' COMMENT '1:bidding, 2:submit, 3:dev-tut-done, 4:dev-waiting-accept-bid',
  `attempt` tinyint(4) NOT NULL default '0',
  `claims` int(11) NOT NULL default '3' COMMENT 'skill point claims',
  `remember_me_token` varchar(25) default NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) default NULL,
  `user_id` varchar(40) NOT NULL,
  `full_name` varchar(60) NOT NULL,
  `contact` text NOT NULL,
  `urls` text NOT NULL,
  `bank_name` varchar(40) NOT NULL,
  `bank_acc` varchar(40) NOT NULL,
  `paypal_acc` varchar(60) NOT NULL,
  `lan_speak` varchar(100) default NULL,
  `lan_rw` varchar(100) default NULL,
  `avatar` varchar(255) default NULL,
  `gender` enum('male','female') default NULL,
  `birthdate` date default NULL,
  `specialization` varchar(100) default NULL,
  PRIMARY KEY  (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_po`
--

CREATE TABLE IF NOT EXISTS `voucher_po` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(12) NOT NULL,
  `active` tinyint(4) NOT NULL default '1',
  `user_id` varchar(48) default NULL,
  `redemption_at` timestamp NULL default NULL,
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `works`
--

CREATE TABLE IF NOT EXISTS `works` (
  `work_id` varchar(32) NOT NULL default '',
  `priority` double NOT NULL default '1',
  `sprint` int(11) NOT NULL default '0',
  `title` varchar(255) default NULL,
  `type` enum('R&D','Frontend','Backend','Copywrite','Test') default NULL,
  `category` int(11) default NULL,
  `description` text,
  `note` text,
  `points` int(4) default NULL,
  `cost` float default NULL,
  `status` enum('draft','open','In Progress','Done','Redo','Verify','Signoff','Reject') default NULL,
  `creator` varchar(48) default NULL COMMENT 'user_id of the person the created this worktask. The user is the admin for this worktask',
  `owner` varchar(48) default NULL COMMENT 'user_id for the onwer of this worktask',
  `project_id` int(11) default NULL,
  `created_at` datetime default NULL,
  `work_horse` varchar(40) default NULL,
  `bid_deadline` datetime default NULL,
  `deadline` datetime default NULL,
  `assigned_at` datetime default NULL,
  `done_at` datetime default NULL,
  `tutorial` text,
  `attach` varchar(256) default NULL,
  `git` varchar(256) default NULL,
  `link` varchar(256) default NULL,
  PRIMARY KEY  (`work_id`),
  KEY `creator` (`creator`),
  KEY `owner` (`owner`),
  KEY `project_id` (`project_id`),
  KEY `work_horse` (`work_horse`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `work_files`
--

CREATE TABLE IF NOT EXISTS `work_files` (
  `file_id` varchar(48) NOT NULL default '',
  `file_type` varchar(5) default NULL,
  `file_name` varchar(255) default NULL,
  `file_title` varchar(255) default NULL,
  `file_description` text,
  `created_at` datetime default NULL,
  `work_id` varchar(48) default NULL,
  PRIMARY KEY  (`file_id`),
  KEY `work_id` (`work_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `work_skill`
--

CREATE TABLE IF NOT EXISTS `work_skill` (
  `id` int(11) NOT NULL auto_increment,
  `work_id` varchar(32) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `point` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `work_id` (`work_id`),
  KEY `skill_id` (`skill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievement_set`
--
ALTER TABLE `achievement_set`
  ADD CONSTRAINT `achievement_set_ibfk_1` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`achievement_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `achievement_set_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `bids_ibfk_1` FOREIGN KEY (`work_id`) REFERENCES `works` (`work_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bids_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `works` (`work_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_ibfk_3` FOREIGN KEY (`group`) REFERENCES `friend_groups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `friend_groups`
--
ALTER TABLE `friend_groups`
  ADD CONSTRAINT `friend_groups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inbox`
--
ALTER TABLE `inbox`
  ADD CONSTRAINT `inbox_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`project_owner_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `project_ibfk_2` FOREIGN KEY (`scrum_master_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `skill_set`
--
ALTER TABLE `skill_set`
  ADD CONSTRAINT `skill_set_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `skill_set_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sprints`
--
ALTER TABLE `sprints`
  ADD CONSTRAINT `sprints_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `works`
--
ALTER TABLE `works`
  ADD CONSTRAINT `works_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `works_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `works_ibfk_3` FOREIGN KEY (`work_horse`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `works_ibfk_4` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `works_ibfk_5` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `work_files`
--
ALTER TABLE `work_files`
  ADD CONSTRAINT `work_files_ibfk_1` FOREIGN KEY (`work_id`) REFERENCES `works` (`work_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `work_skill`
--
ALTER TABLE `work_skill`
  ADD CONSTRAINT `work_skill_ibfk_3` FOREIGN KEY (`work_id`) REFERENCES `works` (`work_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `work_skill_ibfk_4` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

