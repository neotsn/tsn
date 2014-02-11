<?php if (!defined('IN_PHPBB')) exit; ?><table class="tablebg" width="100%" cellspacing="1">
	<tr>
		<th nowrap="nowrap">Hi there, <?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?>!</th>
	</tr>
	<tr>
		<td class="row1" align="center">
			<table cellspacing="1" cellpadding="2" border="0">
				<?php if ($this->_rootref['S_USER_INACTIVE']) {  ?>

				<tr>
					<td align="center" style="color: red;"><b class="gen"><?php echo ((isset($this->_rootref['L_USER_IS_INACTIVE'])) ? $this->_rootref['L_USER_IS_INACTIVE'] : ((isset($user->lang['USER_IS_INACTIVE'])) ? $user->lang['USER_IS_INACTIVE'] : '{ USER_IS_INACTIVE }')); ?></b><br /><?php echo ((isset($this->_rootref['L_INACTIVE_REASON'])) ? $this->_rootref['L_INACTIVE_REASON'] : ((isset($user->lang['INACTIVE_REASON'])) ? $user->lang['INACTIVE_REASON'] : '{ INACTIVE_REASON }')); ?>: <?php echo (isset($this->_rootref['USER_INACTIVE_REASON'])) ? $this->_rootref['USER_INACTIVE_REASON'] : ''; ?><br /><br /></td>
				</tr>
				<?php } if ($this->_rootref['RANK_TITLE']) {  ?>

					<tr>
						<td class="postdetails" align="center"><?php echo (isset($this->_rootref['RANK_TITLE'])) ? $this->_rootref['RANK_TITLE'] : ''; ?></td>
					</tr>
				<?php } if ($this->_rootref['RANK_IMG']) {  ?>

					<tr>
						<td align="center"><?php echo (isset($this->_rootref['RANK_IMG'])) ? $this->_rootref['RANK_IMG'] : ''; ?></td>
					</tr>
				<?php } if ($this->_rootref['AVATAR_IMG']) {  ?>

					<tr>
						<td align="center"><?php echo (isset($this->_rootref['AVATAR_IMG'])) ? $this->_rootref['AVATAR_IMG'] : ''; ?></td>
					</tr>
				<?php } if ($this->_rootref['ONLINE_IMG']) {  ?>

				<tr>
					<td align="center"><?php echo (isset($this->_rootref['ONLINE_IMG'])) ? $this->_rootref['ONLINE_IMG'] : ''; ?></td>
				</tr>
				<?php } if ($this->_rootref['U_USER_ADMIN']) {  ?>

				<tr>
					<td align="center"><span class="gensmall"> [ <a href="<?php echo (isset($this->_rootref['U_USER_ADMIN'])) ? $this->_rootref['U_USER_ADMIN'] : ''; ?>"><?php echo ((isset($this->_rootref['L_USER_ADMIN'])) ? $this->_rootref['L_USER_ADMIN'] : ((isset($user->lang['USER_ADMIN'])) ? $user->lang['USER_ADMIN'] : '{ USER_ADMIN }')); ?></a> ]</span></td>
				</tr>
				<?php } ?>

				<tr>
					<td align="center"><hr width="75%"></td>
				</tr>
				<tr>
					<td align="center"><span class="gensmall"><?php echo ((isset($this->_rootref['L_JOINED'])) ? $this->_rootref['L_JOINED'] : ((isset($user->lang['JOINED'])) ? $user->lang['JOINED'] : '{ JOINED }')); ?>: <?php echo (isset($this->_rootref['JOINED'])) ? $this->_rootref['JOINED'] : ''; ?></span></td>
				</tr>
				<tr>
					<td align="center"><span class="gensmall"><?php echo ((isset($this->_rootref['L_VISITED'])) ? $this->_rootref['L_VISITED'] : ((isset($user->lang['VISITED'])) ? $user->lang['VISITED'] : '{ VISITED }')); ?>: <?php echo (isset($this->_rootref['VISITED'])) ? $this->_rootref['VISITED'] : ''; ?></span></td>
				</tr>
				<?php if ($this->_rootref['U_NOTES'] || $this->_rootref['U_WARN']) {  ?>

				<tr>
					<td align="center" valign="top"><span class="gensmall"><?php echo ((isset($this->_rootref['L_WARNINGS'])) ? $this->_rootref['L_WARNINGS'] : ((isset($user->lang['WARNINGS'])) ? $user->lang['WARNINGS'] : '{ WARNINGS }')); ?>: <b><?php echo (isset($this->_rootref['WARNINGS'])) ? $this->_rootref['WARNINGS'] : ''; ?></b><br />[ <a href="<?php echo (isset($this->_rootref['U_NOTES'])) ? $this->_rootref['U_NOTES'] : ''; ?>"><?php echo ((isset($this->_rootref['L_VIEW_NOTES'])) ? $this->_rootref['L_VIEW_NOTES'] : ((isset($user->lang['VIEW_NOTES'])) ? $user->lang['VIEW_NOTES'] : '{ VIEW_NOTES }')); ?></a> ]</span></td>
				</tr>
				<?php } ?>

				<tr>
					<td align="center" valign="top"><span class="gensmall"><?php echo ((isset($this->_rootref['L_TOTAL_POSTS'])) ? $this->_rootref['L_TOTAL_POSTS'] : ((isset($user->lang['TOTAL_POSTS'])) ? $user->lang['TOTAL_POSTS'] : '{ TOTAL_POSTS }')); ?>: <b><?php echo (isset($this->_rootref['POSTS'])) ? $this->_rootref['POSTS'] : ''; ?></b><?php if ($this->_rootref['POSTS_PCT']) {  ?><br />[<?php echo (isset($this->_rootref['POSTS_PCT'])) ? $this->_rootref['POSTS_PCT'] : ''; ?> / <?php echo (isset($this->_rootref['POSTS_DAY'])) ? $this->_rootref['POSTS_DAY'] : ''; ?>]<?php } ?></span></td>
				</tr>
			</table>
		</td>
	</tr>
	</table>