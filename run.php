<?php

include_once 'publirc.php';

set_time_limit(0);
ini_set('display_errors', 'on');

$config = array(
<<<<<<< HEAD
    'server' => 'irc.freenode.net',
    'port'   => 6667,
    'nick'   => 'DeDubs',
    'user'   => 'Kushner', 
    'name'   => 'DeKushner',
    'pass'   => ''
=======
	'server' => 'irc.freenode.net',
	'port'   => 6667,
	'nick'   => 'Sharon',
	'user'   => 'Sharon',
	'name'   => 'Sharon',
	'pass'   => '',
	'startup_channel' => ''
>>>>>>> 5bac724d142474a9ab9a11e920ec27ad97d9cef5
);

$irc = new PublIRC($config);
$irc->run();