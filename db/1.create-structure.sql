CREATE TABLE IF NOT EXISTS tournoi7 (
	'courriel'  TEXT  NOT NULL UNIQUE, 
	'nom'       TEXT  NOT NULL, 
	'mdp'       TEXT  NOT NULL, 
	'equipe'    TEXT  NULL,
	'equipiers' TEXT  NULL,
	'challenge' TEXT  NULL
);
