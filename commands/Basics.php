<?php

//include_once "publirc.php";

class Basics implements IRCScript {
    private $bot;

	public function __construct($bot) {
        $this->bot = $bot;
	}

    public function message($user, $channel, $message) {
    $message = rtrim($message);
    $check = rtrim(strtolower("go away ".$this->bot->config['nick']));
    $message = substr($message,0,strlen($check));
       if(strtolower($message) == strtolower($check))
       {
            $this->bot->irc_quit("Gone Bananas!");
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