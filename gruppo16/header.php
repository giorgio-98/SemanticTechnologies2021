<div class="header">
	<a href="homepage.php"><img title="Ritorna alla Home" src="logo.png"  alt="Logo"></a>
</div>

<div class="topnav">
	<ul>
		<li><a href="homepage.php">Home</a></li>
		<li><a href="contact.php">Assistenza</a></li>
		
		<?php 
		if(empty($_SESSION["uname"])){
		?>
			<li><a href="registrazione.php">Registrazione</a></li>
			<li id="loginbutton" onclick="document.getElementById('idmodal').style.display='block'">Login</li>
		<?php
	    }
	    else{
	    	$user = $_SESSION["uname"];
	    ?>
	    	<li id="logout"><a href="logout.php" onclick="return confirm('Vuoi eseguire il logout?');">Logout</a></li>
	    	<li id="messaggioBenvenuto"><?php echo $user ?></li>
	    <?php	
	    }
		?>

    </ul>
</div>


  


<div id="idmodal" class="modal">
	
	<form class="modal-content animate" action="logincheck.php" method="POST" name="formlogin">
		
	    <div class="imgcontainer">
		    <span class="close" onclick="document.getElementById('idmodal').style.display='none'" title="Chiudi Login">&times;</span>
		    <img src="nigg.png" alt="Nigg Games" class="avatar">
	    </div>

	    <div class="container-login">
	    	<!--Controllo campo vuoto e campo non valido tramite GET -->
	    	<?php 
			    if(@$_GET['CampoVuoto']==true) {  /*la chiocciola elimina qualsiasi errore e consente a qualsiasi operazione eseguita in seguito di fallire silenziosamente, anziché mostrare i messaggi automatici di errore*/
				?>
				    <div class="alertLogin"><?php echo $_GET['CampoVuoto'] ?></div> <!--Stampa il valore di CampoVuoto passato tramite GET -->
				    <script> document.getElementById("idmodal").style.display='block'; </script> <!-- serve per mostrare di nuovo il blocco di login -->                               
				<?php
				    }
				?>
				 
				<?php 
				    if(@$_GET['NonValido']==true) { /*la chiocciola elimina qualsiasi errore e consente a qualsiasi operazione eseguita in seguito di fallire silenziosamente, anziché mostrare i messaggi automatici di errore*/
				?>
				    <div class="alertLogin"><?php echo $_GET['NonValido'] ?></div> <!--Stampa il valore di NonValido passato tramite GET -->
				    <script> document.getElementById("idmodal").style.display='block'; </script> <!-- serve per mostrare di nuovo il blocco di login -->                              
				<?php
				    }
				?>

	        <label for="uname">Username</label>
	        <input type="text" placeholder="Inserisci Username" name="uname" id="uname" required>

	        <label for="psw">Password</label>
	        <input type="password" placeholder="Inserisci Password" name="psw" id="psw" required>

	        <button class="buttonlogin" type="submit" name="buttonlogin">Login</button>
	    </div>

	    <div id="registrati">Non sei ancora registrato? <a href="registrazione.php">Registrati!</a></div>

    </form>
		  
</div>