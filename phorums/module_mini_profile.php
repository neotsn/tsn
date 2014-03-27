<?php
	/**
	 *
	 * @package       phpBB3
	 * @version       $Id: memberlist.php,v 1.254 2007/10/05 14:30:06 acydburn Exp $
	 * @copyright (c) 2005 phpBB Group
	 * @license       http://opensource.org/licenses/gpl-license.php GNU Public License
	 *
	 */

	/**
	 * @ignore
	 */
	define('IN_PHPBB', true);
	$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
	$phpEx = substr(strrchr(__FILE__, '.'), 1);
	include($phpbb_root_path . 'common.' . $phpEx);
	include($phpbb_root_path . 'includes/functions_display.' . $phpEx);

// Start session management
	$user = new user();
	$user->session_begin();
	$auth->acl($user->data);
	$user->setup(array('memberlist', 'groups'));

// Grab data
	$mode = 'viewprofile';
	$action = request_var('action', '');
	$user_id = $user->data['user_id'];
	$username = $user->data['user_name'];
//$group_id	= request_var('g', 0);
//$topic_id	= request_var('t', 0);

// Check our mode...
	if (!in_array($mode, array('', 'group', 'viewprofile', 'email', 'contact', 'searchuser', 'leaders'))) {
		trigger_error('NO_MODE');
	}

// Can this user view profiles/memberlist?
	if (!$auth->acl_gets('u_viewprofile', 'a_user', 'a_useradd', 'a_userdel')) {
		if ($user->data['user_id'] != ANONYMOUS) {
			trigger_error('NO_VIEW_USERS');
		}

		login_box('', ((isset($user->lang['LOGIN_EXPLAIN_' . strtoupper($mode)])) ? $user->lang['LOGIN_EXPLAIN_' . strtoupper($mode)] : $user->lang['LOGIN_EXPLAIN_MEMBERLIST']));
	}

	$start = request_var('start', 0);
	$submit = (isset($_POST['submit'])) ? true : false;

	$default_key = 'c';
	$sort_key = request_var('sk', $default_key);
	$sort_dir = request_var('sd', 'a');

// Grab rank information for later
	$ranks = $cache->obtain_ranks();

// What do you want to do today? ... oops, I think that line is taken ...
	switch ($mode) {
		case 'viewprofile':
			// Display a profile
			if ($user_id == ANONYMOUS && !$username) {
				trigger_error('NO_USER');
			}

			// Get user...
			$sql = 'SELECT * FROM ' . USERS_TABLE . ' WHERE ' . (($username) ? "username_clean = '" . $db->sql_escape(utf8_clean_string($username)) . "'" : "user_id = $user_id");
			$result = $db->sql_query($sql);
			$member = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			if (!$member) {
				trigger_error('NO_USER');
			}

			// a_user admins and founder are able to view inactive users and bots to be able to manage them more easily
			// Normal users are able to see at least users having only changed their profile settings but not yet reactivated.
			if (!$auth->acl_get('a_user') && $user->data['user_type'] != USER_FOUNDER) {
				if ($member['user_type'] == USER_IGNORE) {
					trigger_error('NO_USER');
				} else if ($member['user_type'] == USER_INACTIVE && $member['user_inactive_reason'] != INACTIVE_PROFILE) {
					trigger_error('NO_USER');
				}
			}

			$user_id = (int)$member['user_id'];

			// Do the SQL thang
			$sql = 'SELECT g.group_id, g.group_name, g.group_type
			FROM ' . GROUPS_TABLE . ' g, ' . USER_GROUP_TABLE . " ug
			WHERE ug.user_id = $user_id
				AND g.group_id = ug.group_id" . ((!$auth->acl_gets('a_group', 'a_groupadd', 'a_groupdel')) ? ' AND g.group_type <> ' . GROUP_HIDDEN : '') . '
				AND ug.user_pending = 0
			ORDER BY g.group_type, g.group_name';
			$result = $db->sql_query($sql);

			$group_options = '';
			while ($row = $db->sql_fetchrow($result)) {
				$group_options .= '<option value="' . $row['group_id'] . '"' . (($row['group_id'] == $member['group_id']) ? ' selected="selected"' : '') . '>' . (($row['group_type'] == GROUP_SPECIAL) ? $user->lang['G_' . $row['group_name']] : $row['group_name']) . '</option>';
			}
			$db->sql_freeresult($result);

			// What colour is the zebra
			$sql = 'SELECT friend, foe
			FROM ' . ZEBRA_TABLE . "
			WHERE zebra_id = $user_id
				AND user_id = {$user->data['user_id']}";

			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$foe = ($row['foe']) ? true : false;
			$friend = ($row['friend']) ? true : false;
			$db->sql_freeresult($result);

			if ($config['load_onlinetrack']) {
				$sql = 'SELECT MAX(session_time) AS session_time, MIN(session_viewonline) AS session_viewonline
				FROM ' . SESSIONS_TABLE . "
				WHERE session_user_id = $user_id";
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$member['session_time'] = (isset($row['session_time'])) ? $row['session_time'] : 0;
				$member['session_viewonline'] = (isset($row['session_viewonline'])) ? $row['session_viewonline'] : 0;
				unset($row);
			}

			if ($config['load_user_activity']) {
				display_user_activity($member);
			}

			// Do the relevant calculations
			$memberdays = max(1, round((time() - $member['user_regdate']) / 86400));
			$posts_per_day = $member['user_posts'] / $memberdays;
			$percentage = ($config['num_posts']) ? min(100, ($member['user_posts'] / $config['num_posts']) * 100) : 0;

			if ($member['user_sig']) {
				$member['user_sig'] = censor_text($member['user_sig']);

				if ($member['user_sig_bbcode_bitfield']) {
					include_once($phpbb_root_path . 'includes/bbcode.' . $phpEx);
					$bbcode = new bbcode();
					$bbcode->bbcode_second_pass($member['user_sig'], $member['user_sig_bbcode_uid'], $member['user_sig_bbcode_bitfield']);
				}

				$member['user_sig'] = bbcode_nl2br($member['user_sig']);
				$member['user_sig'] = smiley_text($member['user_sig']);
			}

			$poster_avatar = get_user_avatar($member['user_avatar'], $member['user_avatar_type'], $member['user_avatar_width'], $member['user_avatar_height']);

			$template->assign_vars(show_profile($member));

			// Custom Profile Fields
			$profile_fields = array();
			if ($config['load_cpf_viewprofile']) {
				include_once($phpbb_root_path . 'includes/functions_profile_fields.' . $phpEx);
				$cp = new custom_profile();
				$profile_fields = $cp->generate_profile_fields_template('grab', $user_id);
				$profile_fields = (isset($profile_fields[$user_id])) ? $cp->generate_profile_fields_template('show', false, $profile_fields[$user_id]) : array();
			}

			// We need to check if the module 'zebra' is accessible
			$zebra_enabled = false;

			if ($user->data['user_id'] != $user_id && $user->data['is_registered']) {
				include_once($phpbb_root_path . 'includes/functions_module.' . $phpEx);
				$module = new p_master();
				$module->list_modules('ucp');
				$module->set_active('zebra');

				$zebra_enabled = ($module->active_module === false) ? false : true;

				unset($module);
			}

			$template->assign_vars(array(
//				'POSTS_DAY'            => sprintf($user->lang['POST_DAY'], $posts_per_day),
'POSTS_DAY'            => number_format($posts_per_day, 2),
//				'POSTS_PCT'            => sprintf($user->lang['POST_PCT'], $percentage),
'POSTS_PCT'            => number_format($percentage, 2) . '%',

'OCCUPATION'           => (!empty($member['user_occ'])) ? censor_text($member['user_occ']) : '',
'INTERESTS'            => (!empty($member['user_interests'])) ? censor_text($member['user_interests']) : '',
'SIGNATURE'            => $member['user_sig'],

'AVATAR_IMG'           => $poster_avatar,
'PM_IMG'               => $user->img('icon_contact_pm', $user->lang['SEND_PRIVATE_MESSAGE']),
'EMAIL_IMG'            => $user->img('icon_contact_email', $user->lang['EMAIL']),
'WWW_IMG'              => $user->img('icon_contact_www', $user->lang['WWW']),
'ICQ_IMG'              => $user->img('icon_contact_icq', $user->lang['ICQ']),
'AIM_IMG'              => $user->img('icon_contact_aim', $user->lang['AIM']),
'MSN_IMG'              => $user->img('icon_contact_msnm', $user->lang['MSNM']),
'YIM_IMG'              => $user->img('icon_contact_yahoo', $user->lang['YIM']),
'JABBER_IMG'           => $user->img('icon_contact_jabber', $user->lang['JABBER']),
'SEARCH_IMG'           => $user->img('icon_user_search', $user->lang['SEARCH']),

'S_PROFILE_ACTION'     => append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=group'),
'S_GROUP_OPTIONS'      => $group_options,
'S_CUSTOM_FIELDS'      => (isset($profile_fields['row']) && sizeof($profile_fields['row'])) ? true : false,

'U_USER_ADMIN'         => ($auth->acl_get('a_user')) ? append_sid("{$phpbb_root_path}adm/index.$phpEx", 'i=users&amp;mode=overview&amp;u=' . $user_id, true, $user->session_id) : '',
'U_SWITCH_PERMISSIONS' => ($auth->acl_get('a_switchperm') && $user->data['user_id'] != $user_id) ? append_sid("{$phpbb_root_path}ucp.$phpEx", "mode=switch_perm&amp;u={$user_id}") : '',

'S_ZEBRA'              => ($user->data['user_id'] != $user_id && $user->data['is_registered'] && $zebra_enabled) ? true : false,
'U_ADD_FRIEND'         => (!$friend) ? append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=zebra&amp;add=' . urlencode(htmlspecialchars_decode($member['username']))) : '',
'U_ADD_FOE'            => (!$foe) ? append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=zebra&amp;mode=foes&amp;add=' . urlencode(htmlspecialchars_decode($member['username']))) : '',
'U_REMOVE_FRIEND'      => ($friend) ? append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=zebra&amp;remove=1&amp;usernames[]=' . $user_id) : '',
'U_REMOVE_FOE'         => ($foe) ? append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=zebra&amp;remove=1&amp;mode=foes&amp;usernames[]=' . $user_id) : '',
			));

			if (!empty($profile_fields['row'])) {
				$template->assign_vars($profile_fields['row']);
			}

			if (!empty($profile_fields['blockrow'])) {
				foreach ($profile_fields['blockrow'] as $field_data) {
					$template->assign_block_vars('custom_fields', $field_data);
				}
			}

			// Inactive reason/account?
			if ($member['user_type'] == USER_INACTIVE) {
				$user->add_lang('acp/common');

				$inactive_reason = $user->lang['INACTIVE_REASON_UNKNOWN'];

				switch ($member['user_inactive_reason']) {
					case INACTIVE_REGISTER:
						$inactive_reason = $user->lang['INACTIVE_REASON_REGISTER'];
						break;

					case INACTIVE_PROFILE:
						$inactive_reason = $user->lang['INACTIVE_REASON_PROFILE'];
						break;

					case INACTIVE_MANUAL:
						$inactive_reason = $user->lang['INACTIVE_REASON_MANUAL'];
						break;

					case INACTIVE_REMIND:
						$inactive_reason = $user->lang['INACTIVE_REASON_REMIND'];
						break;
				}

				$template->assign_vars(array(
						'S_USER_INACTIVE'      => true,
						'USER_INACTIVE_REASON' => $inactive_reason)
				);
			}

			// Now generate page title
			$page_title = sprintf($user->lang['VIEWING_PROFILE'], $member['username']);
			$template_html = 'modules/mini-profile.html';

			break;
	}

// Output the page
	page_header($page_title);

	$template->set_filenames(array(
			'body' => $template_html)
	);
//make_jumpbox(append_sid("{$phpbb_root_path}viewforum.$phpEx"));

	page_footer();

	/**
	 * Prepare profile data
	 */
	function show_profile($data) {
		global $config, $auth, $template, $user, $phpEx, $phpbb_root_path;

		$username = $data['username'];
		$user_id = $data['user_id'];

		$rank_title = $rank_img = $rank_img_src = '';
		get_user_rank($data['user_rank'], $data['user_posts'], $rank_title, $rank_img, $rank_img_src);

		if (!empty($data['user_allow_viewemail']) || $auth->acl_get('a_email')) {
			$email = ($config['board_email_form'] && $config['email_enable']) ? append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=email&amp;u=' . $user_id) : (($config['board_hide_emails'] && !$auth->acl_get('a_email')) ? '' : 'mailto:' . $data['user_email']);
		} else {
			$email = '';
		}

		if ($config['load_onlinetrack']) {
			$update_time = $config['load_online_time'] * 60;
			$online = (time() - $update_time < $data['session_time'] && ((isset($data['session_viewonline']) && $data['session_viewonline']) || $auth->acl_get('u_viewonline'))) ? true : false;
		} else {
			$online = false;
		}

		if ($data['user_allow_viewonline'] || $auth->acl_get('u_viewonline')) {
			$last_visit = (!empty($data['session_time'])) ? $data['session_time'] : $data['user_lastvisit'];
		} else {
			$last_visit = '';
		}

		$age = '';

		if ($config['allow_birthdays'] && $data['user_birthday']) {
			list($bday_day, $bday_month, $bday_year) = array_map('intval', explode('-', $data['user_birthday']));

			if ($bday_year) {
				$now = getdate(time() + $user->timezone + $user->dst - date('Z'));

				$diff = $now['mon'] - $bday_month;
				if ($diff == 0) {
					$diff = ($now['mday'] - $bday_day < 0) ? 1 : 0;
				} else {
					$diff = ($diff < 0) ? 1 : 0;
				}

				$age = (int)($now['year'] - $bday_year - $diff);
			}
		}

		// Dump it out to the template
		return array(
			'AGE'               => $age,
			'RANK_TITLE'        => $rank_title,
			'JOINED'            => $user->format_date($data['user_regdate']),
			'VISITED'           => (empty($last_visit)) ? ' - ' : $user->format_date($last_visit),
			'POSTS'             => ($data['user_posts']) ? $data['user_posts'] : 0,
			'WARNINGS'          => isset($data['user_warnings']) ? $data['user_warnings'] : 0,

			'USERNAME_FULL'     => get_username_string('full', $user_id, $username, $data['user_colour']),
			'USERNAME'          => get_username_string('username', $user_id, $username, $data['user_colour']),
			'USER_COLOR'        => get_username_string('colour', $user_id, $username, $data['user_colour']),
			'U_VIEW_PROFILE'    => get_username_string('profile', $user_id, $username, $data['user_colour']),

			'A_USERNAME'        => addslashes(get_username_string('username', $user_id, $username, $data['user_colour'])),

			'ONLINE_IMG'        => (!$config['load_onlinetrack']) ? '' : (($online) ? $user->img('icon_user_online', 'ONLINE') : $user->img('icon_user_offline', 'OFFLINE')),
			'S_ONLINE'          => ($config['load_onlinetrack'] && $online) ? true : false,
			'RANK_IMG'          => $rank_img,
			'RANK_IMG_SRC'      => $rank_img_src,
			'ICQ_STATUS_IMG'    => (!empty($data['user_icq'])) ? '<img src="http://web.icq.com/whitepages/online?icq=' . $data['user_icq'] . '&amp;img=5" width="18" height="18" />' : '',
			'S_JABBER_ENABLED'  => ($config['jab_enable']) ? true : false,

			'U_SEARCH_USER'     => ($auth->acl_get('u_search')) ? append_sid("{$phpbb_root_path}search.$phpEx", "author_id=$user_id&amp;sr=posts") : '',
			'U_NOTES'           => $auth->acl_getf_global('m_') ? append_sid("{$phpbb_root_path}mcp.$phpEx", 'i=notes&amp;mode=user_notes&amp;u=' . $user_id, true, $user->session_id) : '',
			'U_WARN'            => $auth->acl_get('m_warn') ? append_sid("{$phpbb_root_path}mcp.$phpEx", 'i=warn&amp;mode=warn_user&amp;u=' . $user_id, true, $user->session_id) : '',
			'U_PM'              => ($config['allow_privmsg'] && $auth->acl_get('u_sendpm') && ($data['user_allow_pm'] || $auth->acl_gets('a_', 'm_') || $auth->acl_getf_global('m_'))) ? append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=pm&amp;mode=compose&amp;u=' . $user_id) : '',
			'U_EMAIL'           => $email,
			'U_WWW'             => (!empty($data['user_website'])) ? $data['user_website'] : '',
			'U_ICQ'             => ($data['user_icq']) ? 'http://www.icq.com/people/webmsg.php?to=' . urlencode($data['user_icq']) : '',
			'U_AIM'             => ($data['user_aim'] && $auth->acl_get('u_sendim')) ? append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=contact&amp;action=aim&amp;u=' . $user_id) : '',
			'U_YIM'             => ($data['user_yim']) ? 'http://edit.yahoo.com/config/send_webmesg?.target=' . urlencode($data['user_yim']) . '&amp;.src=pg' : '',
			'U_MSN'             => ($data['user_msnm'] && $auth->acl_get('u_sendim')) ? append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=contact&amp;action=msnm&amp;u=' . $user_id) : '',
			'U_JABBER'          => ($data['user_jabber'] && $auth->acl_get('u_sendim')) ? append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=contact&amp;action=jabber&amp;u=' . $user_id) : '',
			'LOCATION'          => ($data['user_from']) ? $data['user_from'] : '',

			'USER_ICQ'          => $data['user_icq'],
			'USER_AIM'          => $data['user_aim'],
			'USER_YIM'          => $data['user_yim'],
			'USER_MSN'          => $data['user_msnm'],
			'USER_JABBER'       => $data['user_jabber'],
			'USER_JABBER_IMG'   => ($data['user_jabber']) ? $user->img('icon_contact_jabber', $data['user_jabber']) : '',

			'L_VIEWING_PROFILE' => sprintf($user->lang['VIEWING_PROFILE'], $username),
		);
	}

?>