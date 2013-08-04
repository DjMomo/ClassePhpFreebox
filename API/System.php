<?php

/********
* API Système - Freebox OS
*
* http://www.github.com/DjMomo/ClassePhpFreebox
********/

class System
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
	
	public function GetSystemStatus()
	{
		// without documentation
		$appURL = "system/";
		return $this->GetDatas($appURL);
	}
	
	public function Reboot()
	{
		// without documentation
		$appURL = "system/reboot/";
		return $this->PostDatas($appURL);
	}
}

?>