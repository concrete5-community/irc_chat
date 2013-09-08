<?php defined('C5_EXECUTE') or die('Access Denied.');

$th = Loader::helper('text');
$fh = Loader::helper('form');
$fh = new Concrete5_Helper_Form();
if(!isset($height)) {
	$height = 450;
}
if(!isset($serverKiwiIRC)) {
	$serverKiwiIRC = '';
}
if(!isset($network)) {
	$network = '';
}
if(!isset($channel)) {
	$channel = '';
}
if(!isset($theme)) {
	$theme = '';
}
if(!isset($nickname)) {
	$nickname = '';
}
$nicknameFromUsername = empty($nicknameFromUsername) ? false : true;
?>
<div class="ccm-ui">
	<label>
		<b><?php echo t('Height (in pixels)'); ?>:</b>
		<input type="number" min="1" name="height" value="<?php echo $th->specialchars($height); ?>">
	</label>
	<br>
	<label>
		<b><?php echo t('KiwiIRC server'); ?>:</b>
		<input type="url" maxlength="150" name="kiwiServer" value="<?php echo $th->specialchars($serverKiwiIRC); ?>">
		<?php echo t('Leave empty to use the default (%s)', $controller->getDefaultKiwiIRCServer()); ?>
	</label>
	<br>
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
		<?php echo t('Or enter a custom IRC network:'); ?>
		<input type="text" maxlength="150" name="network_custom" value="<?php echo $th->specialchars($customNetwork); ?>">
	</label>
	<br>
	<label>
		<b><?php echo t('IRC channel'); ?>:</b>
		<input type="text" maxlength="150" name="channel" value="<?php echo $th->specialchars($channel); ?>">
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
		<?php echo t('Or enter a custom theme:'); ?>
		<input type="text" maxlength="50" name="theme_custom" value="<?php echo $th->specialchars($customTheme); ?>">
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
