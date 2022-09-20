<?php
$korid = $_GET['x'];
$lid = $_GET['y'];
require_once "../config/konekcija.php";
$stmt = $link->prepare("DELETE FROM olige WHERE korid = ? AND lid = ?");
$stmt->bind_param("ss", $korid, $lid);
$stmt->execute();
$stmt->close();
echo '<button onclick="add(' . $korid . ', ' . $lid . ')">Add to favorites</button>';
?>