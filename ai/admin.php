<html>
<head>
	<title>Admin</title>
	<link rel="stylesheet" href="stylea.css"/>
</head>
<body>
	<div class="user"><a href="/Diplomski/ui/index.php">User panel</a></div>
	<div class="dat">
		<label for="d">Date: </label>
		<input type="date" value="<?php echo date('Y-m-d'); ?>" name="d" id="mydate">
		<button onclick="changea()">Search</button>
		<a href="addu.php">Add a fixture</a>
	</div>
	<div id="main">
		<table>
			<tr>
				<th>Date</th><th>Time</th><th>Fixture</th><th>Options</th>
			</tr>
			<?php 
				require_once "../config/konekcija.php";
				$query = "SELECT ID, domacin, gost, datum, vreme FROM utakmice WHERE status = 1 OR status = 2 ORDER BY datum ASC, vreme ASC LIMIT 40";
				$res = mysqli_query($link, $query);
				while($row = mysqli_fetch_assoc($res)){
					echo '<tr><td>' . $row["datum"] . '</td>
							<td>' . $row["vreme"] . '</td>
							<td><a href="utadmin.php?q=' . $row["ID"] . '">' . $row["domacin"] . ' -- ' . $row["gost"] . '</a></td>
							<td><a href="edit.php?q=' . $row["ID"] . '">Edit</a><a href="delete.php?q=' . $row["ID"] . '">Delete</a></td></tr>';
				}
			?>
		</table>   
	</div>
	<script>
		function changea(){
				var x = document.getElementById("mydate").value;
				const xhttp = new XMLHttpRequest();
				xhttp.onload = function(){
					document.getElementById("main").innerHTML = this.responseText;
				}
				xhttp.open("GET", "/Diplomski/ajax/changea.php?q="+x);
				xhttp.send();
			}
	</script>

</body>
</html>