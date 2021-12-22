<?php require_once "logindb.php"; ?>
<!DOCTYPE html>
<html lang="it">
	<head>
		<title>Genere | NIGG Games</title>
		<meta charset="utf-8">
		<meta name="author" content="Gruppo 16">
		<meta name="keywords" content="games, videogiochi, recensione, descrizione">
		<link rel="icon" type="ico" href="favicon.ico">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<?php session_start(); ?>
	<body>
		<div id="container">
			<?php include "header.php";?>

			<div class="row">
				
			    <?php include "vmenu.php";?>

			    <div class="column content">

			    	<?php
						if (isset($_GET["categoria"])) {
						//significa che nella url è presente il parametro categoria (si dice che in querystring è presente categoria)
							
							$db = pg_connect($connection_string) or die('Impossibile connettersi al database: '.pg_last_error());
								//echo "Connessione al database riuscita<br/>";

							$categoria = $_GET["categoria"];
						
					?>
							<h1><?php echo $categoria; ?></h1>
						
					<?php 
							$sql = "SELECT idgioco, nomegioco, copertina, consoleps4, consolexbox, consoleswitch, datapubblicazione, prezzolancio, modalita FROM gioco WHERE genere = '$categoria'";
							$result = pg_query($db, $sql) or die(pg_last_error());
							if (!$result){
								echo "ERRORE QUERY: " . pg_last_error($db);
							}
							while ($row = pg_fetch_assoc($result)) {
								$idgioco = $row["idgioco"];
								$nomegioco = $row["nomegioco"];
								$copertina = $row["copertina"];
								$consoleps4 = $row["consoleps4"];
								$consolexbox = $row["consolexbox"];
								$consoleswitch = $row["consoleswitch"];
								$datapubblicazione = $row["datapubblicazione"];
								$prezzolancio = $row["prezzolancio"];
								$modalita = $row["modalita"];
					?>
								<div class="container-gioco">
									<a href="videogioco.php?id=<?php echo $idgioco; ?>"><img src="<?php echo $copertina; ?>" alt="Copertina"></a>
									
									<div class="container-info">
										<a href="videogioco.php?id=<?php echo $idgioco; ?>"><h2><?php echo $nomegioco; ?></h2></a>
										<p><?php 
												if ($consoleps4 == "t") {
													echo "<p class=\"console ps4\">PlayStation 4 </p>";
												}
												if ($consolexbox == "t") {
													echo "<p class=\"console xbox\">Xbox One </p>";
												}
												if ($consoleswitch == 't') {
													echo "<p class=\"console switch\">Nintendo Switch</p>";
												}
										   ?></p>
										<p>Data pubblicazione: <?php echo $datapubblicazione; ?></p>
										<p>Prezzo di uscita: <?php echo $prezzolancio; ?>€</p>
										<p>Modalità: <?php echo $modalita; ?></p>
									</div>
								</div>
								<hr>
					<?php
							}
						}
						pg_close($db);
					?> 
			    </div>

			</div>

			<?php include 'footer.html'; ?>

		</div>

	</body>
</html>