<?php
require_once "../config/konekcija.php";
$id = $_POST["id"];
$query = "UPDATE utakmice SET status = 2 WHERE ID = " . $id;
mysqli_query($link, $query);
header("Location: ../ai/utadmin.php?q=" . $id);
?>