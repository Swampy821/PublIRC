<?php

include_once 'publirc.php';

set_time_limit(0);
ini_set('display_errors', 'on');

$config = array(
    'server' => 'irc.freenode.net',
    'port'   => 6667,
    'nick'   => 'DeDubs',
    'user'   => 'Kushner', 
    'name'   => 'DeDubs Kushner',
    'pass'   => '',
	'startup_channel' => '##antib9'
);

$irc = new PublIRC($config);
$irc->run();