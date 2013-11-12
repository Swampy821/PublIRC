<?php

include_once "../publirc.php";

class Ping implements IRCScript {
    private $bot;

	public function __construct($bot) {
        $this->bot = $bot;
	}

    public function message($user, $channel, $message) {

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
        if (strpos($line, 'PING') === 0 and strpos($line, ' ') !== FALSE) {
            $this->bot->send_line('PONG ' . explode(' ', $line)[1]);
        }
    }
}