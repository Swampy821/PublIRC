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
		  	if($boom[1]=="balance"){
		  		$balance = $this->getBalance($user);
		  		$message1 = $user." Your balance is $".$balance." Thank you and have a good day";
				$this->bot->irc_message($user, $message1);
		  	} elseif($boom[1] == "add") {
		  		if(!empty($boom[2])) {
		  			$this->addMoney($user, $boom[2]);
					$message2 = 'The deposit of $'.$boom[2].' To the account of '.$user.' Has been completed.';
					$this->bot->irc_message($user, $message2);
		  		}
		  	} elseif($boom[1] == "pay") {
		  			$this->payMoney($user, $boom[2]);
					$message3 = 'The deducation of $'.$boom[2].' From the account '.$user.' Has been complteted.';
					$this->bot->irc_message($user, $message3);
		  	} elseif($boom[1] == "transfer") {
		  		if($user==$boom[2]){
		  			$this->transferMoney($user, $boom[2], $boom[3]);
					$message4 = 'The transfer of $'.$boom[4].' From '.$user.' To '.$boom[3].' Has been completed.';
					$this->bot->irc_message($user, $message4);
				} else {
					$er_no2 = "Hey Asshole, you can only transfer from you to someone else";
					$this->bot->irc_message($channel, $er_no2);
				}
		  	} else { 
		  		$error = "Error! Please use one of the following commands";
		  		$error2 = '!money balance';
		  		$error3 = '!money add {amount} ';
		  		$error4 = '!money pay {amount}';
				$error5 = '!money transfer user1 user2 {amount}';
				$this->bot->irc_message($channel, $error);
				$this->bot->irc_message($channel, $error2);
				$this->bot->irc_message($channel, $error3);
				$this->bot->irc_message($channel, $error4);
				$this->bot->irc_message($channel, $error5);
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