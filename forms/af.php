<?php
require_once "../config/konekcija.php";
$host = $_POST["host"];
$guest = $_POST["guest"];
$date = $_POST["d"];
$time = $_POST["t"];
if($host == $guest){
	echo 'You cant select two same clubs';
}else if($time == ""){
	echo 'Fill in timestamp';
}else{
	$stmt = $link->prepare("INSERT INTO utakmice (domacin, gost, datum, vreme) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("ssss", $host, $guest, $date, $time);
	$stmt->execute();
	$stmt->close();
	header('Location: ../ai/addu.php');
}
?>