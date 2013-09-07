<?php defined('C5_EXECUTE') or die('Access Denied.');

class IrcChatBlockController extends BlockController {

	protected $btInterfaceWidth = 500;
	protected $btInterfaceHeight = 400;
	protected $btTable = 'btIrcChat';

	public function getBlockTypeName() {
		return t('IRC Chat');
	}

	public function getBlockTypeDescription() {
		return t('Direct access to IRC channels.');
	}

}