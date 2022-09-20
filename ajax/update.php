<?php
require_once "../config/konekcija.php";
$val = $_GET["val"];
$id = $_GET["id"];
$col = $_GET["col"];
$intv = intval($val);
$intv = $intv + 1;
$sql = "UPDATE utakmice SET " . $col . " = " . $intv . " WHERE ID = " . $id;
mysqli_query($link, $sql);
echo $intv;
?>