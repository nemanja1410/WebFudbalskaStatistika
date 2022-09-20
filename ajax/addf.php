<?php
$korid = $_GET['x'];
$klubid = $_GET['y'];
require_once "../config/konekcija.php";
$stmt = $link->prepare("INSERT INTO oklubovi (korid, klubid) VALUES (?, ?)");
$stmt->bind_param("ss", $korid, $klubid);
$stmt->execute();
$stmt->close();
echo '<button onclick="remove(' . $korid . ', ' . $klubid . ')">Remove from favorites</button>';
?>