<?php
$korid = $_GET['x'];
$lid = $_GET['y'];
require_once "../config/konekcija.php";
$stmt = $link->prepare("INSERT INTO olige (korid, lid) VALUES (?, ?)");
$stmt->bind_param("ss", $korid, $lid);
$stmt->execute();
$stmt->close();
echo '<button onclick="remove(' . $korid . ', ' . $lid . ')">Remove from favorites</button>';
?>