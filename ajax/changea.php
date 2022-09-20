<?php
require_once "../config/konekcija.php";
$d = $_GET['q'];
$date = new DateTime($d);
$strdate = $date->format('Y-m-d');
?>
<table>
	<tr>
		<th>Date</th><th>Time</th><th>Fixture</th><th>Options</th>
	</tr>
	<?php
		$query = "SELECT ID, domacin, gost, datum, vreme FROM utakmice WHERE datum = '$strdate' ORDER BY vreme ASC";
		$res = mysqli_query($link, $query);
		while($row = mysqli_fetch_assoc($res)){
			echo '<tr><td>' . $row["datum"] . '</td>
					<td>' . $row["vreme"] . '</td>
					<td><a href="utadmin.php?q=' . $row["ID"] . '">' . $row["domacin"] . ' -- ' . $row["gost"] . '</a></td>
					<td><a href="edit.php?q=' . $row["ID"] . '">Edit</a><a href="delete.php?q=' . $row["ID"] . '">Delete</a></td></tr>';
		}
	?>
</table>