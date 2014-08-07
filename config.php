<?php
	$host = 'localhost';
	$dbname = 'niobo_niobo';
	$charset = 'utf8';
	$user = 'niobo_niobo';
	$pass = '151@Nio0513';
	try {
		$db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset, $user, $pass);
	} catch(PDOException $ex) {
		echo "Aplica&ccedil;&atilde;o temporariamente offline";
	}
?>