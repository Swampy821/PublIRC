<?php
include_once("Hooker_system.php");

class Hooker extends Hooker_system implements IRCScript {
    

	public function __construct($bot) {
        $this->bot = $bot;
        $this->build_product_array();
    }
    public function message($user, $channel, $message) {
        if(substr(strtolower($message),0,7)=="!hooker" || 
           strpos($message,$this->bot->config['nick']) || 
           (substr(strtolower($message),8,4)=="tips" && strpos($message,$this->bot->config['nick']))
           )
        {
            if(substr(strtolower($message),8,4)=="tips")
            {
                $command = rtrim(substr($message,12+strlen(' '.$this->bot->config['nick']),strlen($message)),chr(1));
                $command = preg_replace("/[^0-9,.]/", "",$command);
                $command = '$'.$command;
            }else{
                $command = substr($message,8,strlen($message));
            }
            $return = $this->process_command($command,$user,$channel);
            if(strlen($return)>4)
            {
                if(substr($return,0,6)=='ACTION')
                {
                    $return = substr($return,7,strlen($return));
                    $this->bot->irc_action($channel,Rtrim($return));
                }else{
                    $this->bot->irc_message($channel, Rtrim($return));
                }
                
            }
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
        return $this->ask_for_service(66);
    }

    public function all($line) {

    }
}