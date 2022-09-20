<?php
$id = $_GET["q"];
require_once "../config/konekcija.php";
$query = "DELETE FROM utakmice WHERE ID = $id";
if(mysqli_query($link, $query)){
	header("Location: admin.php");
}else{
	echo "Error deleting record: " . mysqli_error($conn);
}
?>