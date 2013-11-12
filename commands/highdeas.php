<?php

include_once "publirc.php";

class highdeas implements IRCScript {
	 private $bot;

	public function __construct($bot) {
        $this->bot = $bot;
	}

    public function message($user, $channel, $message) {
		$boom = explode(" ", $message);
		$check = 'DeDubs';
		if($boom[0]==$check && $boom[1]=="What's" && $boom[2]=='good'){
			$message = "Not shit nigga, what's good with you";
			$this->bot->irc_message($channel, $message);
		}
    }

    public function join($channel) {

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

    }
}
?>