<?php if (!defined('IN_PHPBB')) exit; ?><table class="tablebg" cellspacing="1" width="100%">
<tr>
	<th>&nbsp;<?php echo ((isset($this->_rootref['L_FORUM'])) ? $this->_rootref['L_FORUM'] : ((isset($user->lang['FORUM'])) ? $user->lang['FORUM'] : '{ FORUM }')); ?>s&nbsp;</th>
</tr>
<?php $_forumrow_count = (isset($this->_tpldata['forumrow'])) ? sizeof($this->_tpldata['forumrow']) : 0;if ($_forumrow_count) {for ($_forumrow_i = 0; $_forumrow_i < $_forumrow_count; ++$_forumrow_i){$_forumrow_val = &$this->_tpldata['forumrow'][$_forumrow_i]; if ($_forumrow_val['S_IS_CAT']) {  ?>

		<tr>
			<td class="cat" nowrap><a href="<?php echo $_forumrow_val['U_VIEWFORUM']; ?>" class="myspot_forum_name"><?php echo $_forumrow_val['FORUM_NAME']; ?></a></td>
		</tr>
	<?php } else if ($_forumrow_val['S_IS_LINK']) {  ?>

		<tr>
			<td class="row1">
				<a class="myspot_forumlink" href="<?php echo $_forumrow_val['U_VIEWFORUM']; ?>"><?php echo $_forumrow_val['FORUM_NAME']; ?></a>
			</td>
		</tr>
	<?php } else { if ($_forumrow_val['S_NO_CAT']) {  ?>

			<tr>
				<td class="cat"><?php echo ((isset($this->_rootref['L_FORUM'])) ? $this->_rootref['L_FORUM'] : ((isset($user->lang['FORUM'])) ? $user->lang['FORUM'] : '{ FORUM }')); ?>s</td>
			</tr>
		<?php } ?>

		<tr>
			<td class="row1" width="100%">
				<a class="myspot_forumlink" href="<?php echo $_forumrow_val['U_VIEWFORUM']; ?>"><?php echo $_forumrow_val['FORUM_NAME']; ?></a>			</td>
		</tr>
	<?php } }} else { ?>

	<tr>
		<td class="row1" align="center"><p class="gensmall"><?php echo ((isset($this->_rootref['L_NO_FORUMS'])) ? $this->_rootref['L_NO_FORUMS'] : ((isset($user->lang['NO_FORUMS'])) ? $user->lang['NO_FORUMS'] : '{ NO_FORUMS }')); ?></p></td>
	</tr>
<?php } ?>

</table>