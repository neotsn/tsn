<?php

	/********************************************************************
	 *    MySpot.php
	 *    By: Chris Chiles
	 *    Date: 3/17/2014
	 *    Version: 8.00
	 *    (C) 2006-2014 - The-Spot.Network LLC
	 ********************************************************************/

	define('IN_PHPBB', true);
	$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
	$phpEx = substr(strrchr(__FILE__, '.'), 1);
	include_once($phpbb_root_path . 'common.' . $phpEx);
	include_once($phpbb_root_path . 'includes/functions_display.' . $phpEx);

// Start session management
	$user->session_begin();
	$auth->acl($user->data);
	$user->setup('search');
//$user->setup('viewforum');

//module imports
	include_once($phpbb_root_path . 'modules/newposts.php');
	include_once($phpbb_root_path . 'modules/birthdays.php');
//	include_once($phpbb_root_path . 'module_quickquips.php');
include_once($phpbb_root_path . 'modules/mini-index.php');

//display the page
page_header($user->lang['MYSPOT']);

	$template->set_filenames(array('body' => 'myspot.html'));
	make_jumpbox(append_sid("{$phpbb_root_path}viewforum.$phpEx"));

	page_footer();