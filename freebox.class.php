<?php
/**
  * API Freebox OS
  * https://github.com/DjMomo/ClassePhpFreebox
  *
*/

class apifreebox
{
	private $IP;
	private $PORT;
	private $BASE_URL;
	private $URL;
	private $APP_TOKEN;
	private $TRACK_ID;
	private $APP_ID;
	private $APP_NAME;
	private $APP_VERSION;
	private $DEVICE_NAME;
	private $SESSION_TOKEN;

	//protected $API = array();

	/**
	* Constructeur
	* @param array configuration
	*/
	public function __construct($config)
	{
		// On assigne les paramètres aux variables d'instance.
		$this->IP = $config['url'];
		$this->PORT = $config['port'];
		$this->APP_ID = $config['app_id'];
		$this->APP_NAME = $config['app_name'];
		$this->APP_VERSION = $config['app_version'];
		$this->DEVICE_NAME = $_SERVER["SERVER_NAME"];
		$api_info = $this->_GetAPIInfo();
		$api_version = explode(".",$api_info['api_version']);
		$this->BASE_URL = $this->IP.":".$this->PORT.$api_info['api_base_url']."v".$api_version[0]."/";
		
		$this->_NewSession();
	}
  
	/**
	* Retourne les méthodes "Getxxxx" d'une classe
	* @param string objet de la classe
	*/
	public function GetMethodsList($class)
	{
		$methods = get_class_methods($class);
		$i = 0;
		$j = 1; // ignore __construct
		foreach ($methods as $method)
		{
			if ((strtolower(substr($method,0,3))) === "get")
			{
				$list[$i] = $method;
				$i++;
			}
			$j++;
		}
		return $list;
	}
	/**
	* Retourne la version de l'API Freebox
	*/
	public function _GetAPIInfo ()
	{
		$this->URL = $this->IP.':'.$this->PORT.'/api_version';
		return $this->get();
	}

	/**
	* Effectue l'authentification auprès de la Freebox
	* @param bool Force le rafraichissement du token
	*/
	public function _RequestAuth($force_refresh = 0)
	{
		$appURL = "login/authorize/";
		$TokenFile = "token";
		$appParams = array (
				"app_id" => $this->APP_ID,
				"app_name" => $this->APP_NAME,
				"app_version" => $this->APP_VERSION,
				"device_name" => $this->DEVICE_NAME
					);

		if ((!file_exists($TokenFile)) || ($force_refresh == 1))
		{				
			$result = $this->setURL($appURL)->post($appParams);
			
			$csvdata = array(	
						$result['result']['app_token'], 
						$result['result']['track_id']
							);

			if ($result['success'] == true)
			{
				if ((is_writable($TokenFile)) || (!file_exists($TokenFile))) 
				{
					if (!$fp = fopen($TokenFile, 'w'))
					{
						echo "Impossible d'ouvrir le token $TokenFile";
						exit;
					}
				
					fputcsv($fp, $csvdata);

					$this->APP_TOKEN = $result['result']['app_token'];
					$this->TRACK_ID = $result['result']['track_id'];
					
					fclose($fp);
				} 
			}
			else
				echo "Accès au token $TokenFile interdit";
		}
		else
		{
			$data = file_get_contents($TokenFile);
			if ( $data !== FALSE) 
			{
				$data = explode(',',$data);
				
				$this->APP_TOKEN = trim($data[0]);
				$this->TRACK_ID = trim($data[1]);
			}
		}
	}
	
	/**
	* Récupère le status d'accès
	*/
	public function _GetAuthStatus()
	{
		if (strcmp($this->TRACK_ID,"") != 0)
		{
			$appURL = "login/authorize/".$this->TRACK_ID;
			$response = $this->setURL($appURL)->get();
		}
		else
		{
			$this->_RequestAuth();
			if (strcmp($this->TRACK_ID,"") != 0)
			{
				$appURL = "login/authorize/".$this->TRACK_ID;
				$response = $this->setURL($appURL)->get();
			}
			else
				$response = array('success' => true, 'result' => array('status' => 'unknown'));
		}
		return $response;
	}
	
	/**
	* Récupère le token de la session
	*/
	public function _NewSession()
	{
		$appURL = "login/session/";
		$response = $this->_GetAuthStatus();

		if (strcmp($response['result']['status'],'granted') != 0)
		{
			$this->_RequestAuth();
			$response = $this->_GetAuthStatus();

			while (strcmp($response['result']['status'],'pending') == 0)
			{
				sleep(1);
				echo "<br />Attente d'autorisation pour l'application. Validez l'accès depuis l'afficheur de la Freebox Server.";
				$response = $this->_GetAuthStatus();
			}
			if (strcmp($response['result']['status'],'granted') != 0)
			{
				echo "Request access ".$response['result']['status']." !";
				exit;
			}
		}
		$password = $this->hmac_sha1($this->APP_TOKEN, $response['result']['challenge']);

		$appParams = array (
			"app_id" => $this->APP_ID,
			"app_version" => $this->APP_VERSION,
			"password" => $password
				);

		$response = $this->setURL($appURL)->post($appParams);

		$this->SESSION_TOKEN = $response['result']['session_token'];
	}
	
	/**
	* Récupère les droits d'accès
	*/
	public function _GetRights()
	{
		$result = $this->_NewSession();
		return $result['permissions'];
	}
	
	# allow magic acces : $freebox->API->method()
	public function __get($name){
		if(array_key_exists($name, $this->API))
			return $this->API[$name];
		else
			throw new Exception ("API $name doesn't exists");
	}
	
	public function setURL ($pUrl)
	{
		$this->URL = $this->BASE_URL.$pUrl;
		return $this;
	}
 
	public function get ($pParams = array())
	{
		return $this->_InterrogerAPI ($this->URL,'GET');
	}
 
	public function post ($pPostParams=array(), $pGetParams = array())
	{
    	return $this->_InterrogerAPI ($this->URL,'POST',$pPostParams);
	}
    
	public function put ($pPutParams = array())
	{
		return $this->_InterrogerAPI ($this->URL,'PUT',$pPutParams);
	}
    
	public function delete ($pDelParams = array())
	{
    	return $this->_InterrogerAPI ($this->URL,'DELETE',$pDelParams);
	}
    
	public function _createContext($pMethod, $pHeader = null, $pContent = null)
	{
		if (strcmp($this->SESSION_TOKEN, "") != 0)
			$auth = "\r\nX-Fbx-App-Auth: ".$this->SESSION_TOKEN."\r\n";
		else 
			$auth = null;
			$opts = array(
					'http'=>array(
                            'method'=>$pMethod,
                            'header'=>'Content-type: application/x-www-form-urlencoded' . $auth,   //application/x-www-form-urlencoded
								)
						);
		if ($pContent !== null)
		{
			if (is_array($pContent))
				$pContent = http_build_query($pContent);
			$opts['http']['content'] = $pContent;
		}
		return stream_context_create($opts);
	}
    
	public function _makeUrl($pParams)
	{
		return $this->URL
             .(strpos($this->URL, '?') ? '' : '?')
             .http_build_query($pParams);
	}
    
	public function _launch ($pUrl, $context)
	{
		if (($stream = fopen($pUrl, 'r', false, $context)) !== false)
		{
			$content = stream_get_contents($stream);
			$header = stream_get_meta_data($stream);
			fclose($stream);
			return array('content'=>$content, 'header'=>$header);
		}
		else
			return false;
    }
   
	public function _InterrogerAPI ($pUrl, $context, $Params = null)
	{
		$headers = array ('Content-type: application/x-www-form-urlencoded');
	
		if (strcmp($this->SESSION_TOKEN,null)!=0)
			$headers = array ('X-Fbx-App-Auth: '.$this->SESSION_TOKEN);

		// Initialisation de la connexion avec CURL.
		$ch = curl_init();
    
		curl_setopt($ch, CURLOPT_URL, $pUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, 0);
		
		if ($context === "DELETE")
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		
		if ($context === "POST")
		{
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($Params));
		}
					
		if ($context === "PUT")
		{
			/** use a max of 256KB of RAM before going to disk */
			$fp = fopen('php://temp/maxmemory:256000', 'w');
			if (!$fp) 
				die('could not open temp memory data');
			fwrite($fp, json_encode($Params));
			fseek($fp, 0); 

			curl_setopt($ch, CURLOPT_PUT, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
			curl_setopt($ch, CURLOPT_INFILE, $fp);
			curl_setopt($ch, CURLOPT_INFILESIZE, strlen(json_encode($Params)));
		}
		    
		$retour_curl = curl_exec($ch);
		curl_close($ch);
    
		// On essaye de décoder le retour JSON.
		$retour_json = json_decode( $retour_curl, true );
    
		// Gestion minimale des erreurs.
		if( $retour_json === false )
			throw new Exception("Erreur dans le retour JSON !");
		if( isset($retour_json['error']) ) 
			throw new Exception( json_encode($retour_json) );
			
		return $retour_json;
   }
   
	private function hmac_sha1($key, $data)
	{
		// Adjust key to exactly 64 bytes
		if (strlen($key) > 64) {
			$key = str_pad(sha1($key, true), 64, chr(0));
		}
		if (strlen($key) < 64) {
			$key = str_pad($key, 64, chr(0));
		}

		// Outter and Inner pad
		$opad = str_repeat(chr(0x5C), 64);
		$ipad = str_repeat(chr(0x36), 64);

		// Xor key with opad & ipad
		for ($i = 0; $i < strlen($key); $i++) 
		{
			$opad[$i] = $opad[$i] ^ $key[$i];
			$ipad[$i] = $ipad[$i] ^ $key[$i];
		}
		return sha1($opad.sha1($ipad.$data, true));
	}
	
	public function GetListClasses()
	{
		$dirname = './API/';
		$dir = opendir($dirname); 

		while($file = readdir($dir)) 
		{
			if($file != '.' && $file != '..' && !is_dir($dirname.$file) )
			{
				$classe = substr($file,0,strlen($file) - 4);
				$array[] = $classe;	
			}
		}
		closedir($dir);
		return $array;
	}
	
	public function write_ini_file($assoc_arr, $path, $has_sections=FALSE, $initial_content = "") 
	{ 
		$content = $initial_content; 
		if ($has_sections) 
		{ 
			foreach ($assoc_arr as $key=>$elem) 
			{ 
				$content .= "\n[".$key."]\n"; 
				if (isset($elem))
				foreach ($elem as $key2=>$elem2) 
				{ 
					if(is_array($elem2)) 
					{ 
						for($i=0;$i<count($elem2);$i++) 
						{ 
							$content .= $key2."[] = \"".$elem2[$i]."\"\n"; 
						} 
					} 
					else if($elem2=="") $content .= $key2." = \n"; 
					else $content .= $key2." = \"".$elem2."\"\n"; 
				} 
			} 
		} 
		else { 
			foreach ($assoc_arr as $key=>$elem) 
			{ 
				if(is_array($elem)) 
				{ 
					for($i=0;$i<count($elem);$i++) 
					{ 
						$content .= $key."[] = \"".$elem[$i]."\"\n";  //$key2
					} 
				} 
				else if($elem=="") $content .= $key." = \n";  //$key2
				else $content .= $key." = \"".$elem."\"\n";  //$key2
			} 
		} 

		if (!$handle = fopen($path, 'w')) 
		{ 
			return false; 
		} 
		if (!fwrite($handle, $content)) 
		{ 
			fclose($handle);
			return false; 
		} 
		fclose($handle); 
		return true; 
	}
	
	public function convert_truefalse_to_boolean($var)
	{
		if ($var === true) return 1;
		if ($var === false) return 0;
		return $var;
	}
	
	public function convert_truefalse_to_text($var)
	{
		if ($var === true) return "true";
		if ($var === false) return "false";
		return $var;
	}
	
	/* Retourne tous les paramètres de la freebox dans un fichier XML */
	public function config_to_XML()
	{
		$array_classes = $this->GetListClasses();
	
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
			$Classe_Elt = $doc->createElement($class_name);
				
			$class_methods = get_class_methods($class_name);
			$class = new $class_name($this);
			foreach ($class_methods as $method_name) 
			{
				if (substr($method_name,0,3) === "Get")
				{
					$r = new ReflectionMethod($class_name, $method_name);
					$params = $r->getNumberOfParameters();
					if ($params == 0)
					{
						$datas = call_user_func(array($class, $method_name));
						$Method_Elt = $doc->createElement($method_name);
						DomArrayToXml($datas["result"], $doc, $Method_Elt);
						$Classe_Elt->appendChild($Method_Elt);
					}
				}
				$racine->appendChild($Classe_Elt);
			}
		}	
		$doc->appendChild($racine);
		return $doc->saveXML();
	}
	
	public function DisplayResult($json,$action = "")
	{
		if ($json["success"] == true)
		{
			echo "$action OK !";
			echo "<br />Données supplémentaires retournées par la Freebox : ";
			$keys = array_keys($json["result"]);  
			$i = 0;
			foreach ($json["result"] as $value)
			{
				$value = $this->convert_truefalse_to_text(utf8_decode($value));
				echo "<br />".$keys[$i]."= $value";
				$i++;
			}
		}
		else
		{
			echo "Erreur lors de l'exécution de la commande $action.";
			echo "<br />Le message d'erreur est le suivant : ".utf8_decode($json["msg"])." (".utf8_decode($json["error_code"]).")";
		}
	
	}
}


/**
* Inclut la classe à partir d'un fichier
* @param string Nom de la classe à inclure
*/
function __autoload($classname) 
{
	$filename = "./API/". $classname .".php";
	include_once($filename);
}

/**
* Converti (récursivement) un array en XML (via DOM)
*/
function DomArrayToXml($array, $dom_doc, $node)
{
	$array_special_char = array(true, false, "<", ">", "&", "'", "\"");
	$array_replace_char = array(1,0,"&lt;",	"&gt;", "&amp;","&apos;", "&quot;");
	
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
				//if ($item === true) $item = 1;
				//if ($item === false) $item = 0;
				$encoded_item = str_replace ($array_special_char, $array_replace_char,$item);
				$element = $dom_doc->createElement($key,utf8_encode($encoded_item));	
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