<?php if (!defined('IN_PHPBB')) exit; $this->_tpl_include('myspot_overall_header.html'); ?>

		<table cellspacing="0px" cellpadding="0px" border=0>
			<tr>
				<td width="100%" align="center">
					<table cellspacing="0px" cellpadding="0px" border=0 width="900">
						<tr>
							<td width="160" class="module-sidebox">
								<?php if ($this->_rootref['S_USER_LOGGED_IN']) {  ?><div id="divMiniProfile"></div><br /><?php } ?>

								<div id="divMiniForumIndex"></div>
							</td>
							<td width="10" nowrap></td>
							<td width="730" align="center" class="module-mainbox">
								<table cellspacing="0px" cellpadding="0px" border=0 width="730">
									<tr>
										<td width="360" class="module-mainbox">
											<div id="divSpecialReport"></div>									
										</td>
										<td width="10" nowrap>&nbsp;</td>
										<td width="360" class="module-mainbox"><!-- <div id="divTwitterFeed"></div> -->
											<script src="http://widgets.twimg.com/j/2/widget.js"></script>
											<script>
											new TWTR.Widget({
											  version: 2,
											  type: 'profile',
											  rpp: 3,
											  interval: 6000,
											  width: 360,
											  height: 180,
											  theme: {
												shell: {
												  background: '#003366',
												  color: '#ffffff'
												},
												tweets: {
												  background: '#d7e3f6',
												  color: '#003366',
												  links: '#587eaa'
												}
											  },
											  features: {
												scrollbar: false,
												loop: false,
												live: true,
												hashtags: true,
												timestamp: true,
												avatars: false,
												behavior: 'all'
											  }
											}).render().setUser('thespotnet').start();
											</script>
										</td>
									</tr>
								</table>
								<br />
								<table cellspacing=1 cellpadding="0px" border=0 width="730">
									<tr>
										<td width="590" class="module-mainbox" rowspan="2">
											<?php $this->_tpl_include('modules/newposts.html'); ?>

											<br />
											<div style="width: 100%; text-align: center;">
												<center>
												<!-- ++Begin Video Bar Wizard Generated Code++ -->
												<!--
												// Created with a Google AJAX Search Wizard
												// http://code.google.com/apis/ajaxsearch/wizards.html
												-->

												<!--
												// The Following div element will end up holding the actual videobar.
												// You can place this anywhere on your page.
												-->
												<div id="videoBar-bar">
												<span style="color:#676767;font-size:11px;margin:10px;padding:4px;">Loading...</span>
												</div>

												<!-- Ajax Search Api and Stylesheet
												// Note: If you are already using the AJAX Search API, then do not include it
												//       or its stylesheet again
												-->
												<script src="http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-vbw"
												type="text/javascript"></script>
												<style type="text/css">
												@import url("http://www.google.com/uds/css/gsearch.css");
												</style>

												<!-- Video Bar Code and Stylesheet -->
												<script type="text/javascript">
												window._uds_vbw_donotrepair = true;
												</script>
												<script src="http://www.google.com/uds/solutions/videobar/gsvideobar.js?mode=new"
												type="text/javascript"></script>
												<style type="text/css">
												@import url("http://www.google.com/uds/solutions/videobar/gsvideobar.css");
												</style>

												<style type="text/css">
												.playerInnerBox_gsvb .player_gsvb {
												width : 320px;
												height : 260px;
												}
												</style>
												<script type="text/javascript">
												function LoadVideoBar() {

												var videoBar;
												var options = {
												largeResultSet : !true,
												horizontal : true,
												autoExecuteList : {
												cycleTime : GSvideoBar.CYCLE_TIME_MEDIUM,
												cycleMode : GSvideoBar.CYCLE_MODE_LINEAR,
												executeList : ["ytchannel:neotsnx","ytchannel:tgrbaseball13","ytchannel:jermlac","ytchannel:bcjammer","ytchannel:PFCscare","ytchannel:rueishness","ytchannel:apoetsdreamsoflove","ytchannel:abrimath","ytchannel:Gadg3tGirlMarie","ytchannel:whwells3"]
												}
												}

												videoBar = new GSvideoBar(document.getElementById("videoBar-bar"),
														  GSvideoBar.PLAYER_ROOT_FLOATING,
														  options);
												}
												// arrange for this function to be called during body.onload
												// event processing
												GSearch.setOnLoadCallback(LoadVideoBar);
												</script>
												<!-- ++End Video Bar Wizard Generated Code++ -->
												</center>
											</div>
											<br />
											<?php $this->_tpl_include('modules/stats.html'); ?>

										</td>
										<td width="10" rowspan="2" nowrap>&nbsp;</td>
										<td width="140" class="module-sidebox">
											<!-- NCLUDE modules/twitter-stats.html 
											<br />-->
											<?php $this->_tpl_include('modules/flickr_pics.html'); ?>

											<br />
											<?php $this->_tpl_include('modules/niftystuff.html'); ?>

										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>			
		</table>
<?php $this->_tpl_include('overall_footer.html'); ?>