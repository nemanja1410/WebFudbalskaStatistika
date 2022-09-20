<?php 
$date = $_POST["d"];
$time = $_POST["t"];
$id = $_POST["id"];
require_once "../config/konekcija.php";
$query = "UPDATE utakmice SET datum = '$date', vreme = '$time' WHERE ID = $id";
if(mysqli_query($link, $query)){
	header("Location: ../ai/admin.php");
}else{
	echo "Error updating record: " . mysqli_error($link);
}

?>