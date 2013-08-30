<?php

/*************************************************************************************
**												
** Exemple de script de gestion de la Freebox Révolution - Boitier Server
**
** https://github.com/DjMomo/ClassePhpFreebox
**
**************************************************************************************/

// inclusion de la classe PHP Freebox
// Les classes du dossier API sont incluses automatiquement
require('freebox.class.php');

// Fichier de configuration de la classe PHP
$config_file = 'mafreebox.cfg';
if(file_exists($config_file))
	require_once($config_file);
else
	die ("Fichier de configuration manquant !");

// Liste de caractères interdits dans un fichier XML
$char_interdit_xml = array("!","\"","#","$","%","&","'","(",")","*","+",",","/",";","<","=",">","?","@","[","\\","]","^","`","{","|","}","~");

// Instantation de la classe PHP Freebox pour l'authentification (obligatoire)
$freebox = new apifreebox($config);

/*************************************************************************************
**
** Ci dessous, 2 exemples : des écritures de données et une lecture de données
**
**************************************************************************************/

/********** Ecritures **********/
// On récupère l'argument
if (isset($_GET['do']) && ($_GET['do'] != null))
	$do = $_GET['do'];

if (isset($do))
{
	switch ($do)
	{
		// Quelques exemples d'actions sur la freebox Server
		case "lcd_brightness" :
		{
			// Fixe la valeur de luminosité du lcd. 
			
			// Instantation de la classe PHP de la partie Configuration
			$configuration = new Configuration($freebox);
					
			// Valeur en %, de 0 à 100.
			if (isset($_GET['val']) && (is_numeric($_GET['val'])))
				$brightness = $_GET['val'];
			else
				$brightness = 100;
			$array_config = array('brightness' => $brightness);
			$freebox->DisplayResult($configuration->UpdateLcdConfig($array_config),"lcd_brightness");
			break;
		}
		case "lcd_orientation" :
		{
			// Fixe l'orientation du lcd. 
			
			// Instantation de la classe PHP de la partie Configuration
			$configuration = new Configuration($freebox);
						
			// Valeur en degrés, de 0 à 90.
			if (isset($_GET['val']) && (is_numeric($_GET['val'])))
				$orientation = $_GET['val'];
			else
				$orientation = 0;
			$array_config = array('orientation' => $orientation);
			$freebox->DisplayResult($configuration->UpdateLcdConfig($array_config),"lcd_orieentation");
			break;
		}
		case "reboot" :
		{
			// Reboote la Freebox Server
			
			// Instantation de la classe PHP de la partie System
			$system = new System($freebox);
			$freebox->DisplayResult($system->Reboot(),"reboot");			
			break;
		}

		case "wifi" :
		{
			// Active/désactive la carte Wifi
			
			// Instantation de la classe PHP de la partie Configuration
			$configuration = new Configuration($freebox);
						
			// On ou off
			if ($_GET['val'] === "on" )
				$enabled = true;
			else
				$enabled = false;
			$array_config = array("ap_params" => array( "enabled" => $enabled));
			$freebox->DisplayResult($configuration->UpdateWifiConfig($array_config),"wifi");
			break;
		}
	}
}

/********** Lecture **********/
else
{
	$xml = $freebox->config_to_XML();
	echo $xml;
}


?>