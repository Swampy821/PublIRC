<?php

$db = new PDO("sqlite:fieras.s3db");
//$db->exec("CREATE TABLE Money(ID INTEGER PRIMARY KEY,Moneyz TEXT UNIQUE,Moneyy TEXT)");
$sql = 'INSERT INTO Money (`Moneyz`,`Moneyy`) VALUES ("TEST","TEST")';
$db->exec($sql);
$sql = 'SELECT * FROM Money';
$results = $db->query($sql);
foreach($results as $rs)
{
	var_dump($rs);
}
?>