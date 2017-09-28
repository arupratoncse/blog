<?php
$hostname='localhost';
$username='root';
$password='';


try{
	$db = new PDO("mysql:host=$hostname;dbname=blog",$username,$password);

	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
	echo "Connection error: ".$e->getMessage();
}
?>