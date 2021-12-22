<?php
	require "logindb.php";
	if (isset($_GET['voto']) && isset($_GET['id'])) {
		$voto = $_GET['voto'];
		$id = $_GET['id'];

		
		$db = pg_connect($connection_string) or die('Impossibile connettersi al database: '.pg_last_error());


		$insquery = "INSERT INTO reazioni(reaction, idvideogame) VALUES ('$voto', '$id')";
		$ins = pg_query($db, $insquery) or die(pg_last_error());
		if (!$ins){
			echo "ERRORE QUERY: " . pg_last_error($db);
		}
		header("Location: " . $_SERVER['HTTP_REFERER']);
		pg_close();
	}
	else{
		header("Location: " . $_SERVER['HTTP_REFERER']);
	}


?>