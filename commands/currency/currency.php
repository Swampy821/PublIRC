<?php

//////////////////
//   Currency Plugin for PublIRC
//
//   Version: 0.1:
//		Initial Creation
//
//////////////////

include_once('currency_plugin.php');

class currency extends currency_plugin implements IRCScript {
	
	public function __construct($bot) {
        $this->bot = $bot;
	}
    public function message($user, $channel, $message) {
    	$db = array(
	'user' => 1,
	'username' => 'Demannu',
	'balance' => '1337',
	'hi_balance' => 1337
	);
    	$boom = explode(" ", $message);
		if($boom[0]=='!money'){
			$command = $boom[1]; 
		  	if($boom[1]=="balance"){
		  		$this->getBalance($user);
		  	} elseif($command == "add") {
		  		$message2 = "Tell Zimdale to hurry up on the DB so I can work";
				$this->bot->irc_message($channel, $message2);
		  	} elseif($command == "pay") {
		  		
		  	} elseif($command == "transfer") {
		  		
		  	} else {
		  		
		  	}
		  } else {
		  	
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