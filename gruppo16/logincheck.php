
<?php
	
	if (isset($_POST['buttonlogin'])) {            /*se abbiamo premuto il tasto di invio al form*/
		if($_POST['uname'] || $_POST['psw']) {     /*se sono inseriti i campi*/
			$uname = $_POST['uname'];
			$psw = $_POST['psw'];

			$hash = get_pwd($uname);
			if(!$hash){
				if(strpos($_SERVER['HTTP_REFERER'], '?') > 0)
					header("Location: " . $_SERVER['HTTP_REFERER'] . "&NonValido= L'utente $uname non esiste. Riprova");
				else
					header("Location: " . $_SERVER['HTTP_REFERER'] . "?NonValido= L'utente $uname non esiste. Riprova");
			}
			else{
				if(password_verify($psw, $hash)){
					session_start();
					$_SESSION['uname'] = $uname; //salvo nella sessione l'username
					if (strtok($_SERVER["HTTP_REFERER"], '?') == "http://localhost/gruppo16/registrazione.php") { 
						/*se viene effettuato il login nella pagina di registrazione, l'utente viene riportato all'hompage*/
						header("Location: homepage.php");
					}
					else{
						if (strstr($_SERVER['HTTP_REFERER'], '?id') || strstr($_SERVER['HTTP_REFERER'], '?categoria')) {
							$url = reset((explode('&', $_SERVER['HTTP_REFERER']))); /*per riavere l'indirizzo base senza segnalazione di errore*/
						    header("Location:" . "$url"); //reindirizzamento a un'altra pagina
						}
						else{
							$url = reset((explode('?', $_SERVER['HTTP_REFERER']))); /*per riavere l'indirizzo base senza query string, altrimenti ci riapriva il div del login ogni volta con il messaggio di errore*/
							header("Location:" . "$url"); //reindirizzamento a un'altra pagina
						}
					}  
				}
				else{
					if(strpos($_SERVER['HTTP_REFERER'], '?') > 0)
					    header("Location: " . $_SERVER['HTTP_REFERER'] . "&NonValido= Username o password errati");
				    else
					    header("Location: " . $_SERVER['HTTP_REFERER'] . "?NonValido= Username o password errati");	/*serve per essere reindirizzati nella stessa pagina e aggiungere il valore del messaggio di errore*/
				}
			}
		}
		else{
			if(strpos($_SERVER['HTTP_REFERER'], '?') > 0)
				header("Location: " . $_SERVER['HTTP_REFERER'] . "&CampoVuoto= Username o Password non inseriti");
			else{
			    header("Location:" . $_SERVER['HTTP_REFERER'] .  "?CampoVuoto= Username o Password non inseriti"); /*serve per essere reindirizzati nella stessa pagina e aggiungere il valore del messaggio di errore*/
			    exit();
			}
		}
	}	
	?>

	<?php
		function get_pwd($uname){
			require "logindb.php";
			$db = pg_connect($connection_string) or die('Impossibile connettersi al database: '.pg_last_error());
				echo "Connessione al database riuscita<br/>";
			$sql = "SELECT password FROM utente WHERE username = $1;";
			$prep = pg_prepare($db, "PasswordSQL", $sql);
			$ret = pg_execute($db, "PasswordSQL", array($uname));
			if(!$ret){
				echo "ERRORE QUERY: " . pg_last_error($db);
				return false;
			}
			else{
				if($row = pg_fetch_assoc($ret)){
					$psw = $row['password'];
					return $psw;
				}
				else{
					return false;
				}
			}
		}
	?>