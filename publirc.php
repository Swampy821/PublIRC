<?php

//function __autoload($class_name) {
//	if (file_exists('commands/' . $class_name . '.php')) {
//		require_once('commands/' . $class_name . '.php');
//		return;
//	}
//}

include_once 'commands/CakeFart.php';
include_once 'commands/Ping.php';

class PublIRC {
	private $socket = NULL;
	private $config = array(
		'server' => '',
		'port'   => 6667,
		'nick'   => '',
		'user'   => '',
		'name'   => '',
		'pass'   => ''
	);
	private $running = true;
	private $loaded_modules = array();

	function __construct($config) {
		$this->config = $config;

		// TODO: Proper dynamic loading
		array_push($this->loaded_modules, new CakeFart($this));
		array_push($this->loaded_modules, new Ping($this));

		$this->socket = fsockopen($this->config['server'], $this->config['port']);
		stream_set_blocking($this->socket, 0);
		$this->connect();
		$this->irc_join_channel('##Core'); // TODO: Proper startup channel system
	}

	function run() {
		while ($this->running) {
			$data = fgets($this->socket, 128);
			$this->log($data);
			flush();

			$this->process_line($data);
		}
	}

	function process_line($data) {
		if ($data) {
			$explodedData = explode(' ', $data);
			foreach ($this->loaded_modules as $module) { // TODO: REDO THIS WHOLE PART. JUST JUNK FOR TESTING
				if (sizeof($explodedData) > 3 and $explodedData[1] == 'PRIVMSG') {
					$module->message(substr(explode('!', $explodedData[0])[0], 1), $explodedData[2], substr(implode(array_slice($explodedData, 3), ' '), 1));
				}
				$module->all($data);
				// TODO: Support for all plugin events.
			}
		}
	}

	function send_line($line) {
		echo $line . "\r\n";
		fputs($this->socket, $line . "\r\n");
		flush();
	}

	function log($line) { // TODO: Add logging output settings to config, timestamps
		echo $line;
	}

	function connect($password = '') {
		if ($password != '') {
			$this->send_line('PASS ' + $password);
		}
		$this->irc_nick($this->config['nick']);
		$this->send_line('USER ' . $this->config['user'] . ' ' . $this->config['server'] . ' * :' . $this->config['name']);
	}

	function irc_message($target, $message) {
		$this->send_line('PRIVMSG ' . $target . ' :' . $message);
	}

	function irc_action($target, $action) {
		$this->send_line('PRIVMSG ' . $target . ' :' . chr(1) . 'ACTION ' . $action . chr(1));
	}

	function irc_nick($nick) {
		$this->config['nick'] = $nick;
		$this->send_line('NICK :' . $nick);
	}

	function irc_join_channel($channel) {
		$this->send_line('JOIN ' . $channel);
	}

	function irc_part_channel($channel) {
		$this->send_line('PART ' . $channel);
	}

	function irc_quit($reason = 'Client Quit') {
		$this->send_line('QUIT :' . $reason);
		$this->running = false;
		fclose($this->socket);
	}
}

class IRCColor {
	const NONE       = '1';  
	const BLACK      = '1';  
	const NAVY_BLUE  = '2';  
	const GREEN      = '3';  
	const RED        = '4';  
	const BROWN      = '5';  
	const PURPLE     = '6';  
	const OLIVE      = '7';  
	const YELLOW     = '8';  
	const LIME_GREEN = '9';  
	const TEAL       = '10'; 
	const CYAN       = '11'; 
	const BLUE       = '12'; 
	const PINK       = '13'; 
	const DARK_GREY  = '14'; 
	const LIGHT_GREY = '15'; 
	const WHITE      = '16'; 
}

interface IRCScript {
	public function __construct($bot); // on plugin initialization
    public function message ($user, $channel, $message); // on any PRIVMSG
    public function join    ($channel); // when the bot joins a channel
    public function part    ($channel); // when the bot parts a channel
    public function connect ($server); // when the bot connects to a server
    public function userJoin($user, $channel); // when another user joins a channel
    public function userPart($user, $channel); // when another user parts a channel
    public function userQuit($user, $message); // when another user disconnects from a server
    public function userKick($kicked, $kicker, $channel, $message); // when a user gets kicked from a channel
    public function cycle   (); // every main loop cycle
    public function all     ($line); // all incoming lines
}