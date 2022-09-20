<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "rezultati";
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if(mysqli_connect_errno()){
	die("Nije uspelo povezivanje na bazu podataka: " . mysqli_connect_error());
}else if(!mysqli_set_charset($link, "utf8")){
	printf("Greska u podesavanju utf8: %s\n", mysqli_error($link));
	exit();
}
?>