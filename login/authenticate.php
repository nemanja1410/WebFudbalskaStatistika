<?php
session_start();
require_once "../config/konekcija.php";
if(!isset($_POST['username'], $_POST['password'])){
	exit('Please fill both username and password fields!');
}
if($stmt = $link->prepare('SELECT ID, password FROM korisnici WHERE username = ?')){
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	if($stmt->num_rows > 0){
		$stmt->bind_result($id, $password);
		$stmt->fetch();
		if ($_POST['password'] === $password){
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_POST['username'];
			$_SESSION['id'] = $id;
			header('Location: ../ui/index.php');
		}else{
			echo 'Incorrect username and/or password!';
		}
	}else{
		echo 'Incorrect username and/or password!';
	}
	$stmt->close();
}