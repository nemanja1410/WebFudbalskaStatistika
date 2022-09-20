<?php
require_once "../config/konekcija.php";
$dpos = $_POST["dpos"];
$gpos = 100 - $dpos;
$id = $_POST["id"];
$query = "UPDATE utakmice SET dp = " . $dpos . ", gp = " . $gpos . " WHERE ID = " . $id;
mysqli_query($link, $query);
header("Location: ../ai/utadmin.php?q=" . $id);
?>