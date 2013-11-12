<?php

class hooker_system {
    public $products = array();

    public $bot;

    var $flat_string;
    
    var $hook_path = 'C:\wamp\www\PublIRC\PublIRC_core\hookerbot\PublIRC\commands/Hooker/hooks.dat';

    public function build_product_array()
    {
        //Build hooking products array. 
        $building_array = array();
        $building_array_2 = array();
        $file = fopen($this->hook_path,'a+');
        $file_size = filesize($this->hook_path);
        $this->flat_string = fread($file,$file_size);
        $building_array = explode('~~',$this->flat_string);
        foreach($building_array as $key=>$value)
        {
            $building_array_2 = explode('|||',$value);
            if($building_array_2[0])
            {
               $this->products[$building_array_2[0]] = $building_array_2[1]; 
            }
        }
        ksort($this->products);
    }
    /**
    *Will return the product within price rage. If there is no product of that price range, will return false. 
    *
    *Example:
    *<pre>
    *   
    *</pre>
    *
    *Revision Description:
    *<pre>
    *  v1.0.0 - Intitial Creation
    *</pre>
    *
    *@Name ask_for_service
    *@param Integer $price Price of product
    *@Release Released 11/11/2013
    *@return String/Boolean Returns string of product if successful, if there is no product in that price range, will return false. 
    */
    public function ask_for_service($price, $user)
    {

        //TODO: Check to see if user isn't a bum prior to giving him any goods. 


        if(isset($this->products[$price]))
        {
            //If product matches exact price return that product
            return "ACTION ".str_replace('%user%',$user,$this->products[$price]);

        }else{
            foreach($this->products as $key=>$value)
            {
                $next_price = $this->get_next_array_key($key,$this->products);
                if($price>$key)
                {
                    if(!$next_price )
                    {
                        return "ACTION ".str_replace('%user%',$user, $value);
                    }else if($price<$next_price)
                    {
                       return "ACTION ".str_replace('%user%',$user, $value); 
                    }
                }
            }
        }
        return false;
    }
    /**
    *DESCRIPTION
    *
    *Example:
    *<pre>
    *
    *</pre>
    *
    *Revision Description:
    *<pre>
    *  v1.0.0 - Intitial Creation
    *</pre>
    *
    *@Name FUNCTION_NAME
    *@param PARAM_TYPE PARAM_NAME PARAM_DESCRIPTION
    *@return RETURN_STUFF
    */
    private function get_next_array_key($current_key, $array = array())
    {
        $keys = array_keys($array);
        $current_index = array_search($current_key, $keys);
        if($current_index == count($keys))
        {
            return false;
        }  
        if(isset($keys[$current_index+1]))
        {
            return $keys[$current_index+1];
        }else{
            return false;
        }
    }
    /**
     *DESCRIPTION
     *
     *Example:
     *<pre>
     *
     *</pre>
     *
     *Revision Description:
     *<pre>
     *  v1.0.0 - Intitial Creation
     *</pre>
     *
     *@Name FUNCTION_NAME
     *@param PARAM_TYPE PARAM_NAME PARAM_DESCRIPTION        
     *@return RETURN_STUFF
     */ 
    private function save_hooks()
    {
        $save_string = '';
        foreach($this->products as $key=>$value)
        {
            $save_string .= $key."|||".$value."~~";
        }
        $save_string = str_replace(array("\r","\n"),'',$save_string);
        $file = fopen($this->hook_path,'w');
        fwrite($file,$save_string);
        fclose($file);
    }
    /**
    *DESCRIPTION
    *
    *Example:
    *<pre>
    *
    *</pre>
    *
    *Revision Description:
    *<pre>
    *  v1.0.0 - Intitial Creation
    *</pre>
    *
    *@Name FUNCTION_NAME
    *@param PARAM_TYPE PARAM_NAME PARAM_DESCRIPTION
    *@return RETURN_STUFF
    */
    private function add_hook($hook_price, $hook_action)
    {
        if(isset($this->products[$hook_price]))
        {
            return false;
        }else{
            $this->products[$hook_price] = str_replace(array("|||","~~"),'',$hook_action);
            $this->save_hooks();
            return true;
        }
    }
    /**
    *DESCRIPTION
    *
    *Example:
    *<pre>
    *
    *</pre>
    *
    *Revision Description:
    *<pre>
    *  v1.0.0 - Intitial Creation
    *</pre>
    *
    *@Name FUNCTION_NAME
    *@param PARAM_TYPE PARAM_NAME PARAM_DESCRIPTION
    *@return RETURN_STUFF
    */
    private function remove_hook($hook_price)
    {
        echo "PRODUCT: ".$this->products[(int)$hook_price];
        if(isset($this->products[(int)$hook_price]))
        {
            unset($this->products[(int)$hook_price]);
            $this->save_hooks();
            return true;
        }else{
            return false;
        } 
    }
    /**
    *DESCRIPTION
    *
    *Example:
    *<pre>
    *
    *</pre>
    *
    *Revision Description:
    *<pre>
    *  v1.0.0 - Intitial Creation
    *</pre>
    *
    *@Name FUNCTION_NAME
    *@param PARAM_TYPE PARAM_NAME PARAM_DESCRIPTION
    *@return RETURN_STUFF
    */
    public function process_command($command, $user, $channel)
    {
        $command = explode(" ",$command);
        foreach($command as $key=>$value)
            $command[$key]=str_replace("\r\n",'',$value);
        //If you are going to pay the lady
        if(substr($command[0],0,1)=='$')
        {
            $amount = substr($command[0],1,strlen($command[0]));
            $serve = $this->ask_for_service((int)$amount,$user);
            if($serve)
            {
                return $serve;
            }else{
                return "I don't work for cheap! Fuck you!";
            }
        }
        //If you're going to add abilities.
        if(strtolower($command[0])=='add')
        {
            $messsage = '';
            for($i=2;$i<count($command);$i++)
            {
                $message .= $command[$i].' ';
            }
            if($this->add_hook(substr($command[1],1,strlen($command[1])),$message))
            {
                return "Okay, I guess I could do that.";
            }else{
                return "I already have something set for that price. Try again!";
            }
        }
        //If you are going to remove abilities 
        if(strtolower($command[0])=='remove')
        {
            if($this->remove_hook(substr($command[1],1,strlen($command[1]))))
            {
                return "Okay I won't do that anymore.";
            }else{
                return "I don't have anything set for ".$command[1]." anyway.";
            }
        }
        //Check Prices
        if(strtolower($command[0])=='prices')
        {
            foreach($this->products as $key=>$value)
            {
                $ex = explode(' ',$value);
                $ex[0] = substr($ex[0],0,strlen($ex[0])-1);
                $ret = '';
                foreach($ex as $val)
                {
                    $ret .= $val.' ';
                }
                $ret = rtrim($ret);
                $this->bot->irc_message($channel, "For $".$key." I can ".str_replace("goe", "go",str_replace('%user%','you',$ret)));
            };
        }

        //If you slap her
        if(strtolower($command[0])=='slaps')
        {
            if($user=="Zimdale")
            {
                $this->bot->irc_message($channel, "Oh thanks boss. I deserved that.");
            }else{
                $message = "falls over in pain.";
                $this->bot->irc_action($channel,Rtrim($message));
                sleep(5);
                $message = "gets up and storms off crying.";
                $this->bot->irc_action($channel,Rtrim($message));
            }
        }


    }
}