<?php defined('C5_EXECUTE') or die('Access denied.');

class IrcChatPackage extends Package {

	protected $pkgHandle = 'irc_chat';
	protected $appVersionRequired = '5.6.1';
	protected $pkgVersion = '0.9.0';

	public function getPackageName() {
		return t('IRC Chat');
	}

	public function getPackageDescription() {
		return t('Allow inserting a block in your website to partecipate to IRC chats.');
	}

	public function install() {
		$pkg = parent::install();
		$this->installOrUpgrade($pkg);
	}

	public function upgrade() {
		$currentVersion = $this->getPackageVersion();
		parent::upgrade();
		$this->installOrUpgrade($this, $currentVersion);
	}

	private function installOrUpgrade($pkg, $upgradeFromVersion = '') {
		if(!is_object(BlockType::getByHandle('irc_chat'))) {
			BlockType::installBlockTypeFromPackage('irc_chat', $pkg);
		}
	}
}
