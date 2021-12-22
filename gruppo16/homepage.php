<?php require_once "logindb.php"; ?>
<!DOCTYPE html>
<html lang="it">
	<head>
		<title>NIGG Games | Sito Ufficiale</title>
		<meta charset="utf-8">
		<meta name="author" content="Gruppo 16">
		<meta name="keywords" content="games, videogiochi, recensione, descrizione">
		<meta name="description" content="NIGG Games è un sito web per la recensione e descrizione di videogiochi, che offre ai visitatori non solo informazioni tecniche ma anche impressioni personali sull’esperienza di gioco.">
		<link rel="icon" type="ico" href="favicon.ico">
		<link rel="stylesheet" type="text/css" href="style.css">
	    <link rel="stylesheet" type="text/css" href="slideshow.css">
	</head>

	<?php session_start(); ?>
	<body>
		<div id="container">
			<?php include "header.php";?>

			<div class="row">
			    <?php include "vmenu.php";?>

			    <div class="column content">
			    	
			    	<div class="slideshow-container">

						<div class="mySlides fade">
						  <img src="immagini/f12020.jpg">
						</div>

						<div class="mySlides fade">
						  <img src="immagini/nba.png">
						</div>

						<div class="mySlides fade">
						   <img src="immagini/pokemon.jpg">
						</div>

						<div class="mySlides fade">
						  <img src="immagini/star_wars.png">
						</div>

						<div class="mySlides fade">
						  <img src="immagini/the_sims.png">
						</div>

					</div>

					<br>
					
					<div style="text-align:center">
						<span class="dot"></span> 
						<span class="dot"></span> 
						<span class="dot"></span>
						<span class="dot"></span> 
						<span class="dot"></span> 
					</div>
					

					<script>
						var slideIndex = 0;
						showSlides();

						function showSlides() {
						var i;

						// document.getElementsByClassName Prende tutti gli elementi con il nome della classe specificata
					    var slides = document.getElementsByClassName("mySlides");
						var dots = document.getElementsByClassName("dot");

						// La funzione nasconde (display = "none") tutti gli elementi con il nome di classe "mySlides" e visualizza (display = "block") l'elemento con slideIndex specificato.
									  for (i = 0; i < slides.length; i++) {
									  	slides[i].style.display = "none";  
									  }

									  // slideIndex parte da 1
									  slideIndex++;

									  // If riporta slideIndex ad 1 quando questo diventa 4, ovvero superiamo 
									  if (slideIndex > slides.length) {slideIndex = 1}

									  // Per disattivare un dot, rimpiazzo la classe active con "".
									for (i = 0; i < dots.length; i++) {
										dots[i].className = dots[i].className.replace(" active", "");
									}

									  // ([slideIndex-1] poichè con slideIndex++ va da 1 a 3, mentre gli indici delle slides vanno da 0 a 2)
									  slides[slideIndex-1].style.display = "block";

									  // Aggiunge la classe active al bottone corrente ([slideIndex-1] poichè con slideIndex++ va da 1 a 3, mentre gli indici dei dots vanno da 0 a 2)
									  dots[slideIndex-1].className += " active";

									  // Cambia immagine ogni 4 secondi
									  setTimeout(showSlides, 4000);
									}
					</script>
					<h1 id="titolohome">Giochi in evidenza</h1>
					<?php
					
						$db = pg_connect($connection_string) or die('Impossibile connettersi al database: '.pg_last_error());
						/*query per le informazioni utili da usare nella homepage*/	
						$sql = "SELECT idgioco, nomegioco, copertina, anteprima FROM gioco";
						$result = pg_query($db, $sql) or die(pg_last_error());
						if (!$result){
							echo "ERRORE QUERY: " . pg_last_error($db);
						}
						/*query per contare gli elementi presenti nella relazione gioco*/
						$sql2 = "SELECT count(idgioco) as totgiochi FROM gioco";
						$result2 = pg_query($db, $sql2) or die(pg_last_error());
						if (!$result2){
							echo "ERRORE QUERY: " . pg_last_error($db);
						}
						/*salvo in tot il numero totale di giochi*/
						$riga1 = pg_fetch_assoc($result2);
						$tot = $riga1["totgiochi"];

						$seed = range(0, $tot - 1); /*crea un array contenente un range di elementi con i numeri da 0 a $tot - 1*/
						shuffle($seed);      /*disponde in ordine casuale gli elementi dell'array*/

						for ($i=0; $i < 3; $i++) {
							
							$row = pg_fetch_assoc($result, $seed[$i]);
						
							$idgioco = $row["idgioco"];
							$nomegioco = $row["nomegioco"];
							$copertina = $row["copertina"];
							$anteprima = $row["anteprima"];
                    ?>

                    		<div class="container-random">
                    			<a href="videogioco.php?id=<?php echo $idgioco; ?>"><img src="<?php echo $copertina; ?>" alt="Copertina"></a>
								<div class="container-info">
									<a href="videogioco.php?id=<?php echo $idgioco; ?>"><h2><?php echo $nomegioco; ?></h2></a>
									<p><?php echo $anteprima; ?></p>
								</div>
                    		</div>
                    <?php
						}
					?>

			    </div>

			</div>

			<?php include 'footer.html'; ?>
		</div>
	</body>
</html>