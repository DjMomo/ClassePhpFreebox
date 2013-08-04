<?php

/********
* API Freebox OS
* Liste de méthodes effectuants plusieurs opérations en un seul appel
*
* http://www.github.com/DjMomo/ClassePhpFreebox
********/

class Extra 
{
	protected $apifreebox;
	
	public function __construct($apifreebox)
	{
		$this->apifreebox = $apifreebox;
	}
	
	private function GetDatas($appURL)
	{
		return $this->apifreebox->setURL($appURL)->get();
	}
	
	private function PostDatas($appURL, $appParams = null)
	{
		return $this->apifreebox->setURL($appURL)->post($appParams);
	}
	
	private function PutDatas($appURL, $appParams = null)
	{
		return $this->apifreebox->setURL($appURL)->put($appParams);
	}
	
	private function DeleteDatas($appURL, $appParams = null)
	{
		return $this->apifreebox->setURL($appURL)->delete($appParams);
	}
	
	public function GetLANInformations()
	{
		// Fonction qui retourne la liste de toutes les interfaces, de tous les hotes du LAN ainsi que leurs informations
		
		// Instantation de la classe PHP de la partie Configuration
		$configuration = new Configuration($this->apifreebox);
		
		$LanInterfaces =  $configuration->GetLANInterfaces();
		
		$i = 0;
		$j = 0;
		foreach($LanInterfaces as $Interfaces)
		{
			$j = $i - 1;
			if ($i > 0)
			{
				foreach ($Interfaces as $Interface)
				$array_hosts[$j] = $configuration->GetLANHosts($Interface["name"]);
			}
			$i++;
		}
		return $array_hosts;
	
	}
	
	public function RestoreConfiguration($filename)
	{
		$tab = file($filename);
		$error = 0;
		$warn = 0;
		
		// Désérialisation
		$data = unserialize(urldecode($tab[0]));

		echo "<br />Début de mise à jour de la configuration";
		
		foreach ($data as $section => $array_config)
		{
			echo "<br />$section : ";
			switch ($section)
			{
				case "ConnectionConfiguration": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					$result = $configuration->UpdateConnnectionConfiguration($array_config); 
					$this->is_success($error,$result);
					break;   
				}
				case "ConnnectionIpv6Configuration": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					$result = $configuration->UpdateConnnectionIpv6Configuration($array_config); 
					$this->is_success($error,$result);
					break;   
				}
				case "DDNSConfig": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					foreach ($array_config as $provider => $array_config_provider)
					{
						echo "<br />&nbsp;&nbsp;* $provider : ";
						$result = $configuration->UpdateConnnectionDDNSConfiguration($provider, $array_config_provider);
						$this->is_success($error,$result);
					}
					break;
				}
				case "DhcpConfig": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					$result = $configuration->UpdateDhcpConfig($array_config); 
					$this->is_success($error,$result);
					break;  
				}
				case "DhcpStaticLeases": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					$result = $configuration->AddDhcpStaticLeases($array_config); 
					$this->is_success($error,$result);
					break;  
				}
				case "FtpConfig": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					$result = $configuration->UpdateFtpConfig($array_config); 
					$this->is_success($error,$result);
					break;  
				}
				case "DmzConfig": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					$result = $configuration->UpdateDmzConfig($array_config); 
					$this->is_success($error,$result);
					break;  
				}
				case "PortForwardingConfig": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					foreach ($array_config as $array_config_port)
					{
						echo "<br />&nbsp;&nbsp;* Port ".$array_config_port["lan_port"]."/".$array_config_port["ip_proto"]." : ";
						$result = $configuration->AddPortForwarding($array_config_port);
						$this->is_success($error,$result);
					}
					break;
				}
				case "UPnPIGDConfig": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					$result = $configuration->UpdateUpnpIgdConfig($array_config); 
					$this->is_success($error,$result);
					break;  
				}
				case "LcdConfig": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					$result = $configuration->UpdateLcdConfig($array_config); 
					$this->is_success($error,$result);
					break;  
				}
				case "SambaConfig": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					$result = $configuration->UpdateSambaConfig($array_config); 
					$this->is_success($error,$result);
					break;  
				}
				case "AfpConfig": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					$result = $configuration->UpdateAfpConfig($array_config); 
					$this->is_success($error,$result);
					break;  
				}
				case "UPnPAVConfig": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					$result = $configuration->UpdateUpnpAvConfig($array_config); 
					$this->is_success($error,$result);
					break;  
				}
				case "SwitchPortConfig": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					foreach ($array_config as $array_config_port)
					{
						echo "<br />&nbsp;&nbsp;* Switch Port ".$array_config_port["id"]." : ";
						$result = $configuration->UpdatePortConfig($array_config_port["id"],$array_config_port);
						$this->is_success($error,$result);
					}
					break;
				}
				case "WifiConfig": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					$result = $configuration->UpdateWifiConfig($array_config); 
					$this->is_success($error,$result);
					break;  
				}
				case "WifiMacFilter": 
				{ 
					$configuration = new Configuration($this->apifreebox); 
					foreach ($array_config as $array_config_filter)
					{
						echo "<br />&nbsp;&nbsp;* Filter ".$array_config_filter["id"]." : ";
						$result = $configuration->UpdateMacFilter($array_config_filter["id"],$array_config_filter);
						$this->is_success($error,$result);
					}
					break;
				}
				case "ParentalFilterConfig": 
				{ 
					$parentalfilter = new ParentalFilter($this->apifreebox); 
					$result = $parentalfilter->UpdateParentalFilterConfig($array_config); 
					$this->is_success($error,$result);
					break;  
				}
				case "ParentalFilter": 
				{ 
					$parentalfilter = new ParentalFilter($this->apifreebox); 
					foreach ($array_config as $array_config_filter)
					{
						echo "<br />&nbsp;&nbsp;* Filter ".$array_config_filter["rule"]["id"]." : ";
						$result = $parentalfilter->AddParentalFilter($array_config_filter["rule"]);
						$this->is_success($error,$result);
						if ($result["success"] === true)
							$id = $result["result"]["id"];
						echo "<br />&nbsp;&nbsp;* Planning : ";
						$result = $parentalfilter->UpdateParentalFilterPlanning($id,$array_config_filter["planning"]);
						$this->is_success($error,$result);
					}
					break;
				}
				case "Contacts": 
				{ 
					$calls_contacts = new Calls_Contacts($this->apifreebox); 
					foreach ($array_config as $array_contact)
					{
						var_dump($array_contact);
						echo "<br />&nbsp;&nbsp;* ".$array_contact["display_name"]." (".$array_contact["first_name"]." ".$array_contact["last_name"].") : ";
						$result = $calls_contacts->CreateContact($array_contact); 
						$this->is_success($error,$result);
					}
					break;  
				}
			}
			
		
		
		}
		echo "<br />Terminé avec $error erreur(s) !";
		echo "<br />Terminez la restauration de la configuration en saisissant les mots de passe suivants ";
	
	}
	
	private function is_success (&$error,$result)
	{
		if ($result["success"] !== true)
		{
			$error ++;
			echo "<font color=\"red\"><b>NOK</b></font> : ".utf8_encode($result["msg"])." (".utf8_encode($result["error"]).")";
		}
		else
			echo "<font color=\"green\">OK</font>";
	}
	
	public function SaveConfiguration($filename,$debug = false)
	{
		// Partie Configuration
		// Instantation de la classe PHP de la partie Configuration
		$configuration = new Configuration($this->apifreebox);
			
		$result = $configuration->GetConnnectionConfiguration();
		$array_keys = array("ping","remote_access","remote_access_port","wol","adblock","allow_token_request");
		if ($result["result"] !== NULL)
			$obj["ConnectionConfiguration"] = $result["result"];
		
		$result = $configuration->GetConnnectionIpv6Configuration();
		if ($result["result"] !== NULL)
			$obj["ConnnectionIpv6Configuration"] = $result["result"];
		
		$providers = array("ovh","dyndns","noip");
		foreach ($providers as $provider)
		{
			$result = $configuration->GetConnnectionDDNSConfiguration($provider);
			if ($result["result"] !== NULL)
				$array_prov["$provider"] = $result["result"];
		}
		$obj["DDNSConfig"] = $array_prov;
		
		$result = $configuration->GetDhcpConfig();
		$array_keys = array("enabled","sticky_assign","ip_range_start","ip_range_end","always_broadcast","dns");
		if ($result["result"] !== NULL)
			$obj["DhcpConfig"] = $result["result"];
		
		$result = $configuration->GetDhcpStaticLeases();
		$array_keys = array("id","mac","comment","ip");
		if ($result["result"] !== NULL)
			$obj["DhcpStaticLeases"] = $result["result"];
		
		$result = $configuration->GetFtpConfig();
		if ($result["result"] !== NULL)
			$obj["FtpConfig"] = $result["result"];
		
		$result = $configuration->GetDmzConfig();
		if ($result["result"] !== NULL)
			$obj["DmzConfig"] = $result["result"];
			
		$result = $configuration->GetListPortForwarding();
		if ($result["result"] !== NULL)
			$obj["PortForwardingConfig"] = $result["result"];
				
		$result = $configuration->GetUpnpIgdConfig();
		if ($result["result"] !== NULL)
			$obj["UPnPIGDConfig"] = $result["result"];
		
		$result = $configuration->GetLcdConfig();
		if ($result["result"] !== NULL)
			$obj["LcdConfig"] = $result["result"];
		
		$result = $configuration->GetSambaConfig();
		if ($result["result"] !== NULL)
			$obj["SambaConfig"] = $result["result"];
		
		$result = $configuration->GetAfpConfig();
		if ($result["result"] !== NULL)
			$obj["AfpConfig"] = $result["result"];
		
		$result = $configuration->GetUpnpAvConfig();
		if ($result["result"] !== NULL)
			$obj["UPnPAVConfig"] = $result["result"];
		
		$result = $configuration->GetSwitchStatus();
		if ($result["result"] !== NULL)
		{
			foreach ($result["result"] as $port)
			{
				$id = $port["id"];
				$result = $configuration->GetPortConfig($id);
				$array_keys = array("duplex","speed");
				if ($result["result"] !== NULL)
					$array_sw["$id"] = $result["result"];
			}
			$obj["SwitchPortConfig"] = $array_sw;
		}
				
		$result = $configuration->GetWifiConfig();
		$array_keys = array("enabled","ssid","hide_ssid","encryption","key","mac_filter","channel","ht_mode");
		if ($result["result"] !== NULL)
			$obj["WifiConfig"] = $result["result"];
		
		$result = $configuration->GetMacFilterList();
		if ($result["result"] !== NULL)
		{
			foreach ($result["result"] as $filter)
			{
				$id = $filter["id"];
				$result = $configuration->GetMacFilter($id);
				$array_keys = array("id","mac","comment","type");
				if ($result["result"] !== NULL)
					$array_fi["$id"] = $result["result"];
			}
			$obj["WifiMacFilter"] = $array_fi;		
		}
			
		// Partie Filtre Parental
		// Instantation de la classe PHP de la partie Filtre Parental
		$parentalfilter = new ParentalFilter($this->apifreebox);
		
		$result = $parentalfilter->GetParentalFilterConfig();
		if ($result["result"] !== NULL)
			$obj["ParentalFilterConfig"] = $result["result"];
			
		$result = $parentalfilter->GetAllParentalFilters();
		/*if ($result["result"] !== NULL)
			$obj["ParentalFilter"] = $result["result"];*/
		if ($result["result"] !== NULL)
		{
			//var_dump($result);
			foreach ($result["result"] as $parentalfilterplanning)
			{
				$id = $parentalfilterplanning["id"];
				$result = $parentalfilter->GetParentalFilter($id);
				if ($result["result"] !== NULL)
					$array_pf["$id"]["rule"] = $result["result"];
				$result = $parentalfilter->GetParentalFilterPlanning($id);
				if ($result["result"] !== NULL)
					$array_pf["$id"]["planning"] = $result["result"];
			}
			$obj["ParentalFilter"] = $array_pf;
		}
	
		// Partie Contacts
		// Instantation de la classe PHP de la partie Contact
		$callscontacts = new Calls_Contacts($this->apifreebox);
	
		$result = $callscontacts->GetContactsList();
		if ($result["result"] !== NULL)
			$obj["Contacts"] = $result["result"];
		
		if ($debug !== true)
		{
			// Sauvegarde du fichier
			$var = urlencode(serialize($obj));
			$fp = fopen($filename, 'w');
			fputs($fp, $var);
			fclose($fp);
		}
		else
			var_dump($obj);
	}
	
	private function unflat($array) 
	{
		$prefix = '@';
		$arr = array();
		$parent_key = "";
			
		foreach ($array as $key => $value)
		{
			echo "<br />On traite $key / $value";
			if (((strpos ($key,$prefix)) !== false) && (!is_array($value)))
			{
				echo "<br />on casse $key";
				$array_key = explode($prefix,$key);
				$tmp = &$arr;
				foreach ($array_key as $segment) 
				{
					$tmp[$segment] = array();
					$tmp = &$tmp[$segment];
				}
				$tmp = $val;
				$new_array[$parent_key] = $tmp;
			}
			elseif (is_array($value))
			{
				$parent_key = $key;
				$new_array[$parent_key] = $this->unflat($value);
			}
			else
				$new_array[$parent_key][$key] = $value;
		}
		
		return ($new_array);
	}
	
	private function flatten($array, $array_keys = array("all"), $prefix = '') 
	{
		if (isset($array))
		{
			$result = array();
			if (is_array($array))
			{
				foreach($array as $key=>$value) 
				{
					if(is_array($value)) 
						$result = $result + $this->flatten($value, $array_keys, $prefix . $key . '@');
					else		
					{
						if ((in_array($key,$array_keys)) || (in_array("all",$array_keys)) || is_int($key))
							$result[$prefix . $key] = $this->format($value);
					}
				}
			}
			else
			{
				echo "------------------------------------";
					$result = $this->format($array);
			}
			return $result;
		}
	}
	
	private function format($value)
	{
		if ($value === true)
			return "1";
		if ($value === false)
			return "0";
		if (is_null($value)) 
			return "";
		return $value;
	}
	
	
}
?>
