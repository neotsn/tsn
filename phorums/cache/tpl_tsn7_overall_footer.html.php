<?php if (!defined('IN_PHPBB')) exit; if (! $this->_rootref['S_IS_BOT']) {  echo (isset($this->_rootref['RUN_CRON_TASK'])) ? $this->_rootref['RUN_CRON_TASK'] : ''; } ?>

				</div>

				<!--
					We request you retain the full copyright notice below including the link to www.phpbb.com.
					This not only gives respect to the large amount of time given freely by the developers
					but also helps build interest, traffic and use of phpBB3. If you (honestly) cannot retain
					the full copyright we ask you at least leave in place the "Powered by phpBB" line, with
					"phpBB" linked to www.phpbb.com. If you refuse to include even this then support on our
					forums may be affected.

					The phpBB Group : 2006
				//-->
			</div>
		</td>
	</tr>					
	<tr>
		<td width="950" height="45" class="content-end">
			<div id="wrapfooter">
				
				<span class="gensmall">Powered by <a href="http://www.phpbb.com/">these guys</a> &copy; 2011 &amp; by <a href="http://thepizzy.net/blog/">thepizzy.net</a> &copy; 2003-2011 the-spot.net
				<?php if ($this->_rootref['TRANSLATION_INFO']) {  ?><br /><?php echo (isset($this->_rootref['TRANSLATION_INFO'])) ? $this->_rootref['TRANSLATION_INFO'] : ''; } if ($this->_rootref['DEBUG_OUTPUT']) {  ?><br /><bdo dir="ltr">[ <?php echo (isset($this->_rootref['DEBUG_OUTPUT'])) ? $this->_rootref['DEBUG_OUTPUT'] : ''; ?> ]</bdo><?php } ?><br /></span>
			</div>
		</td>
	</tr>
	<tr>
		<td width="950" height="30" class="footer-top">&nbsp;</td>
	</tr>	
	<tr>
		<td width="950" height="30" class="footer-mid">
			<span class="bluebar">
				<a href="./myspot.php" class="bluebar">My Spot</a> :: 
				<?php if (! $this->_rootref['S_IS_BOT']) {  if ($this->_rootref['S_USER_LOGGED_IN']) {  if ($this->_rootref['S_DISPLAY_PM']) {  ?> &nbsp;<a href="<?php echo (isset($this->_rootref['U_PRIVATEMSGS'])) ? $this->_rootref['U_PRIVATEMSGS'] : ''; ?>" class="bluebar"><?php echo (isset($this->_rootref['PRIVATE_MESSAGE_INFO'])) ? $this->_rootref['PRIVATE_MESSAGE_INFO'] : ''; if ($this->_rootref['PRIVATE_MESSAGE_INFO_UNREAD']) {  ?>, <?php echo (isset($this->_rootref['PRIVATE_MESSAGE_INFO_UNREAD'])) ? $this->_rootref['PRIVATE_MESSAGE_INFO_UNREAD'] : ''; } ?></a><?php } } else { ?><a href="<?php echo (isset($this->_rootref['U_REGISTER'])) ? $this->_rootref['U_REGISTER'] : ''; ?>" class="bluebar"><?php echo ((isset($this->_rootref['L_REGISTER'])) ? $this->_rootref['L_REGISTER'] : ((isset($user->lang['REGISTER'])) ? $user->lang['REGISTER'] : '{ REGISTER }')); ?></a>
					<?php } } ?> :: <a href="http://www.the-spot.net/phorums/" class="bluebar">Forums</a>
				:: <a href="chat.html" class="bluebar" target="_search">Chat</a>
				<?php if (! $this->_rootref['S_IS_BOT']) {  if ($this->_rootref['S_USER_LOGGED_IN']) {  ?> :: <a href="<?php echo (isset($this->_rootref['U_PROFILE'])) ? $this->_rootref['U_PROFILE'] : ''; ?>" class="userlinks"><?php echo ((isset($this->_rootref['L_PROFILE'])) ? $this->_rootref['L_PROFILE'] : ((isset($user->lang['PROFILE'])) ? $user->lang['PROFILE'] : '{ PROFILE }')); ?></a><?php } ?> :: 
					<a href="<?php echo (isset($this->_rootref['U_LOGIN_LOGOUT'])) ? $this->_rootref['U_LOGIN_LOGOUT'] : ''; ?>" class="bluebar"><?php echo ((isset($this->_rootref['L_LOGIN_LOGOUT'])) ? $this->_rootref['L_LOGIN_LOGOUT'] : ((isset($user->lang['LOGIN_LOGOUT'])) ? $user->lang['LOGIN_LOGOUT'] : '{ LOGIN_LOGOUT }')); ?></a>
				<?php } if ($this->_rootref['U_ACP']) {  ?> :: <a href="<?php echo (isset($this->_rootref['U_ACP'])) ? $this->_rootref['U_ACP'] : ''; ?>" class="bluebar"><?php echo ((isset($this->_rootref['L_ACP'])) ? $this->_rootref['L_ACP'] : ((isset($user->lang['ACP'])) ? $user->lang['ACP'] : '{ ACP }')); ?></a><?php } ?>

			</span>
		</td>
	</tr>
	<tr>
		<td width="950" height="35" class="footer-bot">&nbsp;</td>
	</tr>	
</table>
<!-- stat_run_body.tpl -->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"> 
</script>
<script type="text/javascript">
_uacct = "UA-238317-1";
urchinTracker();
</script>
</body>
</html>