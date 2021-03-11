-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 31, 2018 at 04:06 PM
-- Server version: 5.7.23-0ubuntu0.18.04.1
-- PHP Version: 7.2.7-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_comunicatec0`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_tokens`
--

CREATE TABLE `login_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` char(32) NOT NULL,
  `duration` varchar(32) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `expires` datetime NOT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `scheduled_emails`
--

CREATE TABLE `scheduled_emails` (
  `id` int(11) NOT NULL,
  `user_email_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `user_group_id` varchar(256) DEFAULT NULL,
  `cc_to` text,
  `from_name` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `from_email` varchar(200) DEFAULT NULL,
  `subject` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `message` text CHARACTER SET utf8,
  `schedule_date` datetime DEFAULT NULL,
  `is_sent` int(1) NOT NULL DEFAULT '0',
  `scheduled_by` int(11) DEFAULT NULL COMMENT 'user_id',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scheduled_email_recipients`
--

CREATE TABLE `scheduled_email_recipients` (
  `id` int(11) NOT NULL,
  `scheduled_email_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email_address` varchar(100) NOT NULL,
  `is_email_sent` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_options`
--

CREATE TABLE `setting_options` (
  `id` int(11) NOT NULL,
  `title` varchar(256) CHARACTER SET utf8 NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_options`
--

INSERT INTO `setting_options` (`id`, `title`, `created`, `modified`) VALUES
(1, 'Tinymce', '2018-08-29 14:37:15', '2018-08-29 14:37:15'),
(2, 'Ckeditor', '2018-08-29 14:37:15', '2018-08-29 14:37:15');

-- --------------------------------------------------------

--
-- Table structure for table `static_pages`
--

CREATE TABLE `static_pages` (
  `id` int(11) NOT NULL,
  `page_name` text CHARACTER SET utf8,
  `url_name` text CHARACTER SET utf8,
  `page_content` text CHARACTER SET utf8,
  `page_title` text CHARACTER SET utf8,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_group_id` varchar(256) DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `gender` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `photo` varchar(50) DEFAULT NULL,
  `bday` date DEFAULT NULL,
  `active` int(1) DEFAULT '0',
  `email_verified` int(1) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_group_id`, `username`, `password`, `email`, `first_name`, `last_name`, `gender`, `photo`, `bday`, `active`, `email_verified`, `last_login`, `ip_address`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, '1', 'admin', '$2y$10$.dezXbhZdar0R0YWE45R3.NshUKQn6OXXqlWdcJe1tevJSWo469ei', 'admin@admin.com', 'Admin', '', NULL, NULL, NULL, 1, 1, '2018-08-31 06:53:16', NULL, '2018-08-29 14:37:15', '2018-08-31 06:53:16', NULL, NULL),
(2, '2', 'user1', '$2y$10$kDxUcrmbT0bY0xyd22ZyluF5OGXug0yLcYoZSkxOPSJbRA8iSa1Um', 'usuario@conecattec.com', 'usuario1', 'usuario1', NULL, NULL, NULL, 1, 1, '2018-08-31 06:42:25', NULL, '2018-08-30 10:33:24', '2018-08-31 06:42:25', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `id` int(11) NOT NULL,
  `useragent` varchar(256) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `last_action` int(11) NOT NULL,
  `last_url` text,
  `user_browser` text,
  `ip_address` varchar(50) DEFAULT NULL,
  `logout` int(11) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_activities`
--

INSERT INTO `user_activities` (`id`, `useragent`, `user_id`, `last_action`, `last_url`, `user_browser`, `ip_address`, `logout`, `deleted`, `created`, `modified`) VALUES
(15, 'defbea28256fbd40060b745542db8836', 2, 1535706928, '/dashboard', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:61.0) Gecko/20100101 Firefox/61.0', '192.168.1.85', 0, 0, '2018-08-31 05:15:28', '2018-08-31 05:15:28'),
(18, 'defbea28256fbd40060b745542db8836891lh6nfdfdjopsa8s8564v4ra', 2, 1535707102, '/dashboard', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:61.0) Gecko/20100101 Firefox/61.0', '192.168.1.85', 0, 0, '2018-08-31 05:18:22', '2018-08-31 05:18:22'),
(17, 'defbea28256fbd40060b745542db8836031hc402jko5ve3jnd67cs0s4f', 2, 1535707081, '/dashboard', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:61.0) Gecko/20100101 Firefox/61.0', '192.168.1.85', 0, 0, '2018-08-31 05:17:31', '2018-08-31 05:18:01'),
(24, 'defbea28256fbd40060b745542db8836h9b4j0v85aifhk65e9u4qml892', 1, 1535712796, '/dashboard', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:61.0) Gecko/20100101 Firefox/61.0', '192.168.1.85', 0, 0, '2018-08-31 06:53:16', '2018-08-31 06:53:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_contacts`
--

CREATE TABLE `user_contacts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `requirement` text CHARACTER SET utf8,
  `reply_message` text CHARACTER SET utf8,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `location` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `cellphone` varchar(15) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `location`, `cellphone`, `created`, `modified`) VALUES
(1, 1, NULL, NULL, '2018-08-29 14:37:16', '2018-08-29 14:37:16'),
(2, 2, NULL, NULL, '2018-08-30 10:33:24', '2018-08-30 10:33:24');

-- --------------------------------------------------------

--
-- Table structure for table `user_emails`
--

CREATE TABLE `user_emails` (
  `id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `user_group_id` varchar(256) DEFAULT NULL,
  `cc_to` text,
  `from_name` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `from_email` varchar(200) DEFAULT NULL,
  `subject` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `message` text CHARACTER SET utf8,
  `sent_by` int(11) DEFAULT NULL COMMENT 'user_id',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_email_recipients`
--

CREATE TABLE `user_email_recipients` (
  `id` int(11) NOT NULL,
  `user_email_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email_address` varchar(100) NOT NULL,
  `is_email_sent` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_email_signatures`
--

CREATE TABLE `user_email_signatures` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `signature_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `signature` text CHARACTER SET utf8,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_email_templates`
--

CREATE TABLE `user_email_templates` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `template_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `header` text CHARACTER SET utf8,
  `footer` text CHARACTER SET utf8,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8,
  `registration_allowed` int(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `parent_id`, `name`, `description`, `registration_allowed`, `created`, `modified`) VALUES
(1, 0, 'Admin', NULL, 0, '2018-08-29 14:37:16', '2018-08-29 14:37:16'),
(2, 0, 'User', '', 1, '2018-08-29 14:37:16', '2018-08-30 10:41:18'),
(3, 0, 'Guest', NULL, 0, '2018-08-29 14:37:16', '2018-08-29 14:37:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_group_permissions`
--

CREATE TABLE `user_group_permissions` (
  `id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `prefix` varchar(256) DEFAULT NULL,
  `plugin` varchar(50) DEFAULT NULL,
  `controller` varchar(50) NOT NULL,
  `action` varchar(100) NOT NULL,
  `allowed` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_group_permissions`
--

INSERT INTO `user_group_permissions` (`id`, `user_group_id`, `prefix`, `plugin`, `controller`, `action`, `allowed`) VALUES
(1, 1, NULL, NULL, 'Pages', 'display', 1),
(2, 2, NULL, NULL, 'Pages', 'display', 1),
(3, 3, NULL, NULL, 'Pages', 'display', 1),
(4, 1, NULL, 'Usermgmt', 'Autocomplete', 'fetch', 1),
(5, 2, NULL, 'Usermgmt', 'Autocomplete', 'fetch', 0),
(6, 1, NULL, 'Usermgmt', 'StaticPages', 'index', 1),
(7, 1, NULL, 'Usermgmt', 'StaticPages', 'add', 1),
(8, 1, NULL, 'Usermgmt', 'StaticPages', 'edit', 1),
(9, 1, NULL, 'Usermgmt', 'StaticPages', 'view', 1),
(10, 1, NULL, 'Usermgmt', 'StaticPages', 'delete', 1),
(11, 1, NULL, 'Usermgmt', 'StaticPages', 'preview', 1),
(12, 1, NULL, 'Usermgmt', 'UserContacts', 'index', 1),
(13, 1, NULL, 'Usermgmt', 'UserContacts', 'contactUs', 1),
(14, 2, NULL, 'Usermgmt', 'UserContacts', 'contactUs', 0),
(15, 3, NULL, 'Usermgmt', 'UserContacts', 'contactUs', 1),
(16, 1, NULL, 'Usermgmt', 'UserContacts', 'sendReply', 1),
(17, 2, NULL, 'Usermgmt', 'StaticPages', 'preview', 1),
(18, 3, NULL, 'Usermgmt', 'StaticPages', 'preview', 1),
(19, 1, NULL, 'Usermgmt', 'UserEmails', 'index', 1),
(20, 1, NULL, 'Usermgmt', 'UserEmails', 'send', 1),
(21, 1, NULL, 'Usermgmt', 'UserEmails', 'sendToUser', 1),
(22, 1, NULL, 'Usermgmt', 'UserEmails', 'view', 1),
(23, 1, NULL, 'Usermgmt', 'UserEmails', 'searchEmails', 1),
(24, 1, NULL, 'Usermgmt', 'UserEmailSignatures', 'index', 1),
(25, 1, NULL, 'Usermgmt', 'UserEmailSignatures', 'add', 1),
(26, 1, NULL, 'Usermgmt', 'UserEmailSignatures', 'edit', 1),
(27, 1, NULL, 'Usermgmt', 'UserEmailSignatures', 'delete', 1),
(28, 1, NULL, 'Usermgmt', 'UserEmailTemplates', 'index', 1),
(29, 1, NULL, 'Usermgmt', 'UserEmailTemplates', 'add', 1),
(30, 1, NULL, 'Usermgmt', 'UserEmailTemplates', 'edit', 1),
(31, 1, NULL, 'Usermgmt', 'UserEmailTemplates', 'delete', 1),
(32, 1, NULL, 'Usermgmt', 'UserGroupPermissions', 'permissionGroupMatrix', 1),
(33, 1, NULL, 'Usermgmt', 'UserGroupPermissions', 'permissionSubGroupMatrix', 1),
(34, 1, NULL, 'Usermgmt', 'UserGroupPermissions', 'changePermission', 1),
(35, 1, NULL, 'Usermgmt', 'UserGroupPermissions', 'getPermissions', 1),
(36, 2, NULL, 'Usermgmt', 'UserGroupPermissions', 'getPermissions', 0),
(37, 3, NULL, 'Usermgmt', 'UserGroupPermissions', 'getPermissions', 0),
(38, 1, NULL, 'Usermgmt', 'UserGroups', 'index', 1),
(39, 1, NULL, 'Usermgmt', 'UserGroups', 'add', 1),
(40, 1, NULL, 'Usermgmt', 'UserGroups', 'edit', 1),
(41, 1, NULL, 'Usermgmt', 'UserGroups', 'delete', 1),
(42, 1, NULL, 'Usermgmt', 'Users', 'dashboard', 1),
(43, 2, NULL, 'Usermgmt', 'Users', 'dashboard', 1),
(44, 1, NULL, 'Usermgmt', 'Users', 'index', 1),
(45, 1, NULL, 'Usermgmt', 'Users', 'indexSearch', 1),
(46, 1, NULL, 'Usermgmt', 'Users', 'online', 1),
(47, 1, NULL, 'Usermgmt', 'Users', 'addUser', 1),
(48, 1, NULL, 'Usermgmt', 'Users', 'editUser', 1),
(49, 1, NULL, 'Usermgmt', 'Users', 'viewUser', 1),
(50, 1, NULL, 'Usermgmt', 'Users', 'deleteUser', 1),
(51, 1, NULL, 'Usermgmt', 'Users', 'setActive', 1),
(52, 1, NULL, 'Usermgmt', 'Users', 'setInactive', 1),
(53, 1, NULL, 'Usermgmt', 'Users', 'verifyEmail', 1),
(54, 1, NULL, 'Usermgmt', 'Users', 'changeUserPassword', 1),
(55, 1, NULL, 'Usermgmt', 'Users', 'logoutUser', 1),
(56, 1, NULL, 'Usermgmt', 'Users', 'viewUserPermissions', 1),
(57, 1, NULL, 'Usermgmt', 'Users', 'uploadCsv', 1),
(58, 1, NULL, 'Usermgmt', 'Users', 'addMultipleUsers', 1),
(59, 1, NULL, 'Usermgmt', 'Users', 'accessDenied', 1),
(60, 2, NULL, 'Usermgmt', 'Users', 'accessDenied', 1),
(61, 1, NULL, 'Usermgmt', 'Users', 'login', 1),
(62, 2, NULL, 'Usermgmt', 'Users', 'login', 1),
(63, 3, NULL, 'Usermgmt', 'Users', 'login', 1),
(64, 1, NULL, 'Usermgmt', 'Users', 'logout', 1),
(65, 2, NULL, 'Usermgmt', 'Users', 'logout', 1),
(66, 3, NULL, 'Usermgmt', 'Users', 'logout', 1),
(67, 1, NULL, 'Usermgmt', 'Users', 'register', 1),
(68, 2, NULL, 'Usermgmt', 'Users', 'register', 0),
(69, 3, NULL, 'Usermgmt', 'Users', 'register', 1),
(70, 1, NULL, 'Usermgmt', 'Users', 'myprofile', 1),
(71, 2, NULL, 'Usermgmt', 'Users', 'myprofile', 1),
(72, 1, NULL, 'Usermgmt', 'Users', 'editProfile', 1),
(73, 2, NULL, 'Usermgmt', 'Users', 'editProfile', 1),
(74, 1, NULL, 'Usermgmt', 'Users', 'changePassword', 1),
(75, 2, NULL, 'Usermgmt', 'Users', 'changePassword', 1),
(76, 1, NULL, 'Usermgmt', 'Users', 'deleteAccount', 1),
(77, 2, NULL, 'Usermgmt', 'Users', 'deleteAccount', 0),
(78, 1, NULL, 'Usermgmt', 'Users', 'forgotPassword', 1),
(79, 2, NULL, 'Usermgmt', 'Users', 'forgotPassword', 1),
(80, 3, NULL, 'Usermgmt', 'Users', 'forgotPassword', 1),
(81, 1, NULL, 'Usermgmt', 'Users', 'activatePassword', 1),
(82, 2, NULL, 'Usermgmt', 'Users', 'activatePassword', 1),
(83, 3, NULL, 'Usermgmt', 'Users', 'activatePassword', 1),
(84, 1, NULL, 'Usermgmt', 'Users', 'emailVerification', 1),
(85, 2, NULL, 'Usermgmt', 'Users', 'emailVerification', 1),
(86, 3, NULL, 'Usermgmt', 'Users', 'emailVerification', 1),
(87, 1, NULL, 'Usermgmt', 'Users', 'userVerification', 1),
(88, 2, NULL, 'Usermgmt', 'Users', 'userVerification', 1),
(89, 3, NULL, 'Usermgmt', 'Users', 'userVerification', 1),
(90, 1, NULL, 'Usermgmt', 'Users', 'deleteCache', 1),
(91, 1, NULL, 'Usermgmt', 'UserSettings', 'index', 1),
(92, 1, NULL, 'Usermgmt', 'UserSettings', 'editSetting', 1),
(93, 1, NULL, 'Usermgmt', 'UserSettings', 'cakelog', 1),
(94, 1, NULL, 'Usermgmt', 'UserSettings', 'cakelogbackup', 1),
(95, 1, NULL, 'Usermgmt', 'UserSettings', 'cakelogdelete', 1),
(96, 1, NULL, 'Usermgmt', 'UserSettings', 'cakelogempty', 1),
(97, 1, NULL, 'Usermgmt', 'CronJobs', 'sendScheduledEmails', 1),
(98, 1, NULL, 'Usermgmt', 'ScheduledEmails', 'index', 1),
(99, 1, NULL, 'Usermgmt', 'ScheduledEmails', 'edit', 1),
(100, 1, NULL, 'Usermgmt', 'ScheduledEmails', 'view', 1),
(101, 1, NULL, 'Usermgmt', 'ScheduledEmails', 'delete', 1),
(102, 1, NULL, 'Usermgmt', 'ScheduledEmails', 'delete_recipient', 1),
(103, 1, NULL, 'Usermgmt', 'SettingOptions', 'index', 1),
(104, 1, NULL, 'Usermgmt', 'SettingOptions', 'add', 1),
(105, 1, NULL, 'Usermgmt', 'SettingOptions', 'edit', 1),
(106, 1, NULL, 'Usermgmt', 'SettingOptions', 'delete', 1),
(107, 1, NULL, 'Usermgmt', 'UserGroupPermissions', 'printPermissionChanges', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE `user_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `display_name` varchar(1024) CHARACTER SET utf8 DEFAULT NULL,
  `value` text CHARACTER SET utf8,
  `type` varchar(50) DEFAULT NULL,
  `category` varchar(20) DEFAULT 'OTHER'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_settings`
--

INSERT INTO `user_settings` (`id`, `name`, `display_name`, `value`, `type`, `category`) VALUES
(1, 'default_time_zone', 'Enter default time zone identifier for e.g. America/New_York', 'America/New_York', 'input', 'SITE'),
(2, 'site_name', 'Enter Your Full Site Name', 'User Management Plugin', 'input', 'SITE'),
(3, 'site_name_short', 'Enter Your Short Site Name', 'UMP', 'input', 'SITE'),
(4, 'login_redirect_url', 'Enter URL where user will be redirected after login', '/dashboard', 'input', 'SITE'),
(5, 'logout_redirect_url', 'Enter URL where user will be redirected after logout', '/login', 'input', 'SITE'),
(6, 'login_cookie_name', 'Please enter login cookie name for your site which is used to login user automatically for remember me functionality', 'UMPremiumCookie', 'input', 'SITE'),
(7, 'use_https', 'Do you want to use HTTPS for whole site?', '0', 'checkbox', 'SITE'),
(8, 'https_urls', 'You can enter selected urls for HTTPS, If URL belongs to any plugin then prepend plugin name in URL, if you want to allow all actions of controller on HTTPS then use controllername/* (e.g. usermgmt/users/login, usermgmt/users/register, products/cart, payments/*)', NULL, 'input', 'SITE'),
(9, 'default_group_id', 'Enter default group id for user registration', '2', 'input', 'GROUP'),
(10, 'admin_group_id', 'Enter Admin Group Id', '1', 'input', 'GROUP'),
(11, 'guest_group_id', 'Enter Guest Group Id', '3', 'input', 'GROUP'),
(12, 'site_registration', 'Do you want to allow new registrations?', '1', 'checkbox', 'USER'),
(13, 'email_verification', 'Do you want user to verify his/her email address during registration?', '1', 'checkbox', 'EMAIL'),
(14, 'allow_delete_account', 'Do you want to allow users to delete their account', '0', 'checkbox', 'USER'),
(15, 'allow_change_username', 'Do you want to allow users to change their username?', '0', 'checkbox', 'USER'),
(16, 'banned_usernames', 'Enter banned usernames comma separated(no space, no quotes)', 'Administrator, SuperAdmin', 'input', 'USER'),
(17, 'permissions', 'Do you want to check permissions for users?', '1', 'checkbox', 'PERMISSION'),
(18, 'admin_permissions', 'Do you want to check permissions for Admin?', '0', 'checkbox', 'PERMISSION'),
(19, 'allow_user_multiple_login', 'Do you want to allow multiple logins with same user account for users(not admin)?', '1', 'checkbox', 'USER'),
(20, 'allow_admin_multiple_login', 'Do you want to allow multiple logins with same user account for admin(not users)?', '1', 'checkbox', 'USER'),
(21, 'login_idle_time', 'Set max idle time in minutes for user. This idle time will be used when multiple logins are not allowed for same user account. If max idle time reached since user last activity on the site then anyone can login with same account in other browser and idle user will be logged out.', '10', 'input', 'USER'),
(22, 'view_online_user_time', 'You can view online users and guest from last few minutes, set time in minutes ', '30', 'input', 'USER'),
(23, 'img_dir', 'Enter Image directory name where users profile photos will be uploaded. This directory should be in webroot/library directory', 'umphotos', 'input', 'USER'),
(24, 'qrdn', 'Increase this number by 1 every time if you made any changes in CSS or JS file, If you delete cache from admin then it increases automatically', '123456792', 'input', 'SITE'),
(25, 'use_remember_me', 'Do you want to show remember me feature on login page?', '1', 'checkbox', 'USER'),
(26, 'email_from_address', 'Enter From Email Address to send emails', 'test@test.com', 'input', 'EMAIL'),
(27, 'email_from_name', 'Enter From Email Name', 'User Management Plugin', 'input', 'EMAIL'),
(28, 'admin_email_address', 'Enter Admin Email Address to receive emails for e.g. contact enquiries', NULL, 'input', 'EMAIL'),
(29, 'send_registration_mail', 'Do you want to send welcome registration email to user after registration', '0', 'checkbox', 'EMAIL'),
(30, 'send_password_change_mail', 'Do you want to send password change email if users change their password', '0', 'checkbox', 'EMAIL'),
(31, 'private_key_from_recaptcha', 'Enter private key for Recaptcha from google (also known as secret key)', NULL, 'input', 'RECAPTCHA'),
(32, 'public_key_from_recaptcha', 'Enter public key for recaptcha from google (also known as site key)', NULL, 'input', 'RECAPTCHA'),
(33, 'use_recaptcha_on_login', 'Do you want to add captcha support on login form?', '0', 'checkbox', 'RECAPTCHA'),
(34, 'use_recaptcha_on_bad_login', 'Do you want to add captcha support on bad login? if user tried bad login credentials then after specifed bad login count recaptcha will be added on login form', '0', 'checkbox', 'RECAPTCHA'),
(35, 'bad_login_allow_count', 'Enter bad login count to add captcha on login. for e.g. 5 or 10', '5', 'input', 'RECAPTCHA'),
(36, 'use_recaptcha_on_registration', 'Do you want to add captcha support on registration form? ', '0', 'checkbox', 'RECAPTCHA'),
(37, 'use_recaptcha_on_forgot_password', 'Do you want to add captcha support on forgot password page? ', '0', 'checkbox', 'RECAPTCHA'),
(38, 'use_recaptcha_on_email_verification', 'Do you want to add captcha support on email verification page? ', '0', 'checkbox', 'RECAPTCHA'),
(39, 'use_fb_login', 'Do you want to use Facebook Connect on your site?', '0', 'checkbox', 'FACEBOOK'),
(40, 'fb_app_id', 'Enter Facebook Application Id', NULL, 'input', 'FACEBOOK'),
(41, 'fb_secret', 'Enter Facebook Application Secret Code', NULL, 'input', 'FACEBOOK'),
(42, 'fb_scope', 'Enter Facebook Permissions', 'email', 'input', 'FACEBOOK'),
(43, 'use_twt_login', 'Want to use Twitter Connect on your site?', '0', 'checkbox', 'TWITTER'),
(44, 'twt_app_id', 'Enter Twitter Consumer Key', NULL, 'input', 'TWITTER'),
(45, 'twt_secret', 'Enter Twitter Consumer Secret', NULL, 'input', 'TWITTER'),
(46, 'use_gmail_login', 'Do you want to use Google Connect on your site?', '0', 'checkbox', 'GOOGLE'),
(47, 'gmail_api_key', 'Enter Google Api Key', NULL, 'input', 'GOOGLE'),
(48, 'gmail_client_id', 'Enter Google Client Id', NULL, 'input', 'GOOGLE'),
(49, 'gmail_client_secret', 'Enter Google Client Secret', NULL, 'input', 'GOOGLE'),
(50, 'use_yahoo_login', 'Do you want to use Yahoo Connect on your site?', '0', 'checkbox', 'YAHOO'),
(51, 'use_ldn_login', 'Do you want to use Linkedin Connect on your site?', '0', 'checkbox', 'LINKEDIN'),
(52, 'ldn_api_key', 'Enter Linkedin Api Key', NULL, 'input', 'LINKEDIN'),
(53, 'ldn_secret_key', 'Enter Linkedin Secret Key', NULL, 'input', 'LINKEDIN'),
(54, 'use_fs_login', 'Do you want to use Foursquare Connect on your site?', '0', 'checkbox', 'FOURSQUARE'),
(55, 'fs_client_id', 'Enter Foursquare Client Id', NULL, 'input', 'FOURSQUARE'),
(56, 'fs_client_secret', 'Enter Foursquare Client Secret', NULL, 'input', 'FOURSQUARE'),
(57, 'change_password_on_social_registration', 'Do you want to show change password page after user registration from social account?', '1', 'checkbox', 'USER'),
(58, 'default_html_editor', 'Which is default html editor for your application, possible values are Tinymce, Ckeditor', '2', 'radio', 'SITE'),
(59, 'notification_message_position', 'We are using toastr message notification. Please enter flash message position on screen. possible values are\ntoast-top-center\ntoast-bottom-center\ntoast-top-full-width\ntoast-bottom-full-width\ntoast-top-left\ntoast-top-right\ntoast-bottom-right\ntoast-bottom-left', 'toast-top-full-width', 'input', 'SITE'),
(60, 'notification_message_close_time', 'We are using toastr message notification. Please enter flash message close/hide time in seconds. You can leave blank if you do not want to auto close/hide.', '10', 'input', 'SITE');

-- --------------------------------------------------------

--
-- Table structure for table `user_setting_options`
--

CREATE TABLE `user_setting_options` (
  `id` int(11) NOT NULL,
  `user_setting_id` int(11) NOT NULL,
  `setting_option_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_setting_options`
--

INSERT INTO `user_setting_options` (`id`, `user_setting_id`, `setting_option_id`, `created`, `modified`) VALUES
(1, 58, 1, '2018-08-29 14:37:16', '2018-08-29 14:37:16'),
(2, 58, 2, '2018-08-29 14:37:16', '2018-08-29 14:37:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_socials`
--

CREATE TABLE `user_socials` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `socialid` varchar(100) DEFAULT NULL,
  `access_token` text,
  `access_secret` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scheduled_emails`
--
ALTER TABLE `scheduled_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scheduled_email_recipients`
--
ALTER TABLE `scheduled_email_recipients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_options`
--
ALTER TABLE `setting_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `static_pages`
--
ALTER TABLE `static_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`username`),
  ADD KEY `mail` (`email`),
  ADD KEY `users_FKIndex1` (`user_group_id`);

--
-- Indexes for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_contacts`
--
ALTER TABLE `user_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_emails`
--
ALTER TABLE `user_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_email_recipients`
--
ALTER TABLE `user_email_recipients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_email_signatures`
--
ALTER TABLE `user_email_signatures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_email_templates`
--
ALTER TABLE `user_email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_group_permissions`
--
ALTER TABLE `user_group_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_setting_options`
--
ALTER TABLE `user_setting_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_socials`
--
ALTER TABLE `user_socials`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_tokens`
--
ALTER TABLE `login_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scheduled_emails`
--
ALTER TABLE `scheduled_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scheduled_email_recipients`
--
ALTER TABLE `scheduled_email_recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting_options`
--
ALTER TABLE `setting_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `static_pages`
--
ALTER TABLE `static_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_contacts`
--
ALTER TABLE `user_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_emails`
--
ALTER TABLE `user_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_email_recipients`
--
ALTER TABLE `user_email_recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_email_signatures`
--
ALTER TABLE `user_email_signatures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_email_templates`
--
ALTER TABLE `user_email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_group_permissions`
--
ALTER TABLE `user_group_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `user_setting_options`
--
ALTER TABLE `user_setting_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_socials`
--
ALTER TABLE `user_socials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
