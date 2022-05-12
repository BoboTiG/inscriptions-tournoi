<?php

try {
	(object)$bdd = new PDO('sqlite:db/tournoi7_2011-2012.db');
} catch ( PDOException $e ) {
	echo $e->getMessage();
}
(string)$sel = 'Ceci est un sel et non pas un SALT comme diraient les Rosebifles !';


/**********************************************************************/
// Fonction : creer_compte
// Objectif : créer un compte pour le chef d'équipe
// Entrée   : 
//		(string) nom du chef d'équipe
//		(string) nom d'utilisateur
//		(string) mot de passe
// Sortie   : (bool)
// MàJ      : 20120328
/**********************************************************************/
function creer_compte($nom = NULL, $id = NULL, $mdp = NULL) {
	global $bdd;
	if ( $nom === NULL || $id === NULL || $mdp === NULL ) { return FALSE; }
	if ( ! existe_compte($id) ) {
		$nom = $bdd->quote($nom, PDO::PARAM_STR);
		$mdp = $bdd->quote(pwd($id, $mdp), PDO::PARAM_STR);
		$id  = $bdd->quote($id, PDO::PARAM_STR);
		if ( $bdd->query("INSERT INTO 'tournoi7' (courriel, nom, mdp) VALUES ($id, $nom, $mdp)") ) {
			return TRUE;
		} else {
			// Debug
			//var_dump($bdd->errorInfo());
		}
	}
	return FALSE;
} //fin creer_compte ---------------------------------------------------


/**********************************************************************/
// Fonction : existe_compte
// Objectif : tester la présence d'un chef d'équipe
// Entrée   : 
//		(string) nom d'utilisateur
//		(string) mot de passe [optionel]
// Sortie   : (bool) existant
// MàJ      : 20120328
/**********************************************************************/
function existe_compte($id, $mdp = NULL) {
	global $bdd;
	(string)$ID = $bdd->quote($id, PDO::PARAM_STR);
	(int)$rep = 0;
	(string)$texte_sql = 
		"SELECT COUNT(courriel) AS n FROM 'tournoi7'
		WHERE courriel = $ID";
	
	if ( $mdp !== NULL ) {
		$mdp = $bdd->quote(pwd($id, $mdp), PDO::PARAM_STR);
		$texte_sql .= " AND mdp = $mdp";
	}
	foreach ( $bdd->query($texte_sql) as $un ) { $rep += $un['n']; }
	if ( $rep == 0 ) { return FALSE; }
	return TRUE;
} //fin existe_compte --------------------------------------------------


/**********************************************************************/
// Fonction : maj_equipe
// Objectif : mettre à jour les informations d'une équipe
// Entrée   : 
//		(string) ID (adresse courriel)
//		(string) nom de l'équipe
//		(string) type de challenge
//		(array) les équipiers
// Sortie   : (void)
// MàJ      : 20120328
/**********************************************************************/
function maj_equipe($id = NULL, $equipe = NULL, $challenge = NULL, $T = NULL) {
	global $bdd;
	if ( $id !== NULL && $equipe !== NULL && $challenge !== NULL && existe_compte($id) ) {
		$id = $bdd->quote($id, PDO::PARAM_STR);
		$equipe = $bdd->quote($equipe, PDO::PARAM_STR);
		$challenge = $bdd->quote($challenge, PDO::PARAM_STR);
		(string)$equipiers = $bdd->quote(serialize_perso($T), PDO::PARAM_STR);
		(string)$texte_sql = "UPDATE 'tournoi7' 
			SET equipe = $equipe, 
				challenge = $challenge,
				equipiers = $equipiers 
			WHERE courriel = $id";
		if ( ! $bdd->query($texte_sql) ) {
			// Debug
			//var_dump($bdd->errorInfo());
		}
	}
} //fin maj_equipe -----------------------------------------------------


/**********************************************************************/
// Fonction : pwd
// Objectif : créer un mot de passe
// Entrée   :
//		(string) nom d'utilisateur
//		(string) mot de passe
// Sortie   : (string) hash
// MàJ      : 20120328
/**********************************************************************/
function pwd($id, $mdp) {
	global $sel;
	return hash('sha1', $id.$sel.$mdp.strrev($sel).strrev($id));
} //fin pwd ------------------------------------------------------------


/**********************************************************************/
// Fonction : recup_infos
// Objectif : récupérer des informations précises d'un article
// Entrée   : 
//		(string) id
//		(string) quoi
// Sortie   : (mixed) infos
// MàJ      : 20120328
/**********************************************************************/
function recup_infos($id = NULL, $quoi) {
	global $bdd;
	(array)$infos = array();
	
	if ( $id !== NULL && existe_compte($id) ) {
		$id = $bdd->quote($id, PDO::PARAM_STR);
		(string)$texte_sql = 
			"SELECT $quoi FROM 'tournoi7'
			WHERE courriel = $id";
		foreach ( $bdd->query($texte_sql) as $donnees ) {
			$infos = $donnees;
		}
	}
	if ( $quoi != '*' && ! preg_match('/,/', $quoi) )
		return $infos[0];
	return $infos;
} //fin recup_infos ----------------------------------------------------


/**********************************************************************/
// Fonction : serialize_perso
// Objectif : linéariser un objet
// Entrée   : (mixed) objet à linéariser
// Sortie   : (string) valeur linéarisée et compressée
// MàJ      : 20111107
/**********************************************************************/
function serialize_perso($obj) {
	return base64_encode(gzcompress(serialize($obj)));
} //fin serialize_perso ------------------------------------------------


/**********************************************************************/
// Fonction : test_connexion
// Objectif : créer un compte pour le chef d'équipe
// Entrée   : 
//		(string) nom d'utilisateur
//		(string) mot de passe
// Sortie   : (bool)
// MàJ      : 20120328
/**********************************************************************/
function test_connexion($id = NULL, $mdp = NULL) {
	if ( $id === NULL || $mdp === NULL ) { return FALSE; }
	return existe_compte($id, $mdp);
} //fin test_connexion -------------------------------------------------


/**********************************************************************/
// Fonction : unserialize_perso
// Objectif : récupérer un objet à partir d'une valeur linéarisée
// Entrée   : (string) valeur linéarisée et compressée
// Sortie   : (mixed) objet de départ
// MàJ      : 20111107
/**********************************************************************/
function unserialize_perso($txt) {
	return unserialize(gzuncompress(base64_decode($txt)));
} //fin unserialize_perso ----------------------------------------------

?>
