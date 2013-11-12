<?php

include_once "publirc.php";

class basicAdmin implements IRCScript {
	 private $admin = array(
	 	'CoreSystems',
	 	'Zimdale',
	 	'SkySom',
	 	'Demannu'
	 );
	 
	private $bot;

	public function __construct($bot) {
        $this->bot = $bot;
	}
	// TODO: Fix the length of the repeat. It cuts off.
    public function message($user, $channel, $message) {
		$bA_boom = explode(" ", $message);
		if($bA_boom[0]=='!quit') {
			if(in_array($user,$this->admin)){
				$this->bot->irc_message($channel, 'As you command master');
				$this->bot->irc_quit('');
			} else {
			$this->bot->irc_message($channel, 'Fuck off, I dont know you.');
			
			}
			
		} elseif($bA_boom[0]=='!say') {
			
			$message = substr($message,5,255);
			$this->bot->irc_message($channel, $message);
			
		} elseif($bA_boom[0]=='!restart') { // TODO: Fix this, totally broken
		
			$message = 'Restarting master';
			$this->bot->irc_message($channel, $message);
			$this->bot->irc_quit();
			// No idea how to get it to restart itself
			
		} elseif($bA_boom[0]=='!op') {
			
			$this->bot->irc_op($channel, $bA_boom[1]);
			
		} elseif($bA_boom[0]=='!deop') {
			
			if($bA_boom[1]==$this->bot->config['nick']) {
				
				$this->bot->irc_message($channel, "How about fuck yourself");
				
			} else {
				
			$this->bot->irc_deop($channel, $bA_boom[1]);
			
			}
			
		} elseif($bA_boom[0]=='!join') {
			
			$this->bot->irc_join_channel($bA_boom[1]);
			
		} elseif($bA_boom[0]=='!part') {
			
			$this->bot->irc_part_channel($bA_boom[1]);
			
		}
		
    }

    public function join($channel) {
		$message = 'Greetings '.$channel.', I am '.$this->bot->config['Nick'].'. Banker, Dealer, and Pimp. Hit a dude up with !help';
		$this->bot->irc_message($channel, $message);
    }

    public function part($channel) {

    }

    public function connect($server) {
		
    }

    public function userJoin($user, $channel) {
    	
    } 
 
    public function userPart($user, $channel) {
 
    } 
 
    public function userQuit($user, $message) {
 
    } 
 
    public function userKick($kicked, $kicker, $channel, $message) {
 
    }

    public function cycle() {

    }

    public function all($line) {
    	$stamp = date("Y-m-d H:i:s");
		$log_line = "[".$stamp."] ".$line;
		$openlog = fopen('c:/wamp/www/PublIRC/PublIRC/data/log.dat', 'a+');
		fwrite($openlog, $log_line);
		fclose($openlog);
    }
}
	