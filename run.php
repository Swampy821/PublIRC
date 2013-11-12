<?php

include_once 'publirc.php';

set_time_limit(0);
ini_set('display_errors', 'on');

$config = array(
    'server' => 'irc.phpfreaks.com',
    'port'   => 6667,
    'nick'   => 'DeDubs',
    'user'   => 'Kushner', 
    'name'   => 'DeDubsKushner',
    'pass'   => ''
);

$irc = new PublIRC($config);
$irc->run();