<?php
/////// tsn.7 TSN Special Report Script ///////
header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );  // disable IE caching
header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" ); 
header( "Cache-Control: no-cache, must-revalidate" ); 
header( "Pragma: no-cache" );


define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/functions_display.' . $phpEx);

/*
$sql = "SELECT f.* $lastread_select
	FROM $sql_from
	WHERE f.forum_id = $forum_id";
$result = $db->sql_query($sql);
$forum_data = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
*/

// Grab the latest topic ID for TSN Special Report
$sql = "SELECT MAX(topic_id) AS topic_id FROM " . TOPICS_TABLE . " WHERE forum_id = 14";
$result = $db->sql_query($sql);
$news_topic_id = $db->sql_fetchrow($result);
$db->sql_freeresult($result);

if ( !$news_topic_id )
{
	trigger_error('NO_TSNSR_1');
}

// Grab the post information and put to an array
$sql = "SELECT t.topic_title, t.topic_poster, p.enable_smilies, p.post_id, p.post_text, p.bbcode_uid, p.bbcode_bitfield, u.username
	FROM " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p, " . USERS_TABLE . " u
	WHERE t.forum_id = 14 
		AND t.topic_id = " . $news_topic_id['topic_id'] . " 
		AND p.topic_id = t.topic_id 
		AND p.post_id = t.topic_first_post_id 
		AND u.user_id = t.topic_poster";
$result = $db->sql_query($sql);
$news_info = $db->sql_fetchrow($result);
$db->sql_freeresult($result);

if (!$news_info)
{
	trigger_error('NO_TSNSR_3');
}

/** Available Variable List **/
//echo $news_info['post_id'] ;
//echo $news_info['topic_title'];
//echo $news_info['topic_poster'];
//echo $news_info['post_text'];
//echo $news_info['bbcode_uid'];
//echo $news_info['bbcode_bitfield'];
//echo $news_info['enable_smilies'];
//echo $news_info['poster_id'];
$message = $news_info['post_text'];

// Grab the user's avatar for the newest topic
$sql = "SELECT u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height
	FROM " . USERS_TABLE . " u
	WHERE u.user_id = " . $news_info['topic_poster'];
$result = $db->sql_query($sql);
$news_avatar = $db->sql_fetchrow($result);
$db->sql_freeresult($result);

if (!$news_avatar)
{
	trigger_error('NO_TSNSR_4');
}
/** Available Variable List **/
//$news_avatar['user_avatar'] 
//$news_avatar['user_avatar_type']
//$news_avatar['user_avatar_width']
//$news_avatar['user_avatar_height']

$avatar_image = get_user_avatar($news_avatar['user_avatar'], $news_avatar['user_avatar_type'], $news_avatar['user_avatar_width'], $news_avatar['user_avatar_height']);

/** Return Characters **/
$return_chars = 250;
if ( isset($return_chars) )
{
	$bbcode_bitfield = base64_decode($news_info['bbcode_bitfield']);
	
	if ($bbcode_bitfield !== '')
	{
		$bbcode = new bbcode(base64_encode($bbcode_bitfield));
	}

	// Parse the message and subject
	$message = censor_text($news_info['post_text']);
	
	// Second parse bbcode here
	if ($news_info['bbcode_bitfield'])
	{
		$bbcode->bbcode_second_pass($message, $news_info['bbcode_uid'], $news_info['bbcode_bitfield']);
	}
	
	$message = bbcode_nl2br($message);
	$message = smiley_text($message);
	
	$news_info['post_subject'] = censor_text($news_info['post_subject']);
	
	//
	// If the board has HTML off but the post has HTML
	// on then we process it, else leave it alone
	//
/*		$news_message = preg_replace('/\:[0-9a-z\:]+\]/si', ']', $news_message);
		$news_message = bbencode_second_pass($news_message, $bbcode_uid);
		$news_message = make_clickable($news_message);
		$news_message = smilies_pass($news_message);
		$news_message = str_replace("\n", '<br />', $news_message);
		$news_message = preg_replace("/\[.*?:$bbcode_uid:?.*?\]/si", '', $news_message);
		$news_message = preg_replace('/\[url\]|\[\/url\]/si', '', $news_message);
*/		
		$message = ( strlen($message) > $return_chars ) ? substr($message, 0, $return_chars) . ' ...' : $message;

}
$read_more = '<span class="gensmall"><b><a href="' . append_sid("{$phpbb_root_path}viewtopic.$phpEx", "p=" . $news_info['post_id'] . '">Read More Here</a></b></span>');

/*$template->assign_block_vars('neonews', array( 
		'TITLE' => $news['topic_title'],
		'SUBTITLE' => $news['topic_sub_title'],
		'TOPIC_REPLIES' => $news['topic_replies'],
		'TOPIC_VIEWS' => $news['topic_views'],
		'POSTER' => $news['topic_poster'],
		'DATE' => create_date($userdata['user_dateformat'], $news['topic_time'], $userdata['user_timezone']),
		'TEXT' => $news_message,
		'AVATAR' => $avatar,
		'READ_MORE' => $read_more)
		);
*/

$html = "
	<table cellspacing=0 width=\"100%\" class=\"tablebg\">
		<tr>
			<th width=\"100%\"><h4>TSN Special Report</h4></th>
		</tr>
		<tr>
			<td width=\"100%\" class=\"row1 left\"><h4><p align=\"center\">" . $news_info['topic_title'] . "</p></h4><br /><span class=\"newnews_avatar\">" . $avatar_image . "</span>" . $message . "<br /></td>
		</tr>
		<tr>
			<td width=\"100%\" class=\"row1\"><hr width=\"100%\" align=\"center\"><p align=\"center\" class=\"gensmall\"><br />" . $read_more . "</p></td>
		</tr>
<!--	<tr>
			<td width=\"100%\" class=\"row1\"><p>Latest News from thepizzy.net/blog rss feed with the \"tsnX\" tag</p></td>
		</tr>-->
	</table>
";

echo $html;

?>