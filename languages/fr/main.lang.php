<?php
/**
 * @subpackage 	languages (mumble PHP Interface v0.3.6.7)
 * @author 		esion - esion99@gmail.com
 * @since 		25 oct. 2009
 * @version		1.0 - 25 oct. 2009 - esion
 */
/**
 * This is the main language file, containing general strings that will be used in more than one section
 */

	// General Functions
	$txt['edit'] 	= 'éditer';			// Edit something
	$txt['cancel'] 	= 'annuler';		// Cancel, whatever you're doing (go back to the last page).
	$txt['update'] 	= 'sauver';		// Update the old item/key/var. Use the entered values as new values.
	$txt['remove'] 	= 'supprimer';

	// General
	$txt['server'] 						= 'Serveur';		// Mumble Server
	$txt['info_serverversion'] 			= 'Version du serveur : %s';
	$txt['info_scriptexecutiontime'] 	= 'Temps d\'execution du script : %6.3fms | pic de mémoire : ~%s kByte';
	$txt['failed'] 						= 'échec';

	// Account Information
	$txt['email'] 		= 'Email';
	$txt['username'] 	= 'Nom d\'utilisateur';
	$txt['password'] 	= 'Mot de passe';
	$txt['texture'] 	= 'Avatar';
	$txt['userid'] 		= 'ID utilisateur';

	$txt['texture_none'] 	= 'pas d\'image';
	$txt['texture_set'] 	= 'image définie';

	// Profile
	$txt['help_profile_textur'] = 'Cette texture d\'utilisateur sera affichée dans l\'overlay mumble à coté du pseudonyme s\'il est activé dans les options.';

	//Errors
	$txt['error_unknowninterface']		= 'Mauvaise configuration : Type d\'interface de <acronym title="Base de données">BDD</acronym> Inconnue!';
	$txt['unknownserver']				= 'Serveur introuvable.';
	$txt['error_missing_values']		= 'Il semble que toutes les variables nécessaires n\'aient pas été spécifiées.';
	$txt['error_noIce']					= 'Impossible de se connecter à Ice.<br/>Soit votre serveur n\'est pas actif soit il n\est pas configuré avec Ice. Vérifiez votre configuration.';
	$txt['error_db_unknowntype']		= 'La base de données que vous avez spécifié (dans vos paramètres) est inexistante ou indéfinie.';
	$txt['iceprofilealreadyloaded']		= 'Le profil Ice a déjà été chargé!';
	$txt['error_dbmanager_couldnotopenadmins'] = 'Impossible d\'ouvrir le fichier admins.dat.';
