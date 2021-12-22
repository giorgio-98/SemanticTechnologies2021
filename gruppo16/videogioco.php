<?php require_once "logindb.php"; ?>
<!DOCTYPE html>
<html lang="it">
	<head>
		<title>Videogioco | NIGG Games</title>
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
						if (isset($_GET["id"])) {
						//significa che nella url è presente il parametro id (si dice che in querystring è presente id)
							
							$db = pg_connect($connection_string) or die('Impossibile connettersi al database: '.pg_last_error());

							$id = $_GET["id"];

							$sql = "SELECT nomegioco, copertina, consoleps4, consolexbox, consoleswitch, prezzolancio, trailer, descrizione, recensione, linkamazon, linkps4, linkxbox, linkswitch, prezzoamazon, prezzops4, prezzoxbox, prezzoswitch, valutazionestella FROM gioco WHERE idgioco = '$id'";

							$result = pg_query($db, $sql) or die(pg_last_error());
							if (!$result){
								echo "ERRORE QUERY: " . pg_last_error($db);
							}

							$row = pg_fetch_assoc($result);

							$nomegioco = $row["nomegioco"];
							$copertina = $row["copertina"];
							$consoleps4 = $row["consoleps4"];
							$consolexbox = $row["consolexbox"];
							$consoleswitch = $row["consoleswitch"];
							$prezzolancio = $row["prezzolancio"];
							$trailer = $row["trailer"];
							$descrizione = $row["descrizione"];
							$recensione = $row["recensione"];
							$linkamazon = $row["linkamazon"];
							$linkps4 = $row["linkps4"];
							$linkxbox = $row["linkxbox"];
							$linkswitch = $row["linkswitch"];
							$prezzoamazon = $row["prezzoamazon"];
							$prezzops4 = $row["prezzops4"];
							$prezzoxbox = $row["prezzoxbox"];
							$prezzoswitch = $row["prezzoswitch"];
							$valutazionestella = $row["valutazionestella"];
					?>
                            
                            <h1><?php echo $nomegioco;?></h1>
							
							<iframe width="560" height="315" src="<?php echo $trailer; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

							<div class="container-descrizione">
								<img src="<?php echo $copertina; ?>" alt="Copertina">
								<div class="container-infogioco">
									<h2>Descrizione</h2>
									<p><?php echo $descrizione; ?></p>
								</div>
							</div>

							<div class="container-recensione">
								<h2>La nostra recensione</h2>
								<?php 
									if (empty($_SESSION["uname"])) {
								?>
										<p class="alertlogin">Effettua il login per poter leggere la nostra recensione!</p>	
								<?php
									}
									else{
								?>
										<p id="recensione"><?php echo $recensione; ?></p>
										<img src="<?php echo $valutazionestella; ?>">
								<?php
									}
								?>
							</div>

							<div class="container-acquisto">
								<h2>Dove acquistarlo?</h2>
								<?php 
									if (empty($_SESSION["uname"])) {
								?>
										<p class="alertlogin">Effettua il login per acquistare il prodotto al miglior prezzo!</p>	
								<?php
									}
									else{
								?>
										<div class="riferimenti">
											<ul>
												<li><?php
														if (empty($linkamazon)) {
														}
														else {
													?>	
															<a href="<?php echo $linkamazon; ?>" target="_blank">
													<?php			
														}
													?>
													<img src="siti/amazon.png" alt="Amazon"></a><p><?php echo $prezzoamazon; ?></p></li>
												<li><?php
														if (empty($linkps4)) {
														}
														else {
													?>	
															<a href="<?php echo $linkps4; ?>" target="_blank">
													<?php			
														}
													?>
													<img src="siti/ps4store.png" alt="PlayStation Store"></a><p><?php echo $prezzops4; ?></p></li>
												<li><?php
														if (empty($linkxbox)) {
														}
														else {
													?>	
															<a href="<?php echo $linkxbox; ?>" target="_blank">
													<?php			
														}
													?>
													<img src="siti/Xbox.png" alt="Xbox"></a><p><?php echo $prezzoxbox; ?></p></li>
												<li><?php
														if (empty($linkswitch)) {
														}
														else {
													?>	
															<a href="<?php echo $linkswitch; ?>" target="_blank">
													<?php			
														}
													?>
													<img src="siti/nintendo.png" alt="Nintendo eShop"></a><p><?php echo $prezzoswitch; ?></p></li>
											</ul>
										</div>	
										<?php
											}
										?>
								</div>

								<div class="container-votazioni">
								<?php 

									$angryquery = "SELECT count(*) as col1 FROM reazioni WHERE reaction = 'angry' AND idvideogame = '$id'";
									$angryres = pg_query($db, $angryquery) or die(pg_last_error());
									if (!$angryres){
										echo "ERRORE QUERY: " . pg_last_error($db);
									}
									$row1 = pg_fetch_assoc($angryres);
									$angry = $row1['col1'];

									$bluelikequery = "SELECT count(*) as col2 FROM reazioni WHERE reaction = 'bluelike' AND idvideogame = '$id'";
									$bluelikeres = pg_query($db, $bluelikequery) or die(pg_last_error());
									if (!$bluelikeres){
										echo "ERRORE QUERY: " . pg_last_error($db);
									}
									$row2 = pg_fetch_assoc($bluelikeres);
									$bluelike = $row2['col2'];

									$wowquery = "SELECT count(*) as col3 FROM reazioni WHERE reaction = 'wow' AND idvideogame = '$id'";
									$wowres = pg_query($db, $wowquery) or die(pg_last_error());
									if (!$wowres){
										echo "ERRORE QUERY: " . pg_last_error($db);
									}
									$row3 = pg_fetch_assoc($wowres);
									$wow = $row3['col3'];

									if (empty($_SESSION["uname"])) {
								?>
										<p class="alertlogin">Facci sapere la tua opinione! Effettua il login!</p>	
								<?php
									}
									else{
								?>
										<h2>Facci sapere la tua opinione</h2>
										<div class="emoji">
											<ul>
												<li><a href="inserimentoReazioni.php?voto=bluelike&id=<?php echo $id;?>"><img src="stelle/like.png" alt="Like reaction" onmouseover="big(this)" onmouseout="normal(this)"></a><p class="contatore"><?php echo $bluelike; ?></p></li>
												<li><a href="inserimentoReazioni.php?voto=angry&id=<?php echo $id;?>"><img src="stelle/angry.png" alt="Angry reaction" onmouseover="big(this)" onmouseout="normal(this)"></a><p class="contatore"><?php echo $angry; ?></p></li>
												<li><a href="inserimentoReazioni.php?voto=wow&id=<?php echo $id;?>"><img src="stelle/wow.png" alt="Wow reaction" onmouseover="big(this)" onmouseout="normal(this)"></a><p class="contatore"><?php echo $wow; ?></p></li>
											</ul>
										</div>	
										<?php
											}       
										?>
								</div>
					<?php
						
						}
						pg_close($db);
					?> 


				</div>

			</div>

			<?php include 'footer.html'; ?>

		</div>

	</body>
</html>

<script>
	function big(x){
		x.style.height="50px";
		x.style.width="50px";
	}

	function normal(x){
		x.style.height="40px";
		x.style.width="40px";
	}
</script>