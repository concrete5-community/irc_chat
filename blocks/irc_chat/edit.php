<?php defined('C5_EXECUTE') or die('Access Denied.');

$th = Loader::helper('text');
$fh = Loader::helper('form');

if(empty($height)) {
	$height = 450;
}
$linkForPhones = empty($linkForPhones) ? false : true;
$linkForTablets = empty($linkForTablets) ? false : true;
if(!isset($serverKiwiIRC)) {
	$serverKiwiIRC = '';
}
$networkSSL = empty($networkSSL) ? false : true;
if(!isset($network)) {
	$network = '';
}
if(!isset($channel)) {
	$channel = '';
}
if(!isset($channelKey)) {
	$channelKey = '';
}
if(!isset($theme)) {
	$theme = '';
}
if(!isset($nickname)) {
	$nickname = '';
}
$nicknameFromUsername = empty($nicknameFromUsername) ? false : true;
$debugKiwiIRC = empty($debugKiwiIRC) ? false : true;
?>

<div class="ccm-ui">

	<ul class="tabs" id="ircchat-tabheaders">
		<li><a href="javascript:void(0)" id="ircchat-tabheader-irc"><?php echo t('IRC')?></a></li>
		<li><a href="javascript:void(0)" id="ircchat-tabheader-appearance"><?php echo t('Appearance')?></a></li>
		<li><a href="javascript:void(0)" id="ircchat-tabheader-advanced"><?php echo t('Advanced options')?></a></li>
		<li><a href="javascript:void(0)" id="ircchat-tabheader-about"><?php echo t('About')?></a></li>
	</ul>

	<div class="spacer"></div>

	<div class="ircchat-tabpane" id="ircchat-tabpane-irc">
		<?php
			$defaultNetworks = $controller->getDefaultIRCNetworks();
			$defaultNetworkSelected = '';
			$customNetwork = '';
			if(strlen($network)) {
				$customNetwork = $network;
				foreach($defaultNetworks as $defaultNetwork) {
					if(strcasecmp($defaultNetwork, $network) === 0) {
						$defaultNetworkSelected = $defaultNetwork;
						$customNetwork = '';
						break;
					}
				}
			}
		?>
		<label>
			<b><?php echo t('IRC network'); ?>:</b>
			<?php echo $fh->select('network', array_merge(array('' => t('Please select')), array_flip($defaultNetworks)), $defaultNetworkSelected); ?>
		</label>
		<label>
			<?php echo t('Or enter a custom IRC network (in the form <i>host:port</i>)'); ?>:
			<input type="text" maxlength="150" name="network_custom" value="<?php echo $th->specialchars($customNetwork); ?>">
		</label>
		<br>
		<label>
			<b><?php echo t('IRC channel'); ?>:</b>
			<input type="text" maxlength="150" name="channel" value="<?php echo $th->specialchars($channel); ?>">
		</label>
		<br>
		<label>
			<b><?php echo t('Nickname'); ?>:</b>
			<input type="text" maxlength="50" name="nickname" value="<?php echo $th->specialchars($nickname); ?>">
		</label>
		<label class="checkbox">
			<input type="checkbox" name="nicknameFromUsername" <?php echo $nicknameFromUsername ? ' checked' : ''?>>
			<?php echo t('Suggest nickname from username of logged-in users'); ?>
		</label>
	</div>

	<div class="ircchat-tabpane" id="ircchat-tabpane-appearance">
		<label>
			<b><?php echo t('Height (in pixels)'); ?>:</b>
			<input type="number" min="1" name="height" value="<?php echo $th->specialchars($height); ?>">
		</label>
		<br>
		<?php
			$defaultThemes = $controller->getDefaultThemes();
			$defaultThemeSelected = '';
			$customTheme = '';
			if(strlen($theme)) {
				$customTheme = $theme;
				foreach(array_keys($defaultThemes) as $defaultTheme) {
					if(strcasecmp($defaultTheme, $theme) === 0) {
						$defaultThemeSelected = $defaultTheme;
						$customTheme = '';
						break;
					}
				}
			}
		?>
		<label>
			<b><?php echo t('Theme'); ?>:</b>
			<?php echo $fh->select('theme', array_merge(array('' => tc('KiwiIrcTheme', 'None/default')), $defaultThemes), $defaultThemeSelected); ?>
		</label>
		<label>
			<?php echo t('Or enter a custom theme'); ?>:
			<input type="text" maxlength="50" name="theme_custom" value="<?php echo $th->specialchars($customTheme); ?>">
		</label>
		<br>
		<b><?php echo t('Device types')?>:</b><br>
		<label class="checkbox">
			<input type="checkbox" name="linkForPhones" <?php echo $linkForPhones ? ' checked' : ''?>>
			<?php echo t('show only a link for mobile phones'); ?>
		</label>
		<label class="checkbox">
			<input type="checkbox" name="linkForTablets" <?php echo $linkForTablets ? ' checked' : ''?>>
			<?php echo t('show only a link for tablets'); ?>
		</label>
	</div>

	<div class="ircchat-tabpane" id="ircchat-tabpane-advanced">
		<label>
			<b><?php echo t('KiwiIRC server'); ?>:</b>
			<input type="url" maxlength="150" name="kiwiServer" value="<?php echo $th->specialchars($serverKiwiIRC); ?>">
			<?php echo t('Leave empty to use the default (%s)', $controller->getDefaultKiwiIRCServer()); ?>
		</label>
		<br>
		<label>
			<b><?php echo t('Key for the IRC channel'); ?>:</b>
			<input type="text" maxlength="150" name="channelKey" value="<?php echo $th->specialchars($channelKey); ?>">
		</label>
		<br>
		<b><?php echo t('Other options'); ?>:</b><br>
		<label class="checkbox">
			<input type="checkbox" name="networkSSL" <?php echo $networkSSL ? ' checked' : ''?>>
			<?php echo t('connect to IRC network with SSL'); ?>
		</label>
		<label class="checkbox">
			<input type="checkbox" name="debugKiwiIRC" <?php echo $debugKiwiIRC ? ' checked' : ''?>>
			<?php echo t('debug enabled'); ?>
		</label>
	</div>

	<div class="ircchat-tabpane" id="ircchat-tabpane-about">
		<p><?php echo t('This block uses <a href="https://kiwiirc.com/" target="_blank">KiwiIRC</a>.'); ?></p>
	</div>

</div>
