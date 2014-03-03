<?php

include_once 'publirc.php';

set_time_limit(0);
ini_set('display_errors', 'on');

include('config.php');

$irc = new PublIRC($config);
$irc->run();
