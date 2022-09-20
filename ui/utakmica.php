<?php
session_start();
require_once "../config/konekcija.php";
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
				<div class="uh">
					<?php
						$id = $_GET["id"];
						$query = "SELECT utakmice.domacin, klubovi.grb, utakmice.dg, utakmice.gg, klubovi.id FROM utakmice INNER JOIN klubovi ON utakmice.domacin = klubovi.ime WHERE utakmice.ID = " . $id;
						$res = mysqli_query($link, $query);
						while($row = mysqli_fetch_assoc($res)){
							echo '<span class="uleft"><img src="/Diplomski/klubovi/' . $row["grb"] . '" width="100px" height="100px" /><a href="klub.php?id=' . $row["id"] . '"> ' . $row["domacin"] . '</a></span>
							<span class="umid">' . $row["dg"] . ' - ' . $row["gg"] . '</span>';
						}
						$query = "SELECT utakmice.gost, klubovi.grb, klubovi.id FROM utakmice INNER JOIN klubovi ON utakmice.gost = klubovi.ime WHERE utakmice.ID = " . $id;
						$res = mysqli_query($link, $query);
						while($row = mysqli_fetch_assoc($res)){
							echo '<span class="uright"><a href="klub.php?id=' . $row["id"] . '">' . $row["gost"] . ' </a><img src="/Diplomski/klubovi/' . $row["grb"] . '" width="100px" height="100px" />';
						}
					?>
				</div>
				<div class="dnt">
					<?php
						$query = "SELECT datum, vreme, status FROM utakmice WHERE ID = " . $id;
						$res = mysqli_query($link, $query);
						while($row = mysqli_fetch_assoc($res)){
							$time = new DateTime($row["vreme"]);
							$strtime = $time->format('H:i');
							if($row["status"] == 2){
								$strtime = "LIVE";
							}else if($row["status"] == 3){
								$strtime = "Full Time";
							}
							echo '<span>' . $row["datum"] . '</span><span>' . $strtime . '</span>';
						}
					?>
				</div>
				<?php
				$query = "SELECT dg, gg, ds, gs, dso, gso, dk, gk, do, go, df, gf, dz, gz, dc, gc, dp, gp FROM utakmice WHERE ID = " . $id;
				$res = mysqli_query($link, $query);
				while($row = mysqli_fetch_assoc($res)){
				?>
				<div class="stats">
				<?php
					echo '<span>' . $row["dp"] . '</span><span class="sname">Possession</span><span>' . $row["gp"] . '</span>';
				?>
				</div>
				<div class="stats">
				<?php
					echo '<span>' . $row["dg"] . '</span><span class="sname">Goals</span><span>' . $row["gg"] . '</span>';
				?>
				</div>
				<div class="stats">
				<?php
					echo '<span>' . $row["ds"] . '</span><span class="sname">Shots</span><span>' . $row["gs"] . '</span>';
				?>
				</div>
				<div class="stats">
				<?php
					echo '<span>' . $row["dso"] . '</span><span class="sname">Shots on target</span><span>' . $row["gso"] . '</span>';
				?>
				</div>
				<div class="stats">
				<?php
					echo '<span>' . $row["dk"] . '</span><span class="sname">Corners</span><span>' . $row["gk"] . '</span>';
				?>
				</div>
				<div class="stats">
				<?php
					echo '<span>' . $row["do"] . '</span><span class="sname">Offsides</span><span>' . $row["go"] . '</span>';
				?>
				</div>
				<div class="stats">
				<?php
					echo '<span>' . $row["df"] . '</span><span class="sname">Fouls</span><span>' . $row["gf"] . '</span>';
				?>
				</div>
				<div class="stats">
				<?php
					echo '<span>' . $row["dz"] . '</span><span class="sname">Yellow cards</span><span>' . $row["gz"] . '</span>';
				?>
				</div>
				<div class="stats">
				<?php
					echo '<span>' . $row["dc"] . '</span><span class="sname">Red cards</span><span>' . $row["gc"] . '</span>';
				?>
				</div>
				<?php
					}
				?>
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
	</script>
</body>
</html>