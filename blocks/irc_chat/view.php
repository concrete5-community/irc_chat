<?php defined('C5_EXECUTE') or die('Access Denied.');

$th = Loader::helper('text');

if(Page::getCurrentPage()->isEditMode()) {
	?><div class="ccm-edit-mode-disabled-item" style="width:100%; height:<?php echo $height; ?>px; padding: <?php echo max(0, ($height >> 1) - 10); ?>px 0 0 0">
		<?php echo t('IRC chat disabled in edit mode.'); ?>
	</div><?php
}
else {
	?><iframe src="<?php echo $th->specialchars($chatUrl); ?>" style="width:100%; height:<?php echo $height; ?>px; border: 0">
		<?php echo t('Your browser does not support frames.')?><br>
		<?php echo t('To open the IRC chat <a href="%s" target="_blank">click here</a>.', $th->specialchars($chatUrl)); ?>
	</iframe><?php
}
