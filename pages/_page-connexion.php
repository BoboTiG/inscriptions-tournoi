<div id="diamant">
	<br />
	<br />
	<br />
	<br />
	<?php
		/***************************************************************
		 * 
		 *                Date de fin des inscriptions                 *
		 * 
		 **************************************************************/
		(int)$jour = 1;
		(int)$mois = 6;
		if ( date('m') == $mois && date('d') == $jour ) {
			echo '<p class="centre">
				<br />
				Les inscriptions pour cette année sont closes.
				<br />
				<br />
				Cependant, vous pourrez toujours vous inscrire demain matin sans problème.
			</p></div>';
			return;
		} elseif ( date('m') >= $mois && date('d') > $jour ) {
			echo '<p class="centre"><br />Les inscriptions pour cette année sont closes.</p></div>';
			return;
		}
	?>
	<div id="ins" style="display:none;">
		<p>
			Futur chef d'équipe, rempli ces champs puis <a href="" onClick="affCache('con', 'ins');return false;">connecte-toi</a>.
		</p>
		<form method="post" action="">
			<label>Nom du chef</label>
			<br />
			<input type="text" name="nom" placeholder="Nom et prénom" required />
			<br />
			<br />
			<label>Adresse courriel</label>
			<br />
			<input type="email" name="id" placeholder="Adresse courriel" required />
			<br />
			<br />
			<label>Mot de passe</label>
			<br />
			<input type="password" name="mdp" style="width:135px;" placeholder="Mot de passe" required />
			<input type="hidden" name="ouak" value="nouv"/>
			<input type="submit" value="Créer"/>
		</form>
	</div>
	<div id="con">
		<p>
			<?php
				global $ok_compte;
				if ( $ok_compte === TRUE ) {
					echo '<strong>&nbsp;&nbsp;&nbsp;&nbsp; &raquo; Compte créé avec succès \o/</strong><br /><br />';
				} elseif ( $ok_compte === FALSE ) {
					echo '<strong>&nbsp;&nbsp;&nbsp;&nbsp; &raquo; Erreur lors de la création du compte :\'(</strong><br /><br />';
				}
			?>
			Chef d'équipe, connecte-toi à l'aide de tes identifiants ou <a href="" onClick="affCache('ins', 'con');return false;">créé vite fait un compte</a>.
		</p>
		<br />
		<form method="post" action="">
			<label>Nom d'utilisateur</label>
			<br />
			<input type="email" name="id" placeholder="Adresse courriel" required />
			<br />
			<br />
			<label>Mot de passe</label>
			<br />
			<input type="password" name="mdp" style="width:150px;" placeholder="Mot de passe" required />
			<input type="hidden" name="ouak" value="conn"/>
			<input type="submit" value="Ok"/>
		</form>
	</div>
</div>
