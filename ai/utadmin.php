<?php
$q = $_GET["q"];
?>
<html>
<head>
	<title>Admin</title>
	<link rel="stylesheet" href="stylea.css" />
</head>
<body>
	<?php 
	require_once "../config/konekcija.php";
	$domacin;
	$gost;
	$datum;
	$vreme;
	$status;
	$dgol;
	$ggol;
	$dsut;
	$gsut;
	$dso;
	$gso;
	$dkor;
	$gkor;
	$dof;
	$gof;
	$dfaul;
	$gfaul;
	$dzuti;
	$gzuti;
	$dcr;
	$gcr;
	$dpos;
	$gpos;
	$query = "SELECT * FROM utakmice WHERE ID = $q";
	$res = mysqli_query($link, $query);
	while($row = mysqli_fetch_assoc($res)){
		$domacin = $row["domacin"];
		$gost = $row["gost"];
		$datum = $row["datum"];
		$vreme = $row["vreme"];
		$status = $row["status"];
		$dgol = $row["dg"];
		$ggol = $row["gg"];
		$dsut = $row["ds"];
		$gsut = $row["gs"];
		$dso = $row["dso"];
		$gso = $row["gso"];
		$dkor = $row["dk"];
		$gkor = $row["gk"];
		$dof = $row["do"];
		$gof = $row["go"];
		$dfaul = $row["df"];
		$gfaul = $row["gf"];
		$dzuti = $row["dz"];
		$gzuti = $row["gz"];
		$dcr = $row["dc"];
		$gcr = $row["gc"];
		$dpos = $row["dp"];
		$gpos = $row["gp"];
		$time = new DateTime($vreme);
		$strtime = $time->format('H:i');
	}
	?>
	<div class="head">
		<div class="teams">
			<span><?php echo $domacin; ?></span><span>&nbsp - &nbsp</span><span><?php echo $gost; ?></span>
		</div>	
		<div class="dnt">
			<span>Date: <?php echo $datum; ?></span><span>Time: <?php echo $strtime; ?></span>
		</div>
	</div>
	<div id="main">
	<?php 
		if($status == 1){
			echo '<form action="../forms/start.php" method="post" class="start">';
			echo '<input type="hidden" name="id" value="' . $q . '">';
			echo '<input type="submit" value="Start">';
			echo '</form>';
		}else if($status == 2){
			echo '<div class="pos"><span>Possession<span></div>';
			echo '<form action="../forms/pos.php" method="post">';
			echo '<div class="stat"><span id="dp">' . $dpos . '</span><input type="range" min="0" max="100" value="50" name="dpos" id="myRange"><span id="gp">' . $gpos . '</span></div>';
			echo '<input type="hidden" name="id" value="' . $q . '">';
			echo '<div class="poss"><input type="submit" value="Change Possession"></div></form>';
			echo '<div class="stat"><div class="but"><button onclick="mdgol()">-</button><span id="dgol">' . $dgol . '</span><button onclick="pdgol()">+</button></div><span class="mid">Goals</span><div class="but"><button onclick="mggol()">-</button><span id="ggol">' . $ggol . '</span><button onclick="pggol()">+</button></div></div>';
			echo '<div class="stat"><div class="but"><button onclick="mdsut()">-</button><span id="dsut">' . $dsut . '</span><button onclick="pdsut()">+</button></div><span class="mid">Shots</span><div class="but"><button onclick="mgsut()">-</button><span id="gsut">' . $gsut . '</span><button onclick="pgsut()">+</button></div></div>';
			echo '<div class="stat"><div class="but"><button onclick="mdso()">-</button><span id="dso">' . $dso . '</span><button onclick="pdso()">+</button></div><span class="mid">Shots on target</span><div class="but"><button onclick="mgso()">-</button><span id="gso">' . $gso . '</span><button onclick="pgso()">+</button></div></div>';
			echo '<div class="stat"><div class="but"><button onclick="mdkor()">-</button><span id="dkor">' . $dkor . '</span><button onclick="pdkor()">+</button></div><span class="mid">Corners</span><div class="but"><button onclick="mgkor()">-</button><span id="gkor">' . $gkor . '</span><button onclick="pgkor()">+</button></div></div>';
			echo '<div class="stat"><div class="but"><button onclick="mdof()">-</button><span id="dof">' . $dof . '</span><button onclick="pdof()">+</button></div><span class="mid">Offsides</span><div class="but"><button onclick="mgof()">-</button><span id="gof">' . $gof . '</span><button onclick="pgof()">+</button></div></div>';
			echo '<div class="stat"><div class="but"><button onclick="mdfaul()">-</button><span id="dfaul">' . $dfaul . '</span><button onclick="pdfaul()">+</button></div><span class="mid">Fouls</span><div class="but"><button onclick="mgfaul()">-</button><span id="gfaul">' . $gfaul . '</span><button onclick="pgfaul()">+</button></div></div>';
			echo '<div class="stat"><div class="but"><button onclick="mdzuti()">-</button><span id="dzuti">' . $dzuti . '</span><button onclick="pdzuti()">+</button></div><span class="mid">Yellow cards</span><div class="but"><button onclick="mgzuti()">-</button><span id="gzuti">' . $gzuti . '</span><button onclick="pgzuti()">+</button></div></div>';
			echo '<div class="stat"><div class="but"><button onclick="mdcr()">-</button><span id="dcr">' . $dcr . '</span><button onclick="pdcr()">+</button></div><span class="mid">Red cards</span><div class="but"><button onclick="mgcr()">-</button><span id="gcr">' . $gcr . '</span><button onclick="pgcr()">+</button></div></div>';
			echo '<form action="../forms/end.php" method="post">';
			echo '<input type="hidden" name="id" value="' . $q . '">';
			echo '<div class="end"><input type="submit" value="End"></div>';
			echo '</form>';
		}
	?>
	</div>
	<script>
		var slider = document.getElementById("myRange");
		var output = document.getElementById("dp");
		var output2 = document.getElementById("gp");
		output.innerHTML = slider.value;
		output2.innerHTML = 100 - slider.value; 
		slider.oninput = function() {
			output.innerHTML = this.value;
			output2.innerHTML = 100 - this.value;
		}
		function pdgol(){
			var x = document.getElementById("dgol").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dgol").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=dg");
			xhttp.send();
		}
		function pdsut(){
			var x = document.getElementById("dsut").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dsut").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=ds");
			xhttp.send();
		}
		function pdso(){
			var x = document.getElementById("dso").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dso").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=dso");
			xhttp.send();
		}
		function pdkor(){
			var x = document.getElementById("dkor").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dkor").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=dk");
			xhttp.send();
		}
		function pdof(){
			var x = document.getElementById("dof").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dof").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=do");
			xhttp.send();
		}
		function pdfaul(){
			var x = document.getElementById("dfaul").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dfaul").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=df");
			xhttp.send();
		}
		function pdzuti(){
			var x = document.getElementById("dzuti").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dzuti").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=dz");
			xhttp.send();
		}
		function pdcr(){
			var x = document.getElementById("dcr").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dcr").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=dc");
			xhttp.send();
		}
		function pggol(){
			var x = document.getElementById("ggol").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("ggol").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=gg");
			xhttp.send();
		}
		function pgsut(){
			var x = document.getElementById("gsut").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("gsut").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=gs");
			xhttp.send();
		}
		function pgso(){
			var x = document.getElementById("gso").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("gso").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=gso");
			xhttp.send();
		}
		function pgkor(){
			var x = document.getElementById("gkor").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("gkor").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=gk");
			xhttp.send();
		}
		function pgof(){
			var x = document.getElementById("gof").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("gof").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=go");
			xhttp.send();
		}
		function pgfaul(){
			var x = document.getElementById("gfaul").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("gfaul").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=gf");
			xhttp.send();
		}
		function pgzuti(){
			var x = document.getElementById("gzuti").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("gzuti").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=gz");
			xhttp.send();
		}
		function pgcr(){
			var x = document.getElementById("gcr").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("gcr").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/update.php?val="+x+"&id="+<?php echo $q; ?>+"&col=gc");
			xhttp.send();
		}
		function mdgol(){
			var x = document.getElementById("dgol").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dgol").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=dg");
			xhttp.send();
		}
		function mdsut(){
			var x = document.getElementById("dsut").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dsut").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=ds");
			xhttp.send();
		}
		function mdso(){
			var x = document.getElementById("dso").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dso").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=dso");
			xhttp.send();
		}
		function mdkor(){
			var x = document.getElementById("dkor").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dkor").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=dk");
			xhttp.send();
		}
		function mdof(){
			var x = document.getElementById("dof").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dof").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=do");
			xhttp.send();
		}
		function mdfaul(){
			var x = document.getElementById("dfaul").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dfaul").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=df");
			xhttp.send();
		}
		function mdzuti(){
			var x = document.getElementById("dzuti").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dzuti").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=dz");
			xhttp.send();
		}
		function mdcr(){
			var x = document.getElementById("dcr").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("dcr").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=dc");
			xhttp.send();
		}
		function mggol(){
			var x = document.getElementById("ggol").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("ggol").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=gg");
			xhttp.send();
		}
		function mgsut(){
			var x = document.getElementById("gsut").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("gsut").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=gs");
			xhttp.send();
		}
		function mgso(){
			var x = document.getElementById("gso").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("gso").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=gso");
			xhttp.send();
		}
		function mgkor(){
			var x = document.getElementById("gkor").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("gkor").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=gk");
			xhttp.send();
		}
		function mgof(){
			var x = document.getElementById("gof").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("gof").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=go");
			xhttp.send();
		}
		function mgfaul(){
			var x = document.getElementById("gfaul").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("gfaul").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=gf");
			xhttp.send();
		}
		function mgzuti(){
			var x = document.getElementById("gzuti").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("gzuti").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=gz");
			xhttp.send();
		}
		function mgcr(){
			var x = document.getElementById("gcr").innerHTML;
			const xhttp = new XMLHttpRequest();
			xhttp.onload = function(){
				document.getElementById("gcr").innerHTML = this.responseText;
			}
			xhttp.open("GET", "/Diplomski/ajax/updatem.php?val="+x+"&id="+<?php echo $q; ?>+"&col=gc");
			xhttp.send();
		}
	</script>
</body>
</html>