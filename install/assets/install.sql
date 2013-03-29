/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table ha_blog_catmap
# ------------------------------------------------------------

CREATE TABLE `ha_blog_catmap` (
  `catID` int(11) NOT NULL default '0',
  `postID` int(11) NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`catID`,`postID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_blog_cats
# ------------------------------------------------------------

CREATE TABLE `ha_blog_cats` (
  `catID` int(11) NOT NULL auto_increment,
  `catName` varchar(100) collate utf8_unicode_ci default NULL,
  `catSafe` varchar(100) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `catOrder` int(11) default NULL,
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`catID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_blog_comments
# ------------------------------------------------------------

CREATE TABLE `ha_blog_comments` (
  `commentID` int(11) NOT NULL auto_increment,
  `postID` int(11) NOT NULL default '0',
  `dateCreated` timestamp NULL default '0000-00-00 00:00:00',
  `comment` text collate utf8_unicode_ci,
  `fullName` varchar(100) collate utf8_unicode_ci default NULL,
  `email` varchar(100) collate utf8_unicode_ci default NULL,
  `website` varchar(100) collate utf8_unicode_ci default NULL,
  `active` tinyint(1) unsigned NOT NULL default '1',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`commentID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_blog_posts
# ------------------------------------------------------------

CREATE TABLE `ha_blog_posts` (
  `postID` int(11) NOT NULL auto_increment,
  `postTitle` varchar(100) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `uri` varchar(100) collate utf8_unicode_ci default NULL,
  `body` text collate utf8_unicode_ci,
  `excerpt` text collate utf8_unicode_ci,
  `userID` int(11) default NULL,
  `tags` varchar(250) collate utf8_unicode_ci default NULL,
  `published` tinyint(1) NOT NULL default '1',
  `allowComments` tinyint(1) NOT NULL default '1',
  `allowPings` tinyint(1) NOT NULL default '1',
  `views` int(11) unsigned NOT NULL default '0',
  `deleted` tinyint(1) default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`postID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_captcha
# ------------------------------------------------------------

CREATE TABLE `ha_captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL auto_increment,
  `captcha_time` int(10) unsigned NOT NULL default '0',
  `ip_address` varchar(16) collate utf8_unicode_ci NOT NULL default '0',
  `word` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_community_messagemap
# ------------------------------------------------------------

CREATE TABLE `ha_community_messagemap` (
  `messageID` int(11) NOT NULL default '0',
  `toUserID` int(11) NOT NULL default '0',
  `userID` int(11) NOT NULL default '0',
  `siteID` int(11) NOT NULL default '0',
  `parentID` int(11) NOT NULL default '0',
  `unread` tinyint(1) unsigned NOT NULL default '1',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`messageID`,`toUserID`,`userID`,`siteID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_community_messages
# ------------------------------------------------------------

CREATE TABLE `ha_community_messages` (
  `messageID` int(11) NOT NULL auto_increment,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `userID` int(11) default NULL,
  `subject` varchar(100) collate utf8_unicode_ci default NULL,
  `message` text collate utf8_unicode_ci,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`messageID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_ci_sessions
# ------------------------------------------------------------

CREATE TABLE `ha_ci_sessions` (
  `session_id` varchar(40) collate utf8_unicode_ci NOT NULL default '0',
  `ip_address` varchar(45) collate utf8_unicode_ci NOT NULL default '0',
  `user_agent` varchar(120) collate utf8_unicode_ci NOT NULL default '',
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_email_blocks
# ------------------------------------------------------------

CREATE TABLE `ha_email_blocks` (
  `blockID` int(11) NOT NULL auto_increment,
  `emailID` int(11) default NULL,
  `blockRef` varchar(50) collate utf8_unicode_ci default NULL,
  `body` text collate utf8_unicode_ci,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`blockID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_email_campaigns
# ------------------------------------------------------------

CREATE TABLE `ha_email_campaigns` (
  `campaignID` int(11) NOT NULL auto_increment,
  `campaignName` varchar(100) default NULL,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`campaignID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_email_deploy
# ------------------------------------------------------------

CREATE TABLE `ha_email_deploy` (
  `deployID` int(11) NOT NULL auto_increment,
  `emailID` int(11) NOT NULL default '0',
  `email` varchar(50) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '0',
  `sent` tinyint(1) NOT NULL default '0',
  `failed` tinyint(1) NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`deployID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_email_includes
# ------------------------------------------------------------

CREATE TABLE `ha_email_includes` (
  `includeID` int(11) NOT NULL auto_increment,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `includeRef` varchar(100) default NULL,
  `body` text,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`includeID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_email_list_subscribers
# ------------------------------------------------------------

CREATE TABLE `ha_email_list_subscribers` (
  `listID` int(11) NOT NULL default '0',
  `email` varchar(50) NOT NULL default '0',
  `name` varchar(100) default NULL,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`listID`,`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_email_lists
# ------------------------------------------------------------

CREATE TABLE `ha_email_lists` (
  `listID` int(11) NOT NULL auto_increment,
  `listName` varchar(100) default NULL,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`listID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_email_templates
# ------------------------------------------------------------

CREATE TABLE `ha_email_templates` (
  `templateID` int(11) NOT NULL auto_increment,
  `templateName` varchar(100) default NULL,
  `body` text,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `linkStyle` varchar(200) default NULL,
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`templateID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_emails
# ------------------------------------------------------------

CREATE TABLE `ha_emails` (
  `emailID` int(11) NOT NULL auto_increment,
  `emailName` varchar(100) default NULL,
  `emailSubject` varchar(100) default NULL,
  `bodyHTML` text,
  `bodyText` text,
  `campaignID` int(11) NOT NULL default '0',
  `templateID` int(11) default NULL,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `dateSent` timestamp NOT NULL default '0000-00-00 00:00:00',
  `listID` int(11) NOT NULL default '0',
  `deploy` tinyint(1) NOT NULL default '0',
  `deployDate` timestamp NULL default '0000-00-00 00:00:00',
  `status` enum('D','S') NOT NULL default 'D',
  `sent` int(11) unsigned NOT NULL default '0',
  `views` int(11) unsigned NOT NULL default '0',
  `clicks` int(11) unsigned NOT NULL default '0',
  `unsubscribed` int(11) unsigned NOT NULL default '0',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`emailID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_events
# ------------------------------------------------------------

CREATE TABLE `ha_events` (
  `eventID` int(11) NOT NULL auto_increment,
  `eventTitle` varchar(100) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `eventDate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `eventEnd` timestamp NOT NULL default '0000-00-00 00:00:00',
  `time` varchar(100) collate utf8_unicode_ci default NULL,
  `location` varchar(200) collate utf8_unicode_ci default NULL,
  `description` text collate utf8_unicode_ci,
  `excerpt` text collate utf8_unicode_ci,
  `userID` int(11) default NULL,
  `groupID` int(11) NOT NULL default '0',
  `tags` varchar(250) collate utf8_unicode_ci default NULL,
  `published` tinyint(1) unsigned NOT NULL default '1',
  `featured` tinyint(1) unsigned default '0',  
  `deleted` tinyint(1) unsigned default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`eventID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_file_folders
# ------------------------------------------------------------

CREATE TABLE `ha_file_folders` (
  `folderID` int(11) unsigned NOT NULL auto_increment,
  `parentID` int(11) unsigned NOT NULL default '0',
  `folderName` varchar(50) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `folderOrder` int(11) default NULL,
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`folderID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_files
# ------------------------------------------------------------

CREATE TABLE `ha_files` (
  `fileID` int(11) NOT NULL auto_increment,
  `fileRef` varchar(100) collate utf8_unicode_ci default NULL,
  `filename` varchar(100) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `folderID` int(11) NOT NULL default '0',
  `userID` int(11) default NULL,
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `filesize` int(11) NOT NULL default '0',
  `downloads` int(11) NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`fileID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_forums
# ------------------------------------------------------------

CREATE TABLE `ha_forums` (
  `forumID` int(11) unsigned NOT NULL auto_increment,
  `forumName` varchar(100) collate utf8_unicode_ci default NULL,
  `catID` int(11) default NULL,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `description` text collate utf8_unicode_ci,
  `topics` int(10) unsigned NOT NULL default '0',
  `replies` int(10) unsigned NOT NULL default '0',
  `lastPostID` int(11) default NULL,
  `private` tinyint(1) unsigned NOT NULL default '0',
  `groupID` int(11) default NULL,
  `active` tinyint(1) unsigned NOT NULL default '1',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`forumID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_forums_cats
# ------------------------------------------------------------

CREATE TABLE `ha_forums_cats` (
  `catID` int(11) unsigned NOT NULL auto_increment,
  `parentID` int(11) unsigned NOT NULL default '0',
  `catName` varchar(50) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `catOrder` int(11) default NULL,
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`catID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_forums_posts
# ------------------------------------------------------------

CREATE TABLE `ha_forums_posts` (
  `postID` int(11) unsigned NOT NULL auto_increment,
  `topicID` int(11) unsigned NOT NULL default '0',
  `body` text collate utf8_unicode_ci,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `userID` int(11) default NULL,
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`postID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_forums_subs
# ------------------------------------------------------------

CREATE TABLE `ha_forums_subs` (
  `topicID` int(11) NOT NULL default '0',
  `userID` int(11) NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`topicID`,`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_forums_topics
# ------------------------------------------------------------

CREATE TABLE `ha_forums_topics` (
  `topicID` int(11) unsigned NOT NULL auto_increment,
  `forumID` int(11) unsigned NOT NULL default '0',
  `topicTitle` varchar(50) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default '0000-00-00 00:00:00',
  `replies` int(11) unsigned NOT NULL default '0',
  `views` int(11) unsigned NOT NULL default '0',
  `userID` int(11) default NULL,
  `lastPostID` int(11) default NULL,
  `sticky` tinyint(1) unsigned NOT NULL default '0',
  `locked` tinyint(1) NOT NULL default '0',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`topicID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_image_folders
# ------------------------------------------------------------

CREATE TABLE `ha_image_folders` (
  `folderID` int(11) unsigned NOT NULL auto_increment,
  `parentID` int(11) unsigned NOT NULL default '0',
  `folderName` varchar(100) collate utf8_unicode_ci default NULL,
  `folderSafe` varchar(100) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `folderOrder` int(11) default NULL,
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`folderID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_images
# ------------------------------------------------------------

CREATE TABLE `ha_images` (
  `imageID` int(11) NOT NULL auto_increment,
  `imageRef` varchar(100) collate utf8_unicode_ci default NULL,
  `filename` varchar(100) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `imageName` varchar(100) collate utf8_unicode_ci default NULL,
  `folderID` int(11) NOT NULL default '0',
  `groupID` int(11) NOT NULL default '0',
  `userID` int(11) default NULL,
  `class` varchar(100) collate utf8_unicode_ci default NULL,
  `filesize` int(11) NOT NULL default '0',
  `maxsize` int(11) default NULL,
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`imageID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_include_versions
# ------------------------------------------------------------

CREATE TABLE `ha_include_versions` (
  `versionID` int(11) NOT NULL auto_increment,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `objectID` int(11) default NULL,
  `userID` int(11) default NULL,
  `body` longtext collate utf8_unicode_ci,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`versionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_includes
# ------------------------------------------------------------

CREATE TABLE `ha_includes` (
  `includeID` int(11) NOT NULL auto_increment,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `versionID` int(11) NOT NULL default '0',
  `includeRef` varchar(100) collate utf8_unicode_ci default NULL,
  `type` enum('H','C','J') collate utf8_unicode_ci NOT NULL default 'H',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`includeID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_navigation
# ------------------------------------------------------------

CREATE TABLE `ha_navigation` (
  `navID` int(11) NOT NULL auto_increment,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `navName` varchar(100) collate utf8_unicode_ci default NULL,
  `uri` varchar(100) collate utf8_unicode_ci default '',
  `parentID` int(11) NOT NULL default '0',
  `navOrder` int(11) default NULL,
  `active` tinyint(1) NOT NULL default '1',
  `siteID` int(11) NOT NULL default '0',
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`navID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_page_blocks
# ------------------------------------------------------------

CREATE TABLE `ha_page_blocks` (
  `blockID` int(11) NOT NULL auto_increment,
  `pageID` int(11) default NULL,
  `versionID` int(11) NOT NULL default '0',
  `blockRef` varchar(50) collate utf8_unicode_ci default NULL,
  `body` text collate utf8_unicode_ci,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `siteID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`blockID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_page_versions
# ------------------------------------------------------------

CREATE TABLE `ha_page_versions` (
  `versionID` int(11) NOT NULL auto_increment,
  `pageID` int(11) default NULL,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `userID` int(11) default NULL,
  `published` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`versionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_pages
# ------------------------------------------------------------

CREATE TABLE `ha_pages` (
  `pageID` int(11) NOT NULL auto_increment,
  `versionID` int(11) NOT NULL default '0',
  `pageName` varchar(100) character set utf8 default NULL,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `datePublished` timestamp NOT NULL default '0000-00-00 00:00:00',
  `title` varchar(100) character set utf8 NOT NULL default '',
  `active` tinyint(1) NOT NULL default '0',
  `uri` varchar(100) character set utf8 NOT NULL default '',
  `draftID` int(11) default NULL,
  `templateID` int(11) default NULL,
  `parentID` int(11) NOT NULL default '0',
  `pageOrder` int(11) NOT NULL default '0',
  `keywords` varchar(255) character set utf8 default NULL,
  `description` varchar(255) character set utf8 default NULL,
  `redirect` varchar(255) collate utf8_unicode_ci default NULL,
  `userID` int(11) default NULL,
  `groupID` int(11) default NULL,
  `navigation` tinyint(1) NOT NULL default '1',
  `views` int(11) unsigned NOT NULL default '0',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pageID`),
  KEY `uri` (`uri`),
  KEY `active` (`active`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_permission_groups
# ------------------------------------------------------------

CREATE TABLE `ha_permission_groups` (
  `groupID` int(11) NOT NULL auto_increment,
  `groupName` varchar(200) collate utf8_unicode_ci default NULL,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`groupID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `ha_permission_groups` WRITE;
/*!40000 ALTER TABLE `ha_permission_groups` DISABLE KEYS */;
INSERT INTO `ha_permission_groups` (`groupID`,`groupName`,`siteID`)
VALUES
	(-1,'Superuser',0);

/*!40000 ALTER TABLE `ha_permission_groups` ENABLE KEYS */;
UNLOCK TABLES;



# Dump of table ha_permission_map
# ------------------------------------------------------------

CREATE TABLE `ha_permission_map` (
  `groupID` int(11) NOT NULL default '0',
  `permissionID` int(11) NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`groupID`,`permissionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_permissions
# ------------------------------------------------------------

CREATE TABLE `ha_permissions` (
  `permissionID` int(11) NOT NULL auto_increment,
  `permission` varchar(200) collate utf8_unicode_ci default NULL,
  `key` varchar(100) collate utf8_unicode_ci default NULL,
  `category` varchar(100) collate utf8_unicode_ci default NULL,
  `special` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`permissionID`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `ha_permissions` WRITE;
/*!40000 ALTER TABLE `ha_permissions` DISABLE KEYS */;
INSERT INTO `ha_permissions` (`permission`,`key`,`category`,`special`)
VALUES
	('Allow Pages','pages','Pages',0),
	('Add / edit pages','pages_edit','Pages',0),
	('Delete pages','pages_delete','Pages',0),
	('Access to all pages','pages_all','Pages',0),
	('Allow Templates','pages_templates','Templates',0),
	('Allow Web Forms','webforms','Web Forms',0),
	('Delete tickets','webforms_tickets','Web Forms',0),
	('Add / edit web forms','webforms_edit','Web Forms',0),
	('Delete web forms','webforms_delete','Web Forms',0),
	('Allow image uploads','images','Uploads',0),
	('Allow file uploads','files','Uploads',0),
	('Access to all images','images_all','Uploads',0),
	('Access to all files','files_all','Uploads',0),
	('Allow Users','users','Users',0),
	('Add / edit users','users_edit','Users',0),
	('Delete users','users_delete','Users',0),
	('Import / export users','users_import','Users',0),
	('Edit permission groups','users_groups','Users',0),
	('Allow Blog','blog','Blog',0),
	('Add / edit posts','blog_edit','Blog',0),
	('Add / edit categories','blog_cats','Blog',0),
	('Access to all posts','blog_all','Blog',0),
	('Delete posts','blog_delete','Blog',0),
	('Allow Shop','shop','Shop',0),
	('Add / edit products','shop_edit','Shop',0),
	('Delete products','shop_delete','Shop',0),
	('Add / edit categories','shop_cats','Shop',0),
	('Add / edit orders','shop_orders','Shop',0),
	('Access to all products','shop_all','Shop',0),
	('View subscriptions','shop_subscriptions','Shop',0),
	('Add / edit shipping','shop_shipping','Shop',0),
	('Add / edit reviews','shop_reviews','Shop',0),
	('Add / edit discounts','shop_discounts','Shop',0),
	('Add / edit upsells', 'shop_upsells', 'Shop', 0),
	('Access Events','events','Events',0),
	('Add / edit events','events_edit','Events',0),
	('Delete events','events_delete','Events',0),
	('Access Forums','forums','Forums',0),
	('Add / edit boards','forums_edit','Forums',0),
	('Delete boards','forums_delete','Forums',0),
	('Add / edit categories','forums_cats','Forums',0),
	('Allow Community','community','Community',0),
	('Allow Wiki','wiki','Wiki',0),
	('Add / edit pages','wiki_edit','Wiki',0),
	('Add / edit categories','wiki_cats','Wiki',0),
	('Emailer','emailer','Emailer',0),
	('Add / edit campaigns','emailer_campaigns_edit','Emailer',0),
	('Delete campaigns','emailer_campaigns_delete','Emailer',0),
	('Add /edit emails','emailer_edit','Emailer',0),
	('Delete emails','emailer_delete','Emailer',0),
	('Add / edit templates','emailer_templates','Emailer',0),
	('Add / edit lists','emailer_lists','Emailer',0);

	
/*!40000 ALTER TABLE `ha_permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ha_ratings
# ------------------------------------------------------------

CREATE TABLE `ha_ratings` (
  `ratingID` int(11) NOT NULL auto_increment,
  `objectID` int(11) default NULL,
  `table` varchar(50) collate utf8_unicode_ci default NULL,
  `rating` int(11) default NULL,
  `userID` int(11) default NULL,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`ratingID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_shop_bands
# ------------------------------------------------------------

CREATE TABLE `ha_shop_bands` (
  `bandID` int(11) NOT NULL auto_increment,
  `bandName` varchar(100) collate utf8_unicode_ci default NULL,
  `multiplier` double default NULL,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`bandID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_shop_catmap
# ------------------------------------------------------------

CREATE TABLE `ha_shop_catmap` (
	`catID` int(11) NOT NULL DEFAULT '0',
	`productID` int(11) NOT NULL DEFAULT '0',
	`siteID` int(11) DEFAULT NULL,
	PRIMARY KEY (`catID`, `productID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_shop_cats
# ------------------------------------------------------------

CREATE TABLE `ha_shop_cats` (
  `catID` int(11) unsigned NOT NULL auto_increment,
  `parentID` int(11) unsigned NOT NULL default '0',
  `catName` varchar(100) collate utf8_unicode_ci default NULL,
  `catSafe` varchar(100) collate utf8_unicode_ci default NULL,
  `description` text collate utf8_unicode_ci,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default '0000-00-00 00:00:00',
  `catOrder` int(11) default NULL,
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`catID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_shop_discounts
# ------------------------------------------------------------

CREATE TABLE `ha_shop_discounts` (
  `discountID` int(11) NOT NULL auto_increment,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `expiryDate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `code` varchar(50) collate utf8_unicode_ci default NULL,
  `discount` double default NULL,
  `type` enum('T','P','C') collate utf8_unicode_ci NOT NULL default 'T',
  `objectID` text collate utf8_unicode_ci,
  `modifier` enum('A','P') collate utf8_unicode_ci NOT NULL default 'A',
  `base` enum('T','P') collate utf8_unicode_ci NOT NULL default 'T',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`discountID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_shop_modifiers
# ------------------------------------------------------------

CREATE TABLE `ha_shop_modifiers` (
  `modifierID` int(11) NOT NULL auto_increment,
  `modifierName` varchar(100) collate utf8_unicode_ci default NULL,
  `bandID` int(11) default NULL,
  `multiplier` double default NULL,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`modifierID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_shop_orders
# ------------------------------------------------------------

CREATE TABLE `ha_shop_orders` (
  `orderID` int(11) unsigned NOT NULL auto_increment,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `transactionID` int(11) NOT NULL default '0',
  `productID` int(11) NOT NULL default '0',
  `quantity` tinyint(4) NOT NULL default '0',
  `key` text collate utf8_unicode_ci,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`orderID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_shop_postages
# ------------------------------------------------------------

CREATE TABLE `ha_shop_postages` (
  `postageID` int(11) NOT NULL auto_increment,
  `total` double NOT NULL default '0',
  `cost` double NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`postageID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_shop_products
# ------------------------------------------------------------

CREATE TABLE `ha_shop_products` (
  `productID` int(11) NOT NULL auto_increment,
  `catalogueID` varchar(100) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `productOrder` int(11) NOT NULL default '0',
  `productName` varchar(100) collate utf8_unicode_ci default NULL,
  `subtitle` varchar(100) collate utf8_unicode_ci default NULL,
  `description` text collate utf8_unicode_ci,
  `excerpt` text collate utf8_unicode_ci,
  `tags` varchar(250) collate utf8_unicode_ci default NULL, 
  `price` double(10,2) NOT NULL default '0.00',
  `imageName` varchar(200) collate utf8_unicode_ci NOT NULL default 'noimage.gif',
  `status` enum('S','O','P','D') collate utf8_unicode_ci NOT NULL default 'S',
  `stock` int(11) unsigned NOT NULL default '1',  
  `fileID` int(11) default NULL,
  `views` int(11) NOT NULL default '0',
  `featured` enum('Y','T','N') collate utf8_unicode_ci NOT NULL default 'N',
  `bandID` int(11) default NULL,
  `freePostage` tinyint(1) unsigned NOT NULL default '0',
  `userID` int(11) default NULL,
  `published` tinyint(1) unsigned NOT NULL default '1',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`productID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_shop_reviews
# ------------------------------------------------------------

CREATE TABLE `ha_shop_reviews` (
  `reviewID` int(11) NOT NULL auto_increment,
  `productID` int(11) NOT NULL default '0',
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `rating` int(5) NOT NULL default '0',
  `review` text collate utf8_unicode_ci,
  `fullName` varchar(100) collate utf8_unicode_ci default NULL,
  `email` varchar(100) collate utf8_unicode_ci default NULL,
  `active` tinyint(1) NOT NULL default '1',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`reviewID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_shop_transactions
# ------------------------------------------------------------

CREATE TABLE `ha_shop_transactions` (
  `transactionID` int(11) unsigned NOT NULL auto_increment,
  `transactionCode` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `userID` int(11) NOT NULL default '0',
  `amount` double(10,2) NOT NULL default '0.00',
  `postage` double(10,2) default NULL,
  `paid` tinyint(1) unsigned NOT NULL default '0',
  `trackingStatus` enum('U','L','A','O','D') collate utf8_unicode_ci NOT NULL default 'U',
  `discounts` double(10,2) NOT NULL default '0.00',
  `donation` double(10,2) NOT NULL default '0.00',
  `tax` double(10,2) NOT NULL default '0.00',
  `discountCode` varchar(50) collate utf8_unicode_ci default NULL,
  `notes` text collate utf8_unicode_ci,
  `expiryDate` timestamp NOT NULL default '0000-00-00 00:00:00',
  `viewed` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`transactionID`),
  KEY `transactionCode` (`transactionCode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_shop_upsells
# ------------------------------------------------------------

CREATE TABLE `ha_shop_upsells` (
  `upsellID` int(11) unsigned NOT NULL auto_increment,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NULL default CURRENT_TIMESTAMP,
  `type` enum('V','N','P') collate utf8_unicode_ci NOT NULL default 'V',
  `value` double(10,2) default NULL,
  `numProducts` int(11) default NULL,
  `productIDs` varchar(200) collate utf8_unicode_ci default NULL,
  `productID` int(11) default NULL,
  `upsellOrder` int(11) default NULL,
  `remove` tinyint(1) unsigned NOT NULL default '0',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`upsellID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_shop_variations
# ------------------------------------------------------------

CREATE TABLE `ha_shop_variations` (
  `variationID` int(11) unsigned NOT NULL auto_increment,
  `variation` varchar(50) collate utf8_unicode_ci default NULL,
  `price` double(10,2) NOT NULL default '0.00',
  `type` int(11) default NULL,
  `productID` int(11) default NULL,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`variationID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_sites
# ------------------------------------------------------------

CREATE TABLE `ha_sites` (
  `siteID` int(11) NOT NULL auto_increment,
  `siteDomain` varchar(100) collate utf8_unicode_ci default NULL,
  `altDomain` varchar(100) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `siteName` varchar(100) collate utf8_unicode_ci default NULL,
  `siteEmail` varchar(100) collate utf8_unicode_ci default NULL,
  `siteURL` varchar(100) collate utf8_unicode_ci default NULL,
  `siteTel` varchar(100) collate utf8_unicode_ci default NULL,
  `siteAddress` text collate utf8_unicode_ci,
  `siteCountry` varchar(100) collate utf8_unicode_ci default NULL,
  `groupID` int(11) default NULL,
  `plan` int(11) NOT NULL default '0',
  `quota` int(11) unsigned NOT NULL default '0',
  `paging` int(11) NOT NULL default '20',
  `theme` varchar(50) collate utf8_unicode_ci default NULL,
  `shopEmail` varchar(100) collate utf8_unicode_ci default NULL,
  `shopItemsPerPage` int(11) NOT NULL default '6',
  `shopItemsPerRow` int(11) NOT NULL default '3',
  `shopFreePostage` tinyint(1) NOT NULL default '0',
  `shopShippingTable` varchar(250) collate utf8_unicode_ci default NULL,
  `shopFreePostageRate` int(11) default NULL,
  `shopGateway` varchar(50) collate utf8_unicode_ci NOT NULL default 'paypal',
  `shopVariation1` varchar(50) collate utf8_unicode_ci default NULL,
  `shopVariation2` varchar(50) collate utf8_unicode_ci default NULL,
  `shopVariation3` varchar(50) collate utf8_unicode_ci default NULL,
  `shopStockControl` tinyint(1) NOT NULL default '0',
  `shopTax` tinyint(2) NOT NULL default '0',
  `shopTaxRate` double NOT NULL default '0',
  `shopTaxState` varchar(3) collate utf8_unicode_ci default NULL,
  `shopAPIKey` varchar(100) collate utf8_unicode_ci default NULL,
  `shopAPIUser` varchar(50) collate utf8_unicode_ci default NULL,
  `shopAPIPass` varchar(50) collate utf8_unicode_ci default NULL,
  `shopVendor` varchar(50) collate utf8_unicode_ci default NULL,
  `emailerEmail` varchar(100) collate utf8_unicode_ci default NULL,
  `emailerName` varchar(100) collate utf8_unicode_ci default NULL,
  `currency` varchar(4) collate utf8_unicode_ci NOT NULL default 'USD',
  `dateFmt` varchar(50) collate utf8_unicode_ci default NULL,
  `dateOrder` enum('DM','MD') collate utf8_unicode_ci NOT NULL default 'DM',
  `headlines` int(11) NOT NULL default '3',
  `clientID` int(11) default NULL,
  `emailHeader` text collate utf8_unicode_ci,
  `emailFooter` text collate utf8_unicode_ci,
  `emailTicket` text collate utf8_unicode_ci,
  `emailOrder` text collate utf8_unicode_ci,
  `emailAccount` text collate utf8_unicode_ci,
  `emailDispatch` text collate utf8_unicode_ci,
  `emailDonation` text collate utf8_unicode_ci,
  `emailSubscription` text collate utf8_unicode_ci,
  `timezone` varchar(5) collate utf8_unicode_ci NOT NULL default 'UTC',
  `subscriptionAction` int(11) default NULL,
  `activation` tinyint(1) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`siteID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_sub_payments
# ------------------------------------------------------------

CREATE TABLE `ha_sub_payments` (
  `paymentID` int(11) NOT NULL auto_increment,
  `referenceID` char(50) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `amount` double default NULL,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`paymentID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED;



# Dump of table ha_subscribers
# ------------------------------------------------------------

CREATE TABLE `ha_subscribers` (
  `subscriberID` int(11) NOT NULL auto_increment,
  `subscriptionID` int(11) default NULL,
  `referenceID` varchar(50) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NULL default '0000-00-00 00:00:00',
  `lastPayment` timestamp NULL default '0000-00-00 00:00:00',
  `fullName` varchar(50) collate utf8_unicode_ci default NULL,
  `email` varchar(100) collate utf8_unicode_ci default NULL,
  `address` text collate utf8_unicode_ci,
  `postcode` varchar(10) collate utf8_unicode_ci default NULL,
  `country` varchar(100) collate utf8_unicode_ci default NULL,
  `userID` int(11) default NULL,
  `active` tinyint(1) NOT NULL default '1',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`subscriberID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_subscriptions
# ------------------------------------------------------------

CREATE TABLE `ha_subscriptions` (
  `subscriptionID` int(11) NOT NULL auto_increment,
  `subscriptionRef` varchar(100) collate utf8_unicode_ci default NULL,
  `cgCode` varchar(100) collate utf8_unicode_ci default NULL,
  `cgProduct` varchar(100) collate utf8_unicode_ci default NULL,
  `subscriptionName` varchar(50) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default '0000-00-00 00:00:00',
  `description` text collate utf8_unicode_ci,
  `price` double default NULL,
  `currency` varchar(3) collate utf8_unicode_ci default NULL,
  `term` enum('M','Y') collate utf8_unicode_ci NOT NULL default 'M',
  `active` tinyint(1) NOT NULL default '1',
  `deleted` tinyint(1) NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`subscriptionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_tags
# ------------------------------------------------------------

CREATE TABLE `ha_tags` (
  `id` int(11) NOT NULL auto_increment,
  `safe_tag` varchar(30) collate utf8_unicode_ci NOT NULL default '',
  `tag` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `safe_tag` (`safe_tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_tags_ref
# ------------------------------------------------------------

CREATE TABLE `ha_tags_ref` (
  `tag_id` int(10) unsigned NOT NULL default '0',
  `row_id` int(10) unsigned NOT NULL default '0',
  `date` timestamp NOT NULL default '0000-00-00 00:00:00',
  `table` varchar(20) collate utf8_unicode_ci NOT NULL default '',
  `siteID` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_template_versions
# ------------------------------------------------------------

CREATE TABLE `ha_template_versions` (
  `versionID` int(11) NOT NULL auto_increment,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `objectID` int(11) default NULL,
  `userID` int(11) default NULL,
  `body` text collate utf8_unicode_ci,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`versionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_templates
# ------------------------------------------------------------

CREATE TABLE `ha_templates` (
  `templateID` int(11) NOT NULL auto_increment,
  `templateName` varchar(100) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `versionID` int(11) NOT NULL default '0',
  `modulePath` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`templateID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_tickets
# ------------------------------------------------------------

CREATE TABLE `ha_tickets` (
  `ticketID` int(11) NOT NULL auto_increment,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `formName` varchar(200) collate utf8_unicode_ci default NULL,
  `subject` varchar(100) collate utf8_unicode_ci default NULL,
  `fullName` varchar(100) collate utf8_unicode_ci default NULL,
  `email` varchar(100) collate utf8_unicode_ci default NULL,
  `body` text collate utf8_unicode_ci,
  `closed` tinyint(1) NOT NULL default '0',
  `notes` text collate utf8_unicode_ci,
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  `viewed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ticketID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_tracking
# ------------------------------------------------------------

CREATE TABLE `ha_tracking` (
  `trackingID` int(11) NOT NULL auto_increment,
  `date` timestamp NULL default '0000-00-00 00:00:00',
  `userKey` varchar(32) collate utf8_unicode_ci default NULL,
  `ipAddress` varchar(16) collate utf8_unicode_ci default NULL,
  `userAgent` varchar(100) collate utf8_unicode_ci default NULL,
  `referer` varchar(200) collate utf8_unicode_ci default NULL,
  `views` int(11) NOT NULL default '0',
  `lastPage` varchar(250) collate utf8_unicode_ci default NULL,
  `userdata` varchar(250) collate utf8_unicode_ci NOT NULL default '',
  `siteID` int(11) default '0',
  PRIMARY KEY  (`trackingID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_users
# ------------------------------------------------------------

CREATE TABLE `ha_users` (
  `userID` int(11) NOT NULL auto_increment,
  `username` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `password` varchar(32) collate utf8_unicode_ci default NULL,
  `groupID` int(11) NOT NULL default '0',
  `email` varchar(100) collate utf8_unicode_ci default NULL,
  `subscription` enum('Y','E','P','N') collate utf8_unicode_ci NOT NULL default 'Y',
  `subscribed` tinyint(1) unsigned NOT NULL default '0',
  `plan` int(11) NOT NULL default '0',
  `bounced` tinyint(1) default '0',
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `displayName` varchar(100) collate utf8_unicode_ci default NULL,
  `firstName` varchar(50) collate utf8_unicode_ci default NULL,
  `lastName` varchar(50) collate utf8_unicode_ci default NULL,
  `address1` varchar(100) collate utf8_unicode_ci default NULL,
  `address2` varchar(100) collate utf8_unicode_ci default NULL,
  `address3` varchar(100) collate utf8_unicode_ci default NULL,
  `city` varchar(100) collate utf8_unicode_ci default NULL,
  `state` varchar(50) collate utf8_unicode_ci default NULL,
  `postcode` varchar(8) collate utf8_unicode_ci default NULL,
  `country` varchar(100) collate utf8_unicode_ci default NULL,
  `currency` varchar(4) collate utf8_unicode_ci NOT NULL default 'USD',
  `billingAddress1` varchar(100) collate utf8_unicode_ci default NULL,
  `billingAddress2` varchar(100) collate utf8_unicode_ci default NULL,
  `billingAddress3` varchar(100) collate utf8_unicode_ci default NULL,
  `billingCity` varchar(100) collate utf8_unicode_ci default NULL,
  `billingState` varchar(50) collate utf8_unicode_ci default NULL,
  `billingPostcode` varchar(8) collate utf8_unicode_ci default NULL,
  `billingCountry` varchar(100) collate utf8_unicode_ci default NULL,
  `phone` varchar(20) collate utf8_unicode_ci default NULL,
  `avatar` varchar(50) collate utf8_unicode_ci default NULL,
  `signature` text collate utf8_unicode_ci,
  `bio` text collate utf8_unicode_ci NOT NULL,
  `companyName` varchar(100) collate utf8_unicode_ci default NULL,
  `companyEmail` varchar(100) collate utf8_unicode_ci default NULL,
  `companyWebsite` varchar(100) collate utf8_unicode_ci default NULL,
  `companyDescription` text collate utf8_unicode_ci,
  `companyLogo` varchar(50) collate utf8_unicode_ci default NULL,
  `language` varchar(50) collate utf8_unicode_ci NOT NULL default 'english',
  `posts` int(11) unsigned NOT NULL default '0',
  `kudos` int(11) NOT NULL default '0',
  `notifications` tinyint(1) unsigned NOT NULL default '1',
  `privacy` enum('V','F','H') collate utf8_unicode_ci NOT NULL default 'V',
  `resetkey` varchar(32) collate utf8_unicode_ci default NULL,
  `lastLogin` timestamp NOT NULL default '0000-00-00 00:00:00',
  `custom1` varchar(250) collate utf8_unicode_ci default NULL,
  `custom2` varchar(250) collate utf8_unicode_ci default NULL,
  `custom3` varchar(250) collate utf8_unicode_ci default NULL,
  `custom4` text collate utf8_unicode_ci,
  `active` tinyint(1) unsigned NOT NULL default '1',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`userID`),
  KEY `emailindex` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `ha_users` WRITE;
/*!40000 ALTER TABLE `ha_users` DISABLE KEYS */;
INSERT INTO `ha_users` (`userID`,`username`,`password`,`groupID`,`email`,`subscription`,`subscribed`,`bounced`,`dateCreated`,`dateModified`,`displayName`,`firstName`,`lastName`,`address1`,`address2`,`address3`,`city`,`state`,`postcode`,`country`,`currency`,`billingAddress1`,`billingAddress2`,`billingAddress3`,`billingCity`,`billingState`,`billingPostcode`,`billingCountry`,`phone`,`avatar`,`signature`,`bio`,`companyName`,`companyEmail`,`companyWebsite`,`companyDescription`,`companyLogo`,`language`,`posts`,`kudos`,`notifications`,`privacy`,`resetkey`,`lastLogin`,`custom1`,`custom2`,`custom3`,`custom4`,`active`,`siteID`)
VALUES
	(1,'superuser','f35364bc808b079853de5a1e343e7159',-1,'','Y',0,0,NOW(),NOW(),NULL,'Admin',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'USD',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'english',0,0,1,'V',NULL,'0000-00-00 00:00:00',NULL,NULL,NULL,NULL,1,NULL);

/*!40000 ALTER TABLE `ha_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ha_web_forms
# ------------------------------------------------------------

CREATE TABLE `ha_web_forms` (
  `formID` int(11) NOT NULL auto_increment,
  `dateCreated` timestamp NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `formName` varchar(200) collate utf8_unicode_ci default NULL,
  `formRef` varchar(200) collate utf8_unicode_ci default NULL,
  `fieldSet` tinyint(4) unsigned NOT NULL default '0',
  `captcha` tinyint(1) unsigned NOT NULL default '0',
  `account` tinyint(1) NOT NULL default '0',
  `groupID` int(11) default NULL,
  `outcomeMessage` text collate utf8_unicode_ci,
  `outcomeEmails` text collate utf8_unicode_ci,
  `outcomeRedirect` varchar(200) collate utf8_unicode_ci default NULL,
  `fileTypes` varchar(100) collate utf8_unicode_ci default NULL,
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`formID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_wiki
# ------------------------------------------------------------

CREATE TABLE `ha_wiki` (
  `pageID` int(11) NOT NULL auto_increment,
  `pageName` varchar(100) collate utf8_unicode_ci default NULL,
  `versionID` int(11) default NULL,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `userID` int(11) default NULL,
  `catID` int(11) default NULL,
  `uri` varchar(100) character set utf8 default NULL,
  `active` tinyint(1) unsigned NOT NULL default '1',
  `groupID` int(11) NOT NULL default '0',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`pageID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_wiki_cats
# ------------------------------------------------------------

CREATE TABLE `ha_wiki_cats` (
  `catID` int(11) unsigned NOT NULL auto_increment,
  `parentID` int(11) unsigned NOT NULL default '0',
  `catName` varchar(50) collate utf8_unicode_ci default NULL,
  `dateCreated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateModified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `description` text collate utf8_unicode_ci,
  `catOrder` int(11) default NULL,
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`catID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table ha_wiki_versions
# ------------------------------------------------------------

CREATE TABLE `ha_wiki_versions` (
  `versionID` int(11) NOT NULL auto_increment,
  `pageID` int(11) NOT NULL default '0',
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `userID` int(11) default NULL,
  `body` text collate utf8_unicode_ci,
  `notes` varchar(250) collate utf8_unicode_ci default NULL,
  `siteID` int(11) default NULL,
  PRIMARY KEY  (`versionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;








/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
