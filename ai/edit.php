<html>
<head>
	<title>Edit</title>
	<link rel="stylesheet" href="stylea.css"/>
</head>
<body>
	<div class="edit">
		<?php 
			require_once "../config/konekcija.php";
			$q = $_GET["q"];
			$query = "SELECT domacin, gost, datum, vreme FROM utakmice WHERE ID = $q";
			$res = mysqli_query($link, $query);
			while($row = mysqli_fetch_assoc($res)){
				echo '<p>' . $row["domacin"] . ' -- ' . $row["gost"] . '</p>';
				$date = new DateTime($row["datum"]);
				$strdate = $date->format('Y-m-d');
				$time = new DateTime($row["vreme"]);
				$strtime = $time->format('H:i');
			}
		?>
		<form action="/Diplomski/forms/editu.php" method="post">
			<input type="hidden" id="id" name="id" value="<?php echo $q; ?>">
			<label for="d">Date: </label>
			<input type="date" value="<?php echo $strdate; ?>" name="d" id="mydate"></br>
			<label for="appt">Time:</label>
			<input type="time" id="t" name="t" value="<?php echo $strtime ?>"></br>
			<input type="submit">
		</form>
	</div>
</body>
</html>