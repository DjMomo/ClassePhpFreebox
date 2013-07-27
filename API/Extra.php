<?php

/********
* API Freebox OS
* Liste de méthodes effectuants plusieurs opérations en un seul appel
*
* http://www.github.com/DjMomo/apifreebox
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
		$response = $this->apifreebox->setURL($appURL)->post($appParams);
	}
	
	private function PutDatas($appURL, $appParams = null)
	{
		$response = $this->apifreebox->setURL($appURL)->put($appParams);
	}
	
	private function DeleteDatas($appURL, $appParams = null)
	{
		$response = $this->apifreebox->setURL($appURL)->delete($appParams);
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
	
}
?>
