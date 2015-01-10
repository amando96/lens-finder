<?php
	$host = 'localhost';
	$dbname = 'user';
	$charset = 'utf8';
	$user = 'user';
	$pass = 'pass';
	try {
		$db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset, $user, $pass);
	} catch(PDOException $ex) {
		echo "Aplica&ccedil;&atilde;o temporariamente offline";
	}
?>
