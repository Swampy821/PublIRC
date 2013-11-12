<?php

//////////////////
//   Currency Plugin for PublIRC
//
//   Version: 0.1:
//		Initial Creation
//
//////////////////

class currency_plugin {
	public $bot;
	
	/*
	 * Adds money to the user
	 * 
	 * @param user amount
	 */
	public function addMoney($user, $amount) {
		// database stuff
	}
	
	public function payMoney($user, $amount) {
		// database stuff
	}
	
	public function transferMoney($userfrom, $userto, $amount) {
		// database stuff
	}
	
	public function getBalance($user) {
		// database stuff
		$message1 = $user." Your balance is ".$db['balance']." Thank you and have a good day";
		$this->bot->irc_message($user, $message1);
	}
	
	
}
