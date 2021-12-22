<?php session_start(); ?>
<?php
    if(!empty($_POST)){
        if(empty($_POST["nome"])){
            //nome non inserito
            $nome = "";
        }
        else{
            $nome = $_POST["nome"];
        }
        if(empty($_POST["cognome"])){
            //nome non inserito
            $cognome = "";
        }
        else{
            $cognome = $_POST["cognome"];
        }
        if(empty($_POST["email"])){
            //email non inserito
            $email = "";
        }
        else{
            $email = $_POST["email"];
        }
        if(empty($_POST["username"])){
            //username non inserito
            $username = "";
        }
        else{
            $username = $_POST["username"];
        }
        if(empty($_POST["password"])){
            //password non inserito
            $password = "";
        }
        else{
            $password = $_POST["password"];
        }
		$sesso = "off";
        if(empty($_POST["privacy"])){
            $privacy = "OFF";
        }
        else{
            $privacy = $_POST["privacy"];
        }
    }
?>
<!DOCTYPE html>
<html lang="it">
	<head>
		<title>Registrazione | NIGG Games</title>
		<meta charset="utf-8">
		<meta name="author" content="Gruppo 16">
		<meta name="keywords" content="games, videogiochi, recensione, descrizione">
		<link rel="icon" type="ico" href="favicon.ico">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div id="container">
			<?php include "header.php";?>

			<div class="reg">
				<h1>Iscriviti</h1>

				<h2>Compila il form di iscrizione per poter accedere a contenuti esclusivi!</h2>

				<?php
					if (isset($_POST['nome']))
						$nome = $_POST["nome"];
					else
						$nome = "";

					if (isset($_POST['cognome']))
						$cognome = $_POST["cognome"];
					else
						$cognome = "";

					if (isset($_POST["sesso"])) 
						$sesso = $_POST["sesso"];
					else
						$sesso = "off";

					if (isset($_POST["email"])) 
						$email = $_POST["email"];
					else
						$email = "";

					if (isset($_POST["username"]))
						$username = $_POST['username'];
					else
						$username = "";

					if (isset($_POST["password"]))
						$password = $_POST["password"];
					else
						$password = "";

					if (isset($_POST['repassword']))
						$repassword = $_POST['repassword'];
					else
						$repassword = "";
					
					if (isset($_POST['privacy']))
						$privacy = $_POST['privacy'];
					else
					    $privacy = "off";
					
					/*Controllo password*/
					if (!empty($password)) {
						if ($password != $repassword) {
							//echo "<p> Hai sbagliato a digitare la password. Riprova</p>";
							$password = "";
					?>
						   	<div id="iderror1" class="window">
								<div class="modal-content">
			   						<div class="imgcontainer">
					    				<span class="close" onclick="document.getElementById('iderror1').style.display='none'" title="Chiudi Messaggio">&times;</span>
					    				<img src="messaggio_gif/error2.gif" alt="Errore" class="avatar">
					    				<p>Hai sbagliato a digitare la password. Riprova!</p>
			    				    </div>
			    				</div>
	    					</div> 
	    				<?php
							
						}
						else{
							/*Controllo campi obbligatori*/
							if (empty($nome))
								echo "<p> Spiacenti, campo Nome vuoto";
							if (empty($cognome))
								echo "<p> Spiacenti, campo Cognome vuoto";
							if (empty($sesso))
								echo "<p> Spiacenti, campo Sesso vuoto";
							if (empty($email))
								echo "<p> Spiacenti, campo E-mail vuoto";
							if (empty($username))
								echo "<p> Spiacenti, campo Username vuoto";
							if (empty($privacy))
								echo "<p> Spiacenti, campo Privacy vuoto";

							/*Controllo se l'utente già esiste*/
							if (username_exists($username)) {
								//echo "<p> Username $username già esistente. Riprova </p>";
								?>
								<div id="iderror2" class="window">
									<div class="modal-content">
				   						<div class="imgcontainer">
						    				<span class="close" onclick="document.getElementById('iderror2').style.display='none'" title="Chiudi Messaggio">&times;</span>
						    				<img src="messaggio_gif/error2.gif" alt="Errore" class="avatar">
						    				<p>Username <?php echo $username; ?> già esistente. Riprova!</p>
				    				    </div>
				    				</div>
		    					</div> 
								<?php
							}
							elseif (email_exists($email)) {
								//echo "<p> E-mail $email già registrata. Riprova </p>";
								?>
								<div id="iderror3" class="window">
									<div class="modal-content">
				   						<div class="imgcontainer">
						    				<span class="close" onclick="document.getElementById('iderror3').style.display='none'" title="Chiudi Messaggio">&times;</span>
						    				<img src="messaggio_gif/error2.gif" alt="Errore" class="avatar">
						    				<p>E-mail <?php echo $email; ?> già registrata. Riprova!</p>
				    				    </div>
				    				</div>
		    					</div> 
								<?php
							}
							else{
								/*Dopo tutti i controlli l'utente può essere inserito nel database*/
								if (insert_utente($nome, $cognome, $sesso, $email, $username, $password)) {
									//echo "<p> Utente registrato con successo. Ritorna alla <a href=\"homepage.php\">homepage</a> per effettuare il login</p>";
									?>
									<div id="idsuccess" class="window">
										<div class="modal-content">
					   						<div class="imgcontainer">
							    				<img src="messaggio_gif/done3.gif" alt="Registrazione Completata" class="avatar">
							    				<p>Utente registrato con successo.<br>Ritorna alla <a href="homepage.php">homepage</a> per effettuare il login</p>
					    				    </div>
					    				</div>
			    					</div> 
									<?php
								}
								else{
									//echo "<p> Errore durante la registrazione. Riprova</p>";
									?>
									<div id="iderror4" class="window">
										<div class="modal-content">
					   						<div class="imgcontainer">
							    				<span class="close" onclick="document.getElementById('iderror4').style.display='none'" title="Chiudi Messaggio">&times;</span>
							    				<img src="messaggio_gif/error2.gif" alt="Errore" class="avatar">
							    				<p>Errore durante la registrazione. Riprova!</p>
					    				    </div>
					    				</div>
			    					</div> 
									<?php
								}
							}
						}
					}
				?>

				<?php
					function username_exists($username){
						require "logindb.php";
						$db = pg_connect($connection_string) or die('Impossibile connettersi al database: '.pg_last_error());
				        //echo "Connessione al database riuscita<br/>";
				        $sql = "SELECT username FROM utente WHERE username = $1;";
						$prep = pg_prepare($db, "UsernameSQL", $sql);
						$ret = pg_execute($db, "UsernameSQL", array($username));
						if(!$ret){
							echo "ERRORE QUERY: " . pg_last_error($db);
							return false;
						}
						else{
							if($row = pg_fetch_assoc($ret)){
								return true;
							}
							else{
								return false;
							}
						}
					}
				
					function email_exists($email){
						require "logindb.php";
						$db = pg_connect($connection_string) or die('Impossibile connettersi al database: '.pg_last_error());
				        //echo "Connessione al database riuscita<br/>";
				        $sql = "SELECT email FROM utente WHERE email = $1;";
						$prep = pg_prepare($db, "EmailSQL", $sql);
						$ret = pg_execute($db, "EmailSQL", array($email));
						if(!$ret){
							echo "ERRORE QUERY: " . pg_last_error($db);
							return false;
						}
						else{
							if($row = pg_fetch_assoc($ret)){
								return true;
							}
							else{
								return false;
							}
						}
					}
				
					function insert_utente($nome, $cognome, $sesso, $email, $username, $password){
						require "logindb.php";
						$db = pg_connect($connection_string) or die('Impossibile connettersi al database: '.pg_last_error());
				        //echo "Connessione al database riuscita<br/>";
				        $hash = password_hash($password, PASSWORD_DEFAULT);
				        $sql = "INSERT INTO utente(nome, cognome, sesso, email, username, password) VALUES($1, $2, $3, $4, $5, $6)";
				        $prep = pg_prepare($db, "Inserimento", $sql);
				        $ret = pg_execute($db, "Inserimento", array($nome, $cognome, $sesso, $email, $username, $hash));
				        if(!$ret) {
							echo pg_last_error($db);
							return false;
						}
						else
							return true;
					}
				?>

				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" onSubmit="return validaModulo(this);" style="float: left; margin-right: 5%; width: 38%;">
						<fieldset>

							<p>
								<label for="nome">Nome <input type="input" name="nome" id="nome" placeholder="Inserisci il tuo nome" required value="<?php echo $nome;?>" /></label>
							</p>

							<p>
								<label for="cognome">Cognome <input type="input" name="cognome" id="cognome" placeholder="Inserisci il tuo cognome" required value="<?php echo $cognome;?>" /></label>
							</p>

							<p>
								<label for="sesso">Genere <input type="radio" name="sesso" id="maschio" value="M" checked
															<?php
																if(empty($sesso) OR $sesso=="M"){
																	echo "checked";
																}?>
															/>M
														    <input type="radio" name="sesso" id="femmina" value="F"
														    <?php
															    if($sesso=="F"){
															        echo "checked";
															    }?>
														    />F
								</label>
							</p>

							<p>
								<label for="email">E-mail <input type="email" name="email" id="email" placeholder="m.rossi@email.it" required value="<?php echo $email;?>" /></label>
							</p>

							<p>
								<label for="username">Username <input type="input" name="username" id="username" placeholder="Inserisci il tuo username" required value="<?php echo $username;?>" onchange="verifica(this)"/></label>
							</p>

							<p>
								<label for="password">Password <input type="password" name="password" id="password" placeholder="" required value="<?php echo $password;?>" /></label>
							</p>

							<p>
								<label for="repassword">Conferma Password <input type="password" name="repassword" id="repassword" placeholder="" required/></label>
							</p>

							<p>
								<label for="privacy">Ho letto e accettato: <input type="checkbox" name="privacy" id="privacy" required 
									<?php
									if($privacy=="on"){
										echo "checked";
									}?>
									/> <small><a href="https://protezionedatipersonali.it/informativa" target="_blank">Informativa sulla privacy</a></small></label>
							</p>

						</fieldset>

						<p>
							<input type="submit" value="Conferma" id="submit" name="submit" /> <input type="reset" value="Cancella" id="reset" name="reset" onclick="return confirm('Vuoi cancellare i dati inseriti?');">
						</p>

					</form>	
				
					<div class="cube">
						<div class="top"></div>
						<div>
							<span style="--i:0;"></span>
							<span style="--i:1;"></span>
							<span style="--i:2;"></span>
							<span style="--i:3;"></span>	
						</div>
					</div>

			</div>

			<?php include 'footer.html'; ?>
		</div>
	</body>
</html>

<script language="javascript" type="text/javascript">

	function validaModulo(nomeModulo) {
		if (nomeModulo.password.value != nomeModulo.repassword.value) {
			alert("Le due password non corrispondono");
			nomeModulo.repassword.focus();
			nomeModulo.repassword.select();
			return false;
		}
		return true
	}
	
	function verifica(nomeInput) {
		username = nomeInput.value;
		atPos = username.indexOf(" ", 0);
		if(atPos > -1) {
			alert("Non puoi inserire spazi vuoti");
			var a = new Array();
			a = username.split(" "); // restituisce un array splittato dallo spazio
			username = a[0]; 
			nomeInput.value = username;
		  }
	}	
</script>