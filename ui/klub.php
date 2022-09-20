<?php 
session_start();
?>
<html>
	<head>
		<title>Football results</title>
		<link rel="stylesheet" href="index.css" />
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
				<div class="mklub">
					<?php 
						$id = $_GET["id"];
						$res = mysqli_query($link, "SELECT klubovi.ime, klubovi.grb, klubovi.drzava, 
						lige.liga FROM klubovi INNER JOIN lige ON klubovi.liga = lige.ID 
						WHERE klubovi.id = " . $id);
						while($row = mysqli_fetch_assoc($res)){
							if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
								$id2 = $_SESSION['id'];
								$q = false;
								echo '<div id="afb">';
								$res2 = mysqli_query($link, "SELECT klubid FROM oklubovi WHERE korid = " . $id2);
								while($row2 = mysqli_fetch_assoc($res2)){
									if($row2['klubid'] == $id){
										$q = true;
									}
								}
								if($q){
									echo '<button onclick="remove(' . $id2 . ', ' . $id . ')">Remove from favorites</button>';
								}else{
									echo '<button onclick="add(' . $id2 . ', ' . $id . ')">Add to favorites</button>';
								}
								echo '</div>';
							}
							echo '<div class="k1"><img src="/Diplomski/klubovi/' . $row["grb"] . '" width="180px" 
							height="180px" ><span>' . $row["ime"] . '</span></div>
							<div class="k2"><span>Country: ' . $row["drzava"] . '</span>
							<span>League: ' . $row["liga"] . '</span></div>';
						}
					?>
					<div class="upf">
						<p>Fixtures:</p>
					</div>
					<div class="fres">
						<?php 
							$id = $_GET['id'];
							$res = mysqli_query($link, "SELECT ime FROM klubovi WHERE id = " . $id);
							while($row = mysqli_fetch_assoc($res)){
								$ime = $row["ime"];
							}
							$res = mysqli_query($link, "SELECT utakmice.domacin, klubovi.grb, utakmice.vreme, utakmice.ID, utakmice.status, utakmice.dg, utakmice.gg  
							FROM utakmice INNER JOIN klubovi ON utakmice.domacin = klubovi.ime 
							WHERE utakmice.domacin = '" . $ime . "' OR utakmice.gost = '" . $ime . "' ORDER BY utakmice.datum ASC");
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
								echo '<div class="fix"><span class="stime">' . $strtime . '</span><a class="link" href="utakmica.php?id=' . $row["ID"] . '">
								<span class="left"><img src="/Diplomski/klubovi/' . $row["grb"] . '" width="25px" height="25px" />' . $row["domacin"] . '</span><span class="mid"> ' . $strres;
								$res2 = mysqli_query($link, "SELECT utakmice.gost, utakmice.datum, klubovi.grb    
								FROM utakmice INNER JOIN klubovi ON utakmice.gost = klubovi.ime   
								WHERE utakmice.ID = " . $row['ID']);
								while($row2 = mysqli_fetch_assoc($res2)){
									echo ' </span><span class="right">' . $row2["gost"] . '<img src="/Diplomski/klubovi/' . $row2["grb"] . '" width="25px" height="25px" /></span>
									</a><span class="sliga">' . $row2["datum"] . '</span></div>';
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

			function add(x, y){
				const xhttp = new XMLHttpRequest();
				xhttp.onload = function(){
					document.getElementById("afb").innerHTML = this.responseText;
				}
				xhttp.open("GET", "/Diplomski/ajax/addf.php?x="+x+"&y="+y);
				xhttp.send();
			}

			function remove(x, y){
				const xhttp = new XMLHttpRequest();
				xhttp.onload = function(){
					document.getElementById("afb").innerHTML = this.responseText;
				}
				xhttp.open("GET", "/Diplomski/ajax/removef.php?x="+x+"&y="+y);
				xhttp.send();
			}
		</script>
	</body>
</html>