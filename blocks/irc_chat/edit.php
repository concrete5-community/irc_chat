<?php defined('C5_EXECUTE') or die('Access Denied.');

$th = Loader::helper('text');

if(empty($height)) {
	$height = 450;
}
?>
<div class="control-group">
	<label class="control-label" for="height"><?php echo t('Height'); ?>:</label>
	<div class="controls">
		<input type="text" id="height" name="height" value="<?php $th->slecialchars($height); ?>" />
	</div>
</div>
<div class="control-group">
	<label class="control-label" for="kiwiServer"><?php echo t('KiwiIRC server: '); ?></label>
	<div class="controls">
		<input type="text" id="kiwiServer" />
	</div>
</div>
