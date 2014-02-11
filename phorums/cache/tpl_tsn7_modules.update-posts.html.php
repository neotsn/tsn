<?php if (!defined('IN_PHPBB')) exit; ?><table class="newposts" cellspacing="1">
	<tr>
		<th nowrap="nowrap">&nbsp;New <?php echo ((isset($this->_rootref['L_TOPICS'])) ? $this->_rootref['L_TOPICS'] : ((isset($user->lang['TOPICS'])) ? $user->lang['TOPICS'] : '{ TOPICS }')); ?>&nbsp;</th>
		<th nowrap="nowrap">&nbsp;<?php echo ((isset($this->_rootref['L_LAST_POST'])) ? $this->_rootref['L_LAST_POST'] : ((isset($user->lang['LAST_POST'])) ? $user->lang['LAST_POST'] : '{ LAST_POST }')); ?>&nbsp;</th>
	</tr>
	<?php if ($this->_rootref['S_SHOW_TOPICS']) {  $_searchresults_count = (isset($this->_tpldata['searchresults'])) ? sizeof($this->_tpldata['searchresults']) : 0;if ($_searchresults_count) {for ($_searchresults_i = 0; $_searchresults_i < $_searchresults_count; ++$_searchresults_i){$_searchresults_val = &$this->_tpldata['searchresults'][$_searchresults_i]; ?>

		<tr valign="middle">
			<td class="row1 left">
				<?php if ($_searchresults_val['S_UNREAD_TOPIC']) {  ?><a href="<?php echo $_searchresults_val['U_NEWEST_POST']; ?>"><?php echo (isset($this->_rootref['NEWEST_POST_IMG'])) ? $this->_rootref['NEWEST_POST_IMG'] : ''; ?></a><?php } ?>

				<?php echo $_topicrow_val['ATTACH_ICON_IMG']; ?> <a href="<?php echo $_searchresults_val['U_VIEW_TOPIC']; ?>" class="topictitle"><?php echo $_searchresults_val['TOPIC_TITLE']; ?></a>
				<?php if ($_searchresults_val['S_TOPIC_UNAPPROVED'] || $_searchresults_val['S_POSTS_UNAPPROVED']) {  ?>

					<a href="<?php echo $_searchresults_val['U_MCP_QUEUE']; ?>"><?php echo $_searchresults_val['UNAPPROVED_IMG']; ?></a>&nbsp;
				<?php } if ($_searchresults_val['S_TOPIC_REPORTED']) {  ?>

					<a href="<?php echo $_searchresults_val['U_MCP_REPORT']; ?>"><?php echo (isset($this->_rootref['REPORTED_IMG'])) ? $this->_rootref['REPORTED_IMG'] : ''; ?></a>&nbsp;
				<?php } if ($_searchresults_val['S_TOPIC_GLOBAL']) {  ?>

					<p class="gensmall"><?php echo ((isset($this->_rootref['L_GLOBAL'])) ? $this->_rootref['L_GLOBAL'] : ((isset($user->lang['GLOBAL'])) ? $user->lang['GLOBAL'] : '{ GLOBAL }')); ?>

				<?php } else { ?>

					<p class="gensmall"><?php echo ((isset($this->_rootref['L_IN'])) ? $this->_rootref['L_IN'] : ((isset($user->lang['IN'])) ? $user->lang['IN'] : '{ IN }')); ?> <a href="<?php echo $_searchresults_val['U_VIEW_FORUM']; ?>"><?php echo $_searchresults_val['FORUM_TITLE']; ?></a>
				<?php } if ($_searchresults_val['PAGINATION']) {  ?>

					[ <?php echo (isset($this->_rootref['GOTO_PAGE_IMG'])) ? $this->_rootref['GOTO_PAGE_IMG'] : ''; echo ((isset($this->_rootref['L_GOTO_PAGE'])) ? $this->_rootref['L_GOTO_PAGE'] : ((isset($user->lang['GOTO_PAGE'])) ? $user->lang['GOTO_PAGE'] : '{ GOTO_PAGE }')); ?>: <?php echo $_searchresults_val['PAGINATION']; ?> ] </p>
				<?php } else { ?>

					</p>
				<?php } ?>

			</td>
			<td class="row1" width="120" align="center">
				<p class="topicdetails"><?php echo $_searchresults_val['LAST_POST_TIME']; ?></p>
				<p class="topicdetails"><?php echo $_searchresults_val['LAST_POST_AUTHOR_FULL']; ?>

					<a href="<?php echo $_searchresults_val['U_LAST_POST']; ?>"><?php echo (isset($this->_rootref['LAST_POST_IMG'])) ? $this->_rootref['LAST_POST_IMG'] : ''; ?></a>
				</p>
			</td>
		</tr>
		<?php }} else { ?>

		<tr valign="middle">
			<td colspan="2" class="row3" align="center"><?php echo ((isset($this->_rootref['L_NO_SEARCH_RESULTS'])) ? $this->_rootref['L_NO_SEARCH_RESULTS'] : ((isset($user->lang['NO_SEARCH_RESULTS'])) ? $user->lang['NO_SEARCH_RESULTS'] : '{ NO_SEARCH_RESULTS }')); ?></td>
		</tr>
		<?php } } ?>

	<tr>
		<td class="cat" colspan="2" valign="middle" align="center"><span class="nav"><?php echo (isset($this->_rootref['PAGE_NUMBER'])) ? $this->_rootref['PAGE_NUMBER'] : ''; ?></span> [ <?php echo (isset($this->_rootref['SEARCH_MATCHES'])) ? $this->_rootref['SEARCH_MATCHES'] : ''; ?> ] <?php $this->_tpl_include('modules/pagination.html'); ?></td>
	</tr>
	</table>