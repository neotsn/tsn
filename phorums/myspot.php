<?php

/********************************************************************
 *    MySpot.php
 *    By: @neotsn
 *    Date: 3/17/2014
 *    Version: 8.00
 *    (C) 2001-2014 - thepizzy.net
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

// Grab group details for legend display
if ($auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel')) {
    $sql = 'SELECT group_id, group_name, group_colour, group_type FROM ' . GROUPS_TABLE . ' WHERE group_legend = 1 ORDER BY group_name ASC';
} else {
    $sql = 'SELECT g.group_id, g.group_name, g.group_colour, g.group_type FROM ' . GROUPS_TABLE . ' g LEFT JOIN ' . USER_GROUP_TABLE . ' ug ON ( g.group_id = ug.group_id AND ug.user_id = ' . $user->data['user_id'] . ' AND ug.user_pending = 0 ) WHERE g.group_legend = 1 AND (g.group_type <> ' . GROUP_HIDDEN . ' OR ug.user_id = ' . $user->data['user_id'] . ') ORDER BY g.group_name ASC';
}
$result = $db->sql_query($sql);

$legend = array();
while ($row = $db->sql_fetchrow($result)) {
    $colour_text = ($row['group_colour']) ? ' style="color:#' . $row['group_colour'] . '"' : '';
    $group_name = ($row['group_type'] == GROUP_SPECIAL) ? $user->lang['G_' . $row['group_name']] : $row['group_name'];

    if ($row['group_name'] == 'BOTS' || ($user->data['user_id'] != ANONYMOUS && !$auth->acl_get('u_viewprofile'))) {
        $legend[] = '<span' . $colour_text . '>' . $group_name . '</span>';
    } else {
        $legend[] = '<a' . $colour_text . ' href="' . append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=group&amp;g=' . $row['group_id']) . '">' . $group_name . '</a>';
    }
}
$db->sql_freeresult($result);

$legend = implode(', ', $legend);

$template->assign_vars(array(
    'TOTAL_FORUM_POSTS'  => $config['num_posts'],
    'TOTAL_FORUM_TOPICS' => $config['num_topics'],
    'TOTAL_FORUM_USERS'  => $config['num_users'],
    'LEGEND'             => $legend,
    'NEWEST_USER'        => sprintf($user->lang['NEWEST_USER'], get_username_string('full', $config['newest_user_id'], $config['newest_username'], $config['newest_user_colour']))
));

//module imports
include_once($phpbb_root_path . 'modules/newposts.php');
include_once($phpbb_root_path . 'modules/birthdays.php');
//include_once($phpbb_root_path . 'module_quickquips.php');
include_once($phpbb_root_path . 'modules/mini-index.php');

//display the page
page_header($user->lang['MYSPOT']);

$template->set_filenames(array('body' => 'myspot.html'));
make_jumpbox(append_sid("{$phpbb_root_path}viewforum.$phpEx"));

page_footer();