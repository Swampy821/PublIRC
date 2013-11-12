<?php

include_once 'publirc.php';

set_time_limit(0);
ini_set('display_errors', 'on');

$config = array(
	'server' => 'irc.freenode.net',
	'port'   => 6667,
	'nick'   => 'Sharon',
	'user'   => 'Sharon',
	'name'   => 'Sharon',
	'pass'   => '',
	'startup_channel' => ''
);

$irc = new PublIRC($config);
$irc->run();