<?php
	(array)$infos = recup_infos($_SESSION['t7']['id'], '*');
?>
<div id="diamantlong">
	<br />
	<br />
	<br />
	<br />
	<p>
		<form method="post" action="" class="deco">
			<input type="hidden" name="ouak" value="deco"/>
			<input type="submit" value="Me déconnecter"/>
		</form>
		<form method="post" action="">
			<label>Nom de ton équipe et choix du type de challenge</label>
			<br />
			<input type="text" name="equipe" style="width:260px;" placeholder="Nom de l'équipe" value="<?php echo $infos['equipe']; ?>" required />
			<select name="chal">
				<optgroup label="Type">
					<option value="compet" <?php echo $infos['challenge'] == 'compet' ? 'selected' : ''; ?>>Compétition</option>
					<option value="loisir" <?php echo $infos['challenge'] == 'loisir' ? 'selected' : ''; ?>>Loisir</option>
				</optgroup>
			</select>
			<br />
			<br />
			<label>Noms de tes équipiers</label>
			<br />
			<?php
				(array)$equipiers = unserialize_perso($infos['equipiers']);
				(int)$n = count($equipiers);
				for ( (int)$i = 1; $i < 12; ++$i ) {
					echo '<input type="text" class="champs" name="e'.$i.'" placeholder="Équipier '.$i.'" value="'.$equipiers[$i].'"/> ';
					if ( $i % 2 == 0 ) {
						echo '<br />';
					}
				}
			?>
			<input type="hidden" name="ouak" value="equi"/>
			<input type="submit" value="Mettre à jour"/>
		</form>
	</p>
	<p class="centre">
		<u>Note</u> : les frais d'inscriptions sont de 5€/personne.
	</p>
</div>
