<?php

include_once "publirc.php";

class basicAdmin implements IRCScript {
	 private $admin = array(
	 'admin' => 'CoreSystems',
	 'admin' => 'Zimdale',
	 'admin' => 'SkySom',
	 'admin' => 'Demannu'
	 );
	 
	private $bot;

	public function __construct($bot) {
        $this->bot = $bot;
	}
	// TODO: Fix the length of the repeat. It cuts off.
    public function message($user, $channel, $message) {
		$bA_boom = explode(" ", $message);
		if($bA_boom[0]=='!quit') {
			if($user=='Demannu'){
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
			$this->bot->irc_quit('');
			// No idea how to get it to restart itself
		} elseif($bA_boom[0]=='!op') {
			$this->bot->irc_op($channel, $bA_boom[1]);
		} elseif($bA_boom[0]=='!deop') {
			$this->bot->irc_deop($channel, $bA_boom[1]);
		} elseif($bA_boom[0]=='!join') {
			$this->bot->irc_join_channel($bA_boom[1]);
		}
    }

    public function join($channel) {

    }

    public function part($channel) {

    }

    public function connect($server) {

    }

    public function userJoin($user, $channel) {
		$this->bot->irc_op($channel, $user);
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
    	
    }
}
	