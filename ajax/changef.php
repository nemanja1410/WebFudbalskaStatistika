<?php
require_once "../config/konekcija.php";
$d = $_GET['q'];
$date = new DateTime($d);
$strdate = $date->format('Y-m-d');
$res = mysqli_query($link, "SELECT utakmice.domacin, klubovi.grb, utakmice.vreme, utakmice.ID, utakmice.status, utakmice.dg, utakmice.gg  
FROM utakmice INNER JOIN klubovi ON utakmice.domacin = klubovi.ime 
WHERE utakmice.datum = '" . $strdate . "' ORDER BY klubovi.liga ASC, utakmice.vreme ASC, utakmice.ID ASC");
while($row = mysqli_fetch_assoc($res)){
	$time = new DateTime($row["vreme"]);
	$strtime = $time->format('H:i');
	$strres;
	if($row["status"] == 1){
		$strres = "--";
	}else if($row["status"] == 2){
		$strtime = "LIVE";
		$strres = $row["dg"] . " -- " . $row["gg"];
	}else{
		$strtime = "FT";
		$strres = $row["dg"] . " -- " . $row["gg"];
	}
	echo '<div class="fix"><span class="stime">' . $strtime . '</span><a class="link" href="utakmica.php?id=' . $row["ID"] . '"><span class="left"><img src="/Diplomski/klubovi/' . $row["grb"] . '" 
	width="25px" height="25px" />' . $row["domacin"] . '</span><span class="mid"> ' . $strres;
	$res2 = mysqli_query($link, "SELECT utakmice.gost, klubovi.grb, lige.liga, lige.ID    
	FROM utakmice INNER JOIN klubovi ON utakmice.gost = klubovi.ime INNER JOIN lige ON klubovi.liga = lige.ID  
	WHERE utakmice.ID = '" . $row['ID'] . "'");
	while($row2 = mysqli_fetch_assoc($res2)){
		echo ' </span><span class="right">' . $row2["gost"] . '<img src="/Diplomski/klubovi/' . $row2["grb"] . '" width="25px" height="25px" /></span></a>
		<span class="sliga"><a href="liga.php?id=' . $row2["ID"] . '">' . $row2["liga"] . '</a></span></div>';
	}
}
?>