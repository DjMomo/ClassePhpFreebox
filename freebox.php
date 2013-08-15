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
			$configuration->UpdateLcdConfig($array_config);
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
			$configuration->UpdateLcdConfig($array_config);
			break;
		}
		case "reboot" :
		{
			// Reboote la Freebox Server
			
			// Instantation de la classe PHP de la partie System
			$system = new System($freebox);
			$system->Reboot();			
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
			$configuration->UpdateWifiConfig($array_config);
			break;
		}
	}
}

/********** Lecture **********/
/* Retourne tous les paramètres de la freebox dans un fichier XML */
else
{
	$array_classes = $freebox->GetListClasses();
	
	// Création fichier XML avec les données
	// Instance de la class DomDocument
	$doc = new DOMDocument();

	// Definition de la version et de l'encodage
	$doc->version = '1.0';
	$doc->encoding = 'UTF-8';
	$doc->formatOutput = true;

	// Ajout d'un commentaire a la racine
	$comment_elt = $doc->createComment(utf8_encode('Données de la Freebox Révolution - Boitier Server'));
	$doc->appendChild($comment_elt);

	$racine = $doc->createElement('freeboxOS');

	// Ajout la balise 'update' a la racine
	$version_elt = $doc->createElement('update',date("Y-m-d H:i"));
	$racine->appendChild($version_elt);
	
	foreach ($array_classes as $class_name)
	{
		$Classe_Elt = $doc->createElement(str_replace($char_interdit_xml,"-",$class_name));
				
		$class_methods = get_class_methods($class_name);
		$class = new $class_name($freebox);
		foreach ($class_methods as $method_name) 
		{
			if (substr($method_name,0,3) === "Get")
			{
				$r = new ReflectionMethod($class_name, $method_name);
				$params = $r->getNumberOfParameters();
				if ($params == 0)
				{
					$datas = call_user_func(array($class, $method_name));
					$Method_Elt = $doc->createElement(str_replace($char_interdit_xml,"-",$method_name));
					DomArrayToXml($datas["result"], $doc, $Method_Elt);
					$Classe_Elt->appendChild($Method_Elt);
				}
			}
			$racine->appendChild($Classe_Elt);
		}
	}	
	$doc->appendChild($racine);
	echo $doc->saveXML();
}

/**
* Converti (récursivement) un array en XML (via DOM)
*/
function DomArrayToXml($array, $dom_doc, $node)
{
	if (is_array($array))
	{
		foreach($array as $key => $item)
		{
			if (is_numeric($key))
				$key = "id-".$key;
		
			if(is_array($item))
			{
				$element = $dom_doc->createElement($key);
				DomArrayToXml($item, $dom_doc, $element);
				$node->appendChild($element);
			}
			else
			{
				if ($item === true) $item = 1;
				if ($item === false) $item = 0;
				$element = $dom_doc->createElement($key,utf8_encode($item));	
				$node->appendChild($element);
			}	
		}
	}
	else
	{
		$element = $dom_doc->createElement("Datas",utf8_encode("Nothing"));	
		$node->appendChild($element);
	}
}

?>