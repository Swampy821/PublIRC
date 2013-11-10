<?php

include_once "publirc.php";

class CakeFart implements IRCScript {
    private $bot;

	public function __construct($bot) {
        $this->bot = $bot;
	}

    public function message($user, $channel, $message) {
        if (rand(1, 5) === 3) {
            $this->bot->irc_action($channel, 'eats a cake and FARTS LOUDLY.');
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