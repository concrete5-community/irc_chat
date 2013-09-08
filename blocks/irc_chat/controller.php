<?php defined('C5_EXECUTE') or die('Access Denied.');


class IrcChatBlockController extends BlockController {
	protected $btInterfaceWidth = 400;
	protected $btInterfaceHeight = 540;
	protected $btTable = 'btIrcChat';

	public function getBlockTypeName() {
		return t('IRC Chat');
	}

	public function getBlockTypeDescription() {
		return t('Direct access to IRC channels.');
	}
	
	public function getDefaultKiwiIRCServer() {
		return 'https://kiwiirc.com/client/';
	}

	public function getDefaultIRCNetworks() {
		return array(
			'DALnet' => 'irc.dal.net',
			'EFnet' => 'irc.efnet.org',
			'Freenode' => 'irc.freenode.net',
			'GameSurge' => 'irc.gamesurge.net',
			'IRCHighway' => 'irc.irchighway.net',
			'IRCnet' => 'open.ircnet.net',
			'QuakeNet' => 'irc.quakenet.org',
			'Rizon' => 'irc.rizon.net',
			'Snoonet' => 'irc.snoonet.org',
			'SwiftIRC' => 'irc.swiftirc.net',
			'Undernet (EU)' => 'eu.undernet.org',
			'Undernet (US)' => 'us.undernet.org',
			'Ustream' => 'chat1.ustream.tv'
		);
	}
	
	public function getDefaultThemes() {
		return array(
			'relaxed' => tc('KiwiIrcTheme', 'Relaxed'),
			'basic' => tc('KiwiIrcTheme', 'Basic'),
			'cli' => tc('KiwiIrcTheme', 'CLI (Dark)'),
			'mini' => tc('KiwiIrcTheme', 'Mini (Small)')
		);
	}

	private function normalize($data) {
		$e = Loader::helper('validation/error');
		if((!isset($data['height'])) || (!strlen($data['height']))) {
			$e->add(t('Please specify the height.'));
		}
		else {
			$data['height'] = (empty($data['height']) || !is_numeric($data['height'])) ? 0 : intval($data['height']);
			if($data['height'] <= 0) {
				$e->add(t('The height must be a number greater than zero.'));
			}
		}
		$data['serverKiwiIRC'] = isset($data['serverKiwiIRC']) ? trim($data['serverKiwiIRC']) : '';
		$customNetwork = isset($data['network_custom']) ? trim($data['network_custom']) : '';
		unset($data['network_custom']);
		if(strlen($customNetwork)) {
			$data['network'] = $customNetwork;
		}
		else {
			$data['network'] = isset($data['network']) ? trim($data['network']) : '';
		}
		if(!strlen($data['network'])) {
			$e->add(t('Please specify the IRC network.'));
		}
		$data['channel'] = isset($data['channel']) ? trim($data['channel']) : '';
		if(strlen($data['channel'])) {
			switch($data['channel'][0]) {
				case '&':
				case '#':
				case '+':
				case '!':
					if(strlen($data['channel']) == 1) {
						$data['channel'] = '';
					}
					break;
				default:
					$data['channel'] = '#' . $data['channel'];
					break;
			}
			if(strlen($data['channel'])) {
				foreach(array(' ', "\x07", ',') as $invalidChar) {
					if(strpos(substr($data['channel'], 1), $invalidChar) !== false) {
						$e->add(t('The channel name contains invalid characters.'));
						break;
					}
				}
			}
		}
		$customTheme = isset($data['theme_custom']) ? trim($data['theme_custom']) : '';
		unset($data['theme_custom']);
		if(strlen($customTheme)) {
			$data['theme'] = $customTheme;
		}
		else {
			$data['theme'] = isset($data['theme']) ? trim($data['theme']) : '';
		}
		$data['nicknameFromUsername'] = empty($data['nicknameFromUsername']) ? 0 : 1;
		$data['nickname'] = isset($data['nickname']) ? trim($data['nickname']) : '';
		if((!$data['nicknameFromUsername']) && strlen($data['nickname'])) {
			if(!preg_match('/^[a-z_\\-\\\\\\[\\]{}^`|]([0-9a-z_\\-\\\\\\[\\]{}^`|])*$/i', $data['nickname'])) {
				$e->add(t('The nick name contains invalid characters.'));
			}
		}
		if($e->has()) {
			return $e;
		}
		else {
			return $data;
		}
	}
	public function validate($data) {
		$e = $this->normalize($data);
		return is_array($e) ? true : $e;
	}
	public function save($data) {
		$data = $this->normalize($data);
		if(!is_array($data)) {
			throw new Exception(implode("\n", $data->getList()));
		}
		parent::save($data);
	}

	public function view() {
		$chatUrl = rtrim(strlen($this->serverKiwiIRC) ? $this->serverKiwiIRC : $this->getDefaultKiwiIRCServer(), '/');
		if(strlen($this->network)) {
			$chatUrl .= '/' . rawurldecode($this->network);
		}
		$chatUrl .= '/';
		$gets = array();
		$nickname = $this->nickname;
		if($this->nicknameFromUsername && User::isLoggedIn()) {
			$me = new User();
			$nickname = $me->getUserName();
			$nickname = preg_replace('/[^0-9a-z_\\-\\\\\\[\\]{}^`|]/i', '', $nickname);
			$nickname = preg_replace('/^[0-9]+/', '', $nickname);
		}
		if(strlen($nickname)) {
			$gets[] = 'nick=' . rawurlencode($nickname);
		}
		if(strlen($this->theme)) {
			$gets[] = 'theme=' . rawurlencode($this->theme);
		}
		if(count($gets)) {
			$chatUrl .= '?' . implode('&', $gets);
		}
		if(strlen($this->channel)) {
			$chatUrl .= $this->channel[0] . rawurlencode(substr($this->channel, 1));
		}
		$this->set('chatUrl', $chatUrl);
	}
}
