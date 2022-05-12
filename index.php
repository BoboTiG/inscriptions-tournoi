<?php
	error_reporting(0);
	session_start();
	date_default_timezone_set('Europe/Paris');
	
	require '_fonctions-bdd.php';
	usleep(200000);
	
	(bool)$ok           = FALSE;
	(bool)$maj          = FALSE;
	(bool)$ok_compte    = NULL;
	(array)$acceptables = array('conn', 'deco', 'equi', 'nouv', 'compet','loisir');
	(string)$ouak       = isset($_POST['ouak']) && in_array($_POST['ouak'], $acceptables) ? $_POST['ouak'] : NULL;
	(string)$nom        = isset($_POST['nom'])  && ! empty($_POST['nom']) ? $_POST['nom'] : NULL;
	(string)$id         = isset($_POST['id'])   && ! empty($_POST['id']) ? $_POST['id'] : NULL;
	(string)$mdp        = isset($_POST['mdp'])  && ! empty($_POST['mdp']) ? $_POST['mdp'] : NULL;
	
	if ( $ouak !== NULL ) {
		if ( $ouak == 'conn' ) {
			$ok = test_connexion($id, $mdp);
			if ( $ok === TRUE ) {
				$_SESSION['t7'] = array();
				$_SESSION['t7']['id'] = $id;
				$_SESSION['t7']['ok'] = TRUE;
			}
		} elseif ( $ouak == 'deco' ) {
			unset($_SESSION['t7']);
		} elseif ( $ouak == 'equi' ) {
			(array)$T          = array();
			(string)$equipe    = '';
			(string)$challenge = '';
			(int)$n = 0;
			foreach ( $_POST as $key => $value ) {
				if ( $key == 'equipe' && ! empty($value) ) {
					$equipe = $value;
				} elseif ( $key == 'chal' && in_array($value, $acceptables) ) {
					$challenge = $value;
				} elseif ( preg_match('/^e\d+$/', $key) && ! empty($value) ) {
					++$n;
					if ( $n <= 11 ) {
						$T[$n] = $value;
					}
				}
			}
			maj_equipe($_SESSION['t7']['id'], $equipe, $challenge, $T);
			$maj = TRUE;
		} elseif ( $ouak == 'nouv' ) {
			$ok_compte = creer_compte($nom, $id, $mdp);
		}
	}
	if ( isset($_SESSION['t7']['id']) ) {
		if ( ! existe_compte($_SESSION['t7']['id']) ) {
			unset($_SESSION['t7']);
		}
	}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>.: Tournoi à 7 - Amicale du RC Metz :.</title>
		<meta charset="utf-8" />
		<link rel="icon" href="img/logo.png" type="image/png" />
		<meta name="viewport" content="width=device-width" />
		<link rel="stylesheet" media="all" type="text/css" href="css/all.css" />
	</head>
	
	<body>
		<?php
			if ( $maj === TRUE ) {
				echo '<div id="message">Mise &agrave; jour  effectu&eacute;e avec succ&egrave;s !</div>';
			}
		?>
		<div id="post-it" class="centre">
			<img src="img/post-it.png" alt="post-it.png" title="Post-it" width="300" height="261"/>
		</div>
		<?php
			if ( $_SESSION['t7']['ok'] === TRUE ) {
				include 'pages/_page-liste.php';
			} else {
				include 'pages/_page-connexion.php';
			}
		?>
		<div class="centre">
			<div id="rebond">
				<img src="img/rebond.png" alt="rebond.png" title="Rebond balle de rugby" width="502" height="124"/>
			</div>
			Amicale des joueurs du Rugby Club Metz-Moselle
			<span class="hide_mobile_p">|</span> contact : <span class="courriel">moc.liamg@222.gnipool</span>
			<br />
			<br />
		</div>
		
		<!-- Piwik -->
		<script type="text/javascript">
			var pkBaseURL = (("https:" == document.location.protocol) ? "https://bobotig.fr/piwik/" : "http://bobotig.fr/piwik/");
			document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
			try {
			var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 4);
			piwikTracker.trackPageView();
			piwikTracker.enableLinkTracking();
			} catch( err ) {}
		</script>
		<noscript><p><img src="http://bobotig.fr/piwik/piwik.php?idsite=4" style="border:0" alt="" /></p></noscript>
		<!-- End Piwik Tracking Code -->
		
		<script>
			function affCache(a, b) {
				document.getElementById(a).style.display = 'block';
				document.getElementById(b).style.display = 'none';
			}
			setTimeout(function() {
				var a = document.getElementById('message');
				if ( a != undefined ) {
					a.style.opacity = 0.1;
				}
			}, 2000);
		</script>
	</body>
</html>
