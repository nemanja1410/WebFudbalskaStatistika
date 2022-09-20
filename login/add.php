<?php
session_start();
require_once "../config/konekcija.php";
$stmt = $link->prepare("INSERT INTO korisnici (username, password, email) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $pass, $email);

$username = $_POST["username"];
$pass = $_POST["password"];
$email = $_POST["email"];
$stmt->execute();

$stmt->close();

$id;
$query = "SELECT ID FROM korisnici WHERE username = '" . $_POST['username'] . "' AND email = '" . $_POST['email'] . "'";
$res = mysqli_query($link, $query);
while($row = mysqli_fetch_assoc($res)){
	$id = $row['ID'];
}

session_regenerate_id();
$_SESSION['loggedin'] = TRUE;
$_SESSION['name'] = $_POST['username'];
$_SESSION['id'] = $id;

header('Location: ../ui/index.php');
?>