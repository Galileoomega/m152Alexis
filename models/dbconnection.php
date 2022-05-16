<?php

function connectDB(){
	$dbServer = "127.0.0.1";
	$dbName = "m152";
	$dbUser = "m152admin";
	$dbPwd = "m152admin";
	
	static $bdd = null;
	
	if ($bdd === null) {
		$bdd = new PDO("mysql:host=$dbServer;dbname=$dbName;charset=utf8", $dbUser, $dbPwd);
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}
	return $bdd;
}