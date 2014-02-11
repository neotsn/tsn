<?php if (!defined('IN_PHPBB')) exit; ?><table class="tablebg" width="100%" cellspacing="1">
	<tr>
		<th>Forum Stats</th>
	</tr>
	<tr>
		<td class="row1" width="100%" align="center">
			<span class="genmed"><?php echo (isset($this->_rootref['TOTAL_USERS_ONLINE'])) ? $this->_rootref['TOTAL_USERS_ONLINE'] : ''; ?> <hr class="divider" align="center" /> <?php echo (isset($this->_rootref['RECORD_USERS'])) ? $this->_rootref['RECORD_USERS'] : ''; ?> <hr class="divider" align="center" /> <?php echo (isset($this->_rootref['LOGGED_IN_USER_LIST'])) ? $this->_rootref['LOGGED_IN_USER_LIST'] : ''; ?></span>
		</td>
	</tr>
	</table>