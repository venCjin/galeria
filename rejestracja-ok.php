<?php
	echo '<p class="success">Witaj <b>' . $_SESSION["userData"]["login"] . '</b>! Zostałeś poprawnie zarejestrowany.<br>
			<a class="button" href="index.php?strona=galeria">
			<i class="fa fa-home" style="color: rgba(255,255,255,0.5);"></i>
			Przejdź do galerii</a></p>';
?>