<?php

include_once 'publirc.php';

set_time_limit(0);
ini_set('display_errors', 'on');

$config = array(
	'server' => 'irc.freenode.net',
	'port'   => 6667,
	'nick'   => 'TripleS',
	'user'   => 'TripleS',
	'name'   => 'Core Dun Did PHP',
	'pass'   => 'sky1215'
);

$irc = new PublIRC($config);
$irc->run();