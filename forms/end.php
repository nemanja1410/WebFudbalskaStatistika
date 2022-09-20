<?php
require_once "../config/konekcija.php";
$id = $_POST["id"];
$query = "UPDATE utakmice SET status = 3 WHERE ID = " . $id;
mysqli_query($link, $query);
$digrane;
$dpobedjene;
$dneresene;
$dizgubljene;
$ddg;
$dpg;
$dgr;
$dpoeni;
$did;
$gid;
$gigrane;
$gpobedjene;
$gneresene;
$gizgubljene;
$gdg;
$gpg;
$ggr;
$gpoeni;
$query = "SELECT klubovi.id FROM klubovi INNER JOIN utakmice ON klubovi.ime = utakmice.domacin WHERE utakmice.ID = " .$id;
$res = mysqli_query($link, $query);
while($row = mysqli_fetch_assoc($res)){
	$did = $row["id"];
}
$query = "SELECT klubovi.id FROM klubovi INNER JOIN utakmice ON klubovi.ime = utakmice.gost WHERE utakmice.ID = " .$id;
$res = mysqli_query($link, $query);
while($row = mysqli_fetch_assoc($res)){
	$gid = $row["id"];
}
$query = "SELECT igraneu, pobedjene, neresene, izgubljene, dg, pg, gr, poeni FROM klubovi WHERE id = " . $did;
$res = mysqli_query($link, $query);
while($row = mysqli_fetch_assoc($res)){
	$digrane = $row["igraneu"];
	$dpobedjene = $row["pobedjene"];
	$dneresene = $row["neresene"];
	$dizgubljene = $row["izgubljene"];
	$ddg = $row["dg"];
	$dpg = $row["pg"];
	$dgr = $row["gr"];
	$dpoeni = $row["poeni"];
}
$query = "SELECT igraneu, pobedjene, neresene, izgubljene, dg, pg, gr, poeni FROM klubovi WHERE id = " . $gid;
$res = mysqli_query($link, $query);
while($row = mysqli_fetch_assoc($res)){
	$gigrane = $row["igraneu"];
	$gpobedjene = $row["pobedjene"];
	$gneresene = $row["neresene"];
	$gizgubljene = $row["izgubljene"];
	$gdg = $row["dg"];
	$gpg = $row["pg"];
	$ggr = $row["gr"];
	$gpoeni = $row["poeni"];
}
$digrane += 1;
$gigrane += 1;
$query = "SELECT dg, gg FROM utakmice WHERE ID = " . $id;
$res = mysqli_query($link, $query);
while($row = mysqli_fetch_assoc($res)){
	if($row["dg"] > $row["gg"]){
		$dpobedjene += 1;
		$gizgubljene += 1;
		$ddg += $row["dg"];
		$gdg += $row["gg"];
		$dpg += $row["gg"];
		$gpg += $row["dg"];
		$dgr = $ddg - $dpg;
		$ggr = $gdg - $gpg;
		$dpoeni += 3;
	}else if($row["dg"] < $row["gg"]){
		$gpobedjene += 1;
		$dizgubljene += 1;
		$ddg += $row["dg"];
		$gdg += $row["gg"];
		$dpg += $row["gg"];
		$gpg += $row["dg"];
		$dgr = $ddg - $dpg;
		$ggr = $gdg - $gpg;
		$gpoeni += 3;
	}else{
		$dneresene += 1;
		$gneresene += 1;
		$ddg += $row["dg"];
		$gdg += $row["gg"];
		$dpg += $row["gg"];
		$gpg += $row["dg"];
		$dgr = $ddg - $dpg;
		$ggr = $gdg - $gpg;
		$dpoeni += 1;
		$gpoeni += 1;
	}
}
$query = "UPDATE klubovi SET igraneu = " . $digrane . ", pobedjene = " . $dpobedjene . ", neresene = " . $dneresene . ", izgubljene = " . $dizgubljene . ", dg = " . $ddg . ", pg = " . $dpg . ", gr = " . $dgr . ", poeni = " . $dpoeni . " 
WHERE id = " . $did;
mysqli_query($link, $query);
$query = "UPDATE klubovi SET igraneu = " . $gigrane . ", pobedjene = " . $gpobedjene . ", neresene = " . $gneresene . ", izgubljene = " . $gizgubljene . ", dg = " . $gdg . ", pg = " . $gpg . ", gr = " . $ggr . ", poeni = " . $gpoeni . " 
WHERE id = " . $gid;
mysqli_query($link, $query);
header("Location: ../ai/admin.php");
?>