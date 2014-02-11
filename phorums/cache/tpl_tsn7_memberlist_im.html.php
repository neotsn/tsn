<?php if (!defined('IN_PHPBB')) exit; $this->_tpl_include('simple_header.html'); ?>


<br clear="all" />

<!-- MSNM info from http://www.cdolive.net/ - doesn't seem to work with MSN Messenger -->

<form method="post" action="<?php echo (isset($this->_rootref['S_IM_ACTION'])) ? $this->_rootref['S_IM_ACTION'] : ''; ?>">
	<table class="tablebg" width="95%" cellspacing="1" cellpadding="4" border="0" align="center">
	<tr>
		<th colspan="2"><?php echo ((isset($this->_rootref['L_SEND_IM'])) ? $this->_rootref['L_SEND_IM'] : ((isset($user->lang['SEND_IM'])) ? $user->lang['SEND_IM'] : '{ SEND_IM }')); ?></th>
	</tr>
	<tr>
		<td class="row3" colspan="2"><span class="gensmall"><?php echo ((isset($this->_rootref['L_SEND_IM_EXPLAIN'])) ? $this->_rootref['L_SEND_IM_EXPLAIN'] : ((isset($user->lang['SEND_IM_EXPLAIN'])) ? $user->lang['SEND_IM_EXPLAIN'] : '{ SEND_IM_EXPLAIN }')); ?></span></td>
	</tr>
	<tr>
		<td class="row1"><b class="genmed"><?php echo ((isset($this->_rootref['L_IM_RECIPIENT'])) ? $this->_rootref['L_IM_RECIPIENT'] : ((isset($user->lang['IM_RECIPIENT'])) ? $user->lang['IM_RECIPIENT'] : '{ IM_RECIPIENT }')); ?>: </b></td>
		<td class="row2"><span class="gen"><b><?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?></b><?php if ($this->_rootref['S_SEND_ICQ'] || $this->_rootref['S_SEND_AIM'] || $this->_rootref['S_SEND_MSNM']) {  ?> [ <?php echo (isset($this->_rootref['IM_CONTACT'])) ? $this->_rootref['IM_CONTACT'] : ''; ?> ]<?php } ?></span> <?php if ($this->_rootref['PRESENCE_IMG']) {  echo (isset($this->_rootref['PRESENCE_IMG'])) ? $this->_rootref['PRESENCE_IMG'] : ''; } ?></td>
	</tr>

	<?php if ($this->_rootref['S_SEND_AIM']) {  ?>

		<tr>
			<td class="row1" colspan="2" align="center"><br /><a class="gen" href="<?php echo (isset($this->_rootref['U_AIM_CONTACT'])) ? $this->_rootref['U_AIM_CONTACT'] : ''; ?>"><?php echo ((isset($this->_rootref['L_IM_ADD_CONTACT'])) ? $this->_rootref['L_IM_ADD_CONTACT'] : ((isset($user->lang['IM_ADD_CONTACT'])) ? $user->lang['IM_ADD_CONTACT'] : '{ IM_ADD_CONTACT }')); ?></a><br /><a class="gen" href="<?php echo (isset($this->_rootref['U_AIM_MESSAGE'])) ? $this->_rootref['U_AIM_MESSAGE'] : ''; ?>"><?php echo ((isset($this->_rootref['L_IM_SEND_MESSAGE'])) ? $this->_rootref['L_IM_SEND_MESSAGE'] : ((isset($user->lang['IM_SEND_MESSAGE'])) ? $user->lang['IM_SEND_MESSAGE'] : '{ IM_SEND_MESSAGE }')); ?></a><br /><br /><a class="gensmall" href="http://www.aim.com/download.adp"><?php echo ((isset($this->_rootref['L_IM_DOWNLOAD_APP'])) ? $this->_rootref['L_IM_DOWNLOAD_APP'] : ((isset($user->lang['IM_DOWNLOAD_APP'])) ? $user->lang['IM_DOWNLOAD_APP'] : '{ IM_DOWNLOAD_APP }')); ?></a> | <a class="gensmall" href="http://aimexpress.oscar.aol.com/aimexpress/launch.adp?Brand=AIM"><?php echo ((isset($this->_rootref['L_IM_AIM_EXPRESS'])) ? $this->_rootref['L_IM_AIM_EXPRESS'] : ((isset($user->lang['IM_AIM_EXPRESS'])) ? $user->lang['IM_AIM_EXPRESS'] : '{ IM_AIM_EXPRESS }')); ?></a> </td>
		</tr>
		<tr>
			<td class="cat" colspan="2" align="center">&nbsp;</td>
		</tr>
	<?php } if ($this->_rootref['S_SEND_MSNM']) {  ?>

		<tr>
			<td class="row1" colspan="2" align="center">
				<object classid="clsid:B69003B3-C55E-4B48-836C-BC5946FC3B28" codetype="application/x-oleobject" id="objMessengerApp" width="0" height="0"></object>
				<script type="text/javascript">
				// <![CDATA[
					var app = document.getElementById('objMessengerApp');
					
					/**
					* Check whether the browser supports this and whether MSNM is connected
					*/
					function msn_supported()
					{
						// Does the browser support the MSNM object?
						if (app.MyStatus) 
						{
							// Is MSNM connected?
							if (app.MyStatus == 1)
							{
								alert('<?php echo ((isset($this->_rootref['LA_IM_MSNM_CONNECT'])) ? $this->_rootref['LA_IM_MSNM_CONNECT'] : ((isset($this->_rootref['L_IM_MSNM_CONNECT'])) ? addslashes($this->_rootref['L_IM_MSNM_CONNECT']) : ((isset($user->lang['IM_MSNM_CONNECT'])) ? addslashes($user->lang['IM_MSNM_CONNECT']) : '{ IM_MSNM_CONNECT }'))); ?>');
								return false;
							}
						}
						else
						{
							alert('<?php echo ((isset($this->_rootref['LA_IM_MSNM_BROWSER'])) ? $this->_rootref['LA_IM_MSNM_BROWSER'] : ((isset($this->_rootref['L_IM_MSNM_BROWSER'])) ? addslashes($this->_rootref['L_IM_MSNM_BROWSER']) : ((isset($user->lang['IM_MSNM_BROWSER'])) ? addslashes($user->lang['IM_MSNM_BROWSER']) : '{ IM_MSNM_BROWSER }'))); ?>');
							return false;
						}
						return true;
					}

					/**
					* Add to your contact list
					*/
					function add_contact(address)
					{
						if (msn_supported())
						{
							// Could return an error while MSNM is connecting, don't want that
							try
							{
								app.AddContact(0, address);
							}
							catch (e)
							{
								return;
							}
						}
					}

					/**
					* Write IM to contact
					*/
					function im_contact(address)
					{
						if (msn_supported())
						{
							// Could return an error while MSNM is connecting, don't want that
							try
							{
								app.InstantMessage(address);
							}
							catch (e)
							{
								return;
							}
						}
					}
				// ]]>
				</script>
	
				<a class="gen" href="#" onclick="add_contact('<?php echo (isset($this->_rootref['A_IM_CONTACT'])) ? $this->_rootref['A_IM_CONTACT'] : ''; ?>'); return false;"><?php echo ((isset($this->_rootref['L_IM_ADD_CONTACT'])) ? $this->_rootref['L_IM_ADD_CONTACT'] : ((isset($user->lang['IM_ADD_CONTACT'])) ? $user->lang['IM_ADD_CONTACT'] : '{ IM_ADD_CONTACT }')); ?></a><br /><a class="gen" href="#" onclick="im_contact('<?php echo (isset($this->_rootref['A_IM_CONTACT'])) ? $this->_rootref['A_IM_CONTACT'] : ''; ?>'); return false;"><?php echo ((isset($this->_rootref['L_IM_SEND_MESSAGE'])) ? $this->_rootref['L_IM_SEND_MESSAGE'] : ((isset($user->lang['IM_SEND_MESSAGE'])) ? $user->lang['IM_SEND_MESSAGE'] : '{ IM_SEND_MESSAGE }')); ?></a>
			</td>
		</tr>
		<tr>
			<td class="cat" colspan="2" align="center">&nbsp;</td>
		</tr>
	<?php } if ($this->_rootref['S_SEND_JABBER']) {  ?>

		<tr>
			<td class="row1"><b class="genmed"><?php echo ((isset($this->_rootref['L_IM_MESSAGE'])) ? $this->_rootref['L_IM_MESSAGE'] : ((isset($user->lang['IM_MESSAGE'])) ? $user->lang['IM_MESSAGE'] : '{ IM_MESSAGE }')); ?>: </b></td>
			<td class="row2"><textarea class="post" name="message" rows="5" cols="45"></textarea></td>
		</tr>
		<tr>
			<td class="cat" colspan="2" align="center"><input class="btnmain" name="submit" type="submit" value="<?php echo ((isset($this->_rootref['L_IM_SEND'])) ? $this->_rootref['L_IM_SEND'] : ((isset($user->lang['IM_SEND'])) ? $user->lang['IM_SEND'] : '{ IM_SEND }')); ?>" /></td>
		</tr>
	<?php } if ($this->_rootref['S_NO_SEND_JABBER']) {  ?>

		<tr>
			<td class="row1" colspan="2"><span class="genmed"><?php echo ((isset($this->_rootref['L_IM_NO_JABBER'])) ? $this->_rootref['L_IM_NO_JABBER'] : ((isset($user->lang['IM_NO_JABBER'])) ? $user->lang['IM_NO_JABBER'] : '{ IM_NO_JABBER }')); ?></span></td>
		</tr>
	<?php } if ($this->_rootref['S_SENT_JABBER']) {  ?>

		<tr>
			<td class="row1" colspan="2" align="center"><span class="gen"><?php echo ((isset($this->_rootref['L_IM_SENT_JABBER'])) ? $this->_rootref['L_IM_SENT_JABBER'] : ((isset($user->lang['IM_SENT_JABBER'])) ? $user->lang['IM_SENT_JABBER'] : '{ IM_SENT_JABBER }')); ?></span></td>
		</tr>
		<tr>
			<td class="cat" colspan="2" align="center"></td>
		</tr>
	<?php } ?>


	</table>
	<a class="nav" href="#" onclick="window.close(); return false;"><?php echo ((isset($this->_rootref['L_CLOSE_WINDOW'])) ? $this->_rootref['L_CLOSE_WINDOW'] : ((isset($user->lang['CLOSE_WINDOW'])) ? $user->lang['CLOSE_WINDOW'] : '{ CLOSE_WINDOW }')); ?></a>
<?php echo (isset($this->_rootref['S_FORM_TOKEN'])) ? $this->_rootref['S_FORM_TOKEN'] : ''; ?>

</form>


<?php $this->_tpl_include('simple_footer.html'); ?>