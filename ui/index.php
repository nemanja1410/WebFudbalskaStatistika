<?php 
session_start();
?>
<html>
	<head>
		<title>Football results</title>
		<link rel="stylesheet" href="index.css" type="text/css" />
	</head>
	<body>
		<div class="all">
			<div class="header">
				<a href="index.php"><h1>FOOTBALL RESULTS</h1></a>
				<?php 
				if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
					echo '<div class="log">
							<a href="/Diplomski/login/logout.php">Logout</a>
						</div>';
				}else{
					echo '<div class="log">
							<a href="/Diplomski/login/login.html">Login</a>
							<a href="/Diplomski/login/registration.html">Register</a>
						</div>';
				}
				?>
			</div>
			<div class="body">
				<div class="side">
					<?php
						require_once "../config/konekcija.php";
						$res = mysqli_query($link, "SELECT drzava, zastava FROM drzave WHERE liga = 1 ORDER BY drzava ASC");
						while($row = mysqli_fetch_assoc($res)){
							echo '<button class="dropbtn"><img src="/Diplomski/drzave/' . $row['zastava'] . '" width="30px" height="20px" /> &nbsp&nbsp' . $row['drzava'] . '</button>';
							$res2 = mysqli_query($link, "SELECT ID, liga FROM lige WHERE drzava = '" . $row['drzava'] . "'");
							echo '<div class="drop">';
							while($row2 = mysqli_fetch_assoc($res2)){
								$id = $row2['ID'];
								$liga = $row2['liga'];
								echo '
									<form method="get" action="liga.php">
										<input type="hidden" name="id" value="' . $id . '">
										<input type="submit" class="submit" value="' . $liga . '">
									</form>';
							}
							echo '</div>';
						}
					?>
				</div>
				<div class="main">
					<?php
					if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
						$idk = $_SESSION['id'];
						$query = "SELECT admin FROM korisnici WHERE ID = " . $idk;
						$admin;
						$r = mysqli_query($link, $query);
						while($ro = mysqli_fetch_assoc($r)){
							$admin = $ro['admin'];
						}
						if($admin == 1){
							echo '<div class="admin"><a href="/Diplomski/ai/admin.php">Admin panel</a></div>';
						}
						$res = mysqli_query($link, "SELECT klubid FROM oklubovi WHERE korid = " . $idk);
						while($row = mysqli_fetch_assoc($res)){
							$res2 = mysqli_query($link, "SELECT ime, grb, id FROM klubovi WHERE id = " . $row['klubid']);
							$ime;
							while($row2 = mysqli_fetch_assoc($res2)){
								echo '<a class="title" href="klub.php?id=' . $row2['id'] . '"><img 
								src="/Diplomski/klubovi/' . $row2['grb'] . '" width="30px" height="30px"/>
								<h1>' . $row2['ime'] . '</h1></a>';
								$ime = $row2['ime'];
							}
							echo '<div class="fres">';
							$res2 = mysqli_query($link, "SELECT * FROM (SELECT utakmice.domacin, klubovi.grb, utakmice.ID, utakmice.dg, utakmice.gg, utakmice.datum    
							FROM utakmice INNER JOIN klubovi ON utakmice.domacin = klubovi.ime 
							WHERE (utakmice.domacin = '" . $ime . "' OR utakmice.gost = '" . $ime . "') AND (utakmice.status = 3) ORDER BY utakmice.datum DESC LIMIT 5) AS sub ORDER BY sub.datum ASC");
							while($row2 = mysqli_fetch_assoc($res2)){
								echo '<div class="fix"><span class="stime">FT</span><a class="link" href="utakmica.php?id=' . $row2["ID"] . '">
								<span class="left"><img src="/Diplomski/klubovi/' . $row2["grb"] . '" width="25px" height="25px" /><span>' . $row2["domacin"] . '</span></span><span class="mid"> ' . $row2["dg"] . " -- " . $row2["gg"];
								$res3 = mysqli_query($link, "SELECT utakmice.gost, klubovi.grb, utakmice.datum    
								FROM utakmice INNER JOIN klubovi ON utakmice.gost = klubovi.ime WHERE utakmice.ID = " . $row2['ID']);
								while($row3 = mysqli_fetch_assoc($res3)){
									echo ' </span><span class="right">' . $row3["gost"] . '<img src="/Diplomski/klubovi/' . $row3["grb"] . '" width="25px" height="25px" /></span>
									</a><span class="sliga">' . $row3["datum"] . '</span></div>';
								}
							}
							$res2 = mysqli_query($link, "SELECT utakmice.domacin, klubovi.grb, utakmice.vreme, utakmice.ID, utakmice.dg, utakmice.gg, utakmice.status   
							FROM utakmice INNER JOIN klubovi ON utakmice.domacin = klubovi.ime 
							WHERE (utakmice.domacin = '" . $ime . "' OR utakmice.gost = '" . $ime . "') AND (utakmice.status = 1 OR utakmice.status = 2) ORDER BY utakmice.datum ASC LIMIT 5");
							while($row2 = mysqli_fetch_assoc($res2)){
								$time = new DateTime($row2["vreme"]);
								$strtime = $time->format('H:i');
								if($row2["status"] == 2){
									$strtime = "LIVE";
								}
								echo '<div class="fix"><span class="stime">' . $strtime . '</span><a class="link" href="utakmica.php?id=' . $row2["ID"] . '">
								<span class="left"><img src="/Diplomski/klubovi/' . $row2["grb"] . '" width="25px" height="25px" />' . $row2["domacin"] . '</span><span class="mid"> ';
								if($row2["status"] == 2){
									echo $row2["dg"] . " -- " . $row2["gg"];
								}else{
									echo '--';
								}
								$res3 = mysqli_query($link, "SELECT utakmice.gost, klubovi.grb, utakmice.datum    
								FROM utakmice INNER JOIN klubovi ON utakmice.gost = klubovi.ime WHERE utakmice.ID = " . $row2['ID']);
								while($row3 = mysqli_fetch_assoc($res3)){
									echo ' </span><span class="right">' . $row3["gost"] . '<img src="/Diplomski/klubovi/' . $row3["grb"] . '" width="25px" height="25px" /></span>
									</a><span class="sliga">' . $row3["datum"] . '</span></div>';
								}
							}
							echo '</div>';
						}
						$res = mysqli_query($link, "SELECT lid FROM olige WHERE korid = " . $idk);
						while($row = mysqli_fetch_assoc($res)){
							$res2 = mysqli_query($link, "SELECT liga, ID FROM lige WHERE ID = " . $row['lid']);
							while($row2 = mysqli_fetch_assoc($res2)){
								echo '<a class="title" href="liga.php?id=' . $row2['ID'] . '">
								<h1>' . $row2['liga'] . '</h1></a>';
							}
							echo '<div class="fres">';
							$res2 = mysqli_query($link, "SELECT * FROM (SELECT utakmice.domacin, klubovi.grb, utakmice.vreme, utakmice.ID, utakmice.dg, utakmice.gg, utakmice.datum 
							FROM utakmice INNER JOIN klubovi ON utakmice.domacin = klubovi.ime 
							WHERE klubovi.liga = " . $row['lid'] . " AND utakmice.status = 3 ORDER BY utakmice.datum DESC, utakmice.vreme DESC, utakmice.ID DESC LIMIT 10) AS sub ORDER BY sub.datum ASC, sub.vreme ASC, sub.ID ASC");
							while($row2 = mysqli_fetch_assoc($res2)){
								echo '<div class="fix"><span class="stime">FT</span><a class="link" href="utakmica.php?id=' . $row2["ID"] . '">
								<span class="left"><img src="/Diplomski/klubovi/' . $row2["grb"] . '" width="25px" height="25px" />' . $row2["domacin"] . '</span><span class="mid"> ' . $row2["dg"] . ' -- ' . $row2["gg"];
								$res3 = mysqli_query($link, "SELECT utakmice.gost, klubovi.grb, utakmice.datum    
								FROM utakmice INNER JOIN klubovi ON utakmice.gost = klubovi.ime   
								WHERE utakmice.ID = " . $row2['ID']);
								while($row3 = mysqli_fetch_assoc($res3)){
									echo ' </span><span class="right">' . $row3["gost"] . '<img src="/Diplomski/klubovi/' . $row3["grb"] . '" width="25px" height="25px" /></span>
									</a><span class="sliga">' . $row3["datum"] . '</span></div>';
								}
							}
							$res2 = mysqli_query($link, "SELECT utakmice.domacin, klubovi.grb, utakmice.vreme, utakmice.ID, utakmice.status, utakmice.dg, utakmice.gg 
							FROM utakmice INNER JOIN klubovi ON utakmice.domacin = klubovi.ime 
							WHERE klubovi.liga = " . $row['lid'] . " AND (utakmice.status = 1 OR utakmice.status = 2) ORDER BY utakmice.datum ASC, utakmice.vreme ASC, utakmice.ID ASC LIMIT 10");
							while($row2 = mysqli_fetch_assoc($res2)){
								$time = new DateTime($row2["vreme"]);
								$strtime = $time->format('H:i');
								if($row2["status"] == 2){
									$strtime = "LIVE";
								}
								echo '<div class="fix"><span class="stime">' . $strtime . '</span><a class="link" href="utakmica.php?id=' . $row2["ID"] . '">
								<span class="left"><img src="/Diplomski/klubovi/' . $row2["grb"] . '" width="25px" height="25px" />' . $row2["domacin"] . '</span><span class="mid"> ';
								if($row2["status"] == 2){
									echo $row2["dg"] . ' -- ' . $row2["gg"];
								}else{
									echo '--';
								}
								$res3 = mysqli_query($link, "SELECT utakmice.gost, klubovi.grb, utakmice.datum    
								FROM utakmice INNER JOIN klubovi ON utakmice.gost = klubovi.ime   
								WHERE utakmice.ID = " . $row2['ID']);
								while($row3 = mysqli_fetch_assoc($res3)){
									echo ' </span><span class="right">' . $row3["gost"] . '<img src="/Diplomski/klubovi/' . $row3["grb"] . '" width="25px" height="25px" /></span>
									</a><span class="sliga">' . $row3["datum"] . '</span></div>';
								}
							}
							
							echo '</div>';
						}
					}
					?>
					<div class="dat">
						<label for="d">Search fixtures by date: </label>
						<input type="date" value="<?php echo date('Y-m-d'); ?>" name="d" id="mydate">
						<button onclick="changeF()">GO</button>
					</div>
					<div id="res">
						<?php 
							$date = new DateTime(date('Y-m-d'));
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
								WHERE utakmice.ID = " . $row['ID']);
								while($row2 = mysqli_fetch_assoc($res2)){
									echo ' </span><span class="right">' . $row2["gost"] . '<img src="/Diplomski/klubovi/' . $row2["grb"] . '" width="25px" height="25px" /></span></a>
									<span class="sliga"><a href="liga.php?id=' . $row2["ID"] . '">' . $row2["liga"] . '</a></span></div>';
								}
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<script>
			var dropdown = document.getElementsByClassName("dropbtn");
			var i;

			for (i = 0; i < dropdown.length; i++) {
			  dropdown[i].addEventListener("click", function() {
				var dropdownContent = this.nextElementSibling;
				if (dropdownContent.style.display === "flex") {
				  dropdownContent.style.display = "none";
				} else {
				  dropdownContent.style.display = "flex";
				}
			  });
			}
			function changeF(){
				var x = document.getElementById("mydate").value;
				const xhttp = new XMLHttpRequest();
				xhttp.onload = function(){
					document.getElementById("res").innerHTML = this.responseText;
				}
				xhttp.open("GET", "/Diplomski/ajax/changef.php?q="+x);
				xhttp.send();
			}
		</script>
	</body>
</html>