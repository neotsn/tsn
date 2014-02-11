<?php if (!defined('IN_PHPBB')) exit; ?><br />
			<center>
				<table class="topbar_table" cellspacing="0px" cellpadding="0px">
					<tr>
						<td height="30" align="right" class="topbar">
							<span class="bluebar">
								<a href="./myspot.php" class="bluebar">My Spot</a> :: 
								<?php if (! $this->_rootref['S_IS_BOT']) {  if ($this->_rootref['S_USER_LOGGED_IN']) {  if ($this->_rootref['S_DISPLAY_PM']) {  ?> &nbsp;<a href="<?php echo (isset($this->_rootref['U_PRIVATEMSGS'])) ? $this->_rootref['U_PRIVATEMSGS'] : ''; ?>" class="bluebar"><?php echo (isset($this->_rootref['PRIVATE_MESSAGE_INFO'])) ? $this->_rootref['PRIVATE_MESSAGE_INFO'] : ''; if ($this->_rootref['PRIVATE_MESSAGE_INFO_UNREAD']) {  ?>, <?php echo (isset($this->_rootref['PRIVATE_MESSAGE_INFO_UNREAD'])) ? $this->_rootref['PRIVATE_MESSAGE_INFO_UNREAD'] : ''; } ?></a><?php } } else { ?><a href="<?php echo (isset($this->_rootref['U_REGISTER'])) ? $this->_rootref['U_REGISTER'] : ''; ?>" class="bluebar"><?php echo ((isset($this->_rootref['L_REGISTER'])) ? $this->_rootref['L_REGISTER'] : ((isset($user->lang['REGISTER'])) ? $user->lang['REGISTER'] : '{ REGISTER }')); ?></a>
									<?php } } ?> :: <a href="./index.php" class="bluebar">Forums</a>
								:: <a href="chat.html" class="bluebar" target="_search">Chat</a>
								<?php if ($this->_rootref['U_ACP']) {  ?> :: <a href="<?php echo (isset($this->_rootref['U_ACP'])) ? $this->_rootref['U_ACP'] : ''; ?>" class="bluebar"><?php echo ((isset($this->_rootref['L_ACP'])) ? $this->_rootref['L_ACP'] : ((isset($user->lang['ACP'])) ? $user->lang['ACP'] : '{ ACP }')); ?></a><?php } ?>

							</span>
						</td>
					</tr>
				</table>
			<div id="divQuickQuips"></div>
			</center>