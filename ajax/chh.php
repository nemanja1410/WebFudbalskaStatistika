<?php
$id = $_GET["q"];
require_once "../config/konekcija.php";
$query = "SELECT ime FROM klubovi WHERE liga = $id";
$res = mysqli_query($link, $query);
while($row = mysqli_fetch_assoc($res)){
	echo '<option value="' . $row["ime"] . '">' . $row["ime"] . '</option>';
}
?>