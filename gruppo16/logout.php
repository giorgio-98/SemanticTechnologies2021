<?php
	/* attiva la sessione */
	session_start();
	/* sessione attiva, la distrugge */
	$sname=session_name();
	session_destroy();
	/* ed elimina il cookie corrispondente */
	if (isset($_COOKIE['buttonlogin'])) {
		setcookie($sname,'', time()-3600,'/');
	}
	header("Location:" . $_SERVER['HTTP_REFERER']);
	//echo "<p> Logout effettuato." </p>";
?>