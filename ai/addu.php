<html>
<head>
	<title>Add Fixture</title>
	<link rel="stylesheet" href="stylea.css"/>
</head>
<body>
	<div class="user"><a href="admin.php">Go back</a></div>
	<div class="add">
		<label for="lige">Choose league</label>
		<select name="lige" id="lige" onchange="chh();chg();">
			<?php 
				require_once "../config/konekcija.php";
				$query = "SELECT ID, liga FROM lige";
				$res = mysqli_query($link, $query);
				while($row = mysqli_fetch_assoc($res)){
					echo '<option value="' . $row["ID"] . '">' . $row["liga"] . '</option>';
				}
			?>
		</select>
		<form action="../forms/af.php" method="post">
			<label for="host">Host: </label>
			<select name="host" id="h">
				<?php 
					$query = "SELECT ime FROM klubovi WHERE liga = 1";
					$res = mysqli_query($link, $query);
					while($row = mysqli_fetch_assoc($res)){
						echo '<option value="' . $row["ime"] . '">' . $row["ime"] . '</option>';
					}
				?>
			</select>
			<label for="guest">Guest: </label>
			<select name="guest" id="g">
				<?php 
					$query = "SELECT ime FROM klubovi WHERE liga = 1";
					$res = mysqli_query($link, $query);
					while($row = mysqli_fetch_assoc($res)){
						echo '<option value="' . $row["ime"] . '">' . $row["ime"] . '</option>';
					}
				?>
			</select>
			<label for="d">Date: </label>
			<input type="date" name="d" value="<?php echo date('Y-m-d'); ?>">
			<label for="t">Time: </label>
			<input type="time" name="t">
			<input type="submit">
		</form>
	</div>
	<script>
		function chh(){
			var x = document.getElementById("lige").value;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("h").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/chh.php?q="+x);
			xhttp.send();
		}

		function chg(){
			var x = document.getElementById("lige").value;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("g").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/chh.php?q="+x);
			xhttp.send();
		}
	</script>
</body>
</html>