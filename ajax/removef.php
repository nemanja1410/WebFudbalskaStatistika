<?php
$korid = $_GET['x'];
$klubid = $_GET['y'];
require_once "../config/konekcija.php";
$stmt = $link->prepare("DELETE FROM oklubovi WHERE korid = ? AND klubid = ?");
$stmt->bind_param("ss", $korid, $klubid);
$stmt->execute();
$stmt->close();
echo '<button onclick="add(' . $korid . ', ' . $klubid . ')">Add to favorites</button>';
?>