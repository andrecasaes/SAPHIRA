<?php
if (isset($_SESSION['particulas'])) {
	if ($_SESSION['particulas']) {
	?>
	    <script type="text/javascript" src="Particulas/particles.js"></script>
	    <script type="text/javascript" src="Particulas/app.js"></script>
	<?php
	}
}else{
	//Para aparecer no index
	?>
	    <script type="text/javascript" src="Particulas/particles.js"></script>
	    <script type="text/javascript" src="Particulas/app.js"></script>
	<?php
}
?>