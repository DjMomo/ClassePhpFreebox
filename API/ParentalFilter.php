<?php

/********
* API Parental Filter - Freebox OS
* http://dev.freebox.fr/sdk/os/#parental-filter
*
* http://www.github.com/DjMomo/ClassePhpFreebox
********/

class ParentalFilter
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
	
	public function GetParentalFilterConfig()
	{
		// Get the ParentalFilterConfig
		// http://dev.freebox.fr/sdk/os/parental/#get-parental-filter-config
		$appURL = "parental/config/";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateParentalFilterConfig($array_config)
	{
		// Update the ParentalFilterConfig
		// http://dev.freebox.fr/sdk/os/parental/#update-parental-filter-config
		$appURL = "parental/config/";
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function GetAllParentalFilters()
	{
		// Returns the collection of all ParentalFilter filters
		// http://dev.freebox.fr/sdk/os/parental/#retrieve-a-parental-filter
		$appURL = "parental/filter/";
		return $this->GetDatas($appURL);
	}
	
	public function GetParentalFilter($id)
	{
		// Returns the ParentalFilter task with the given id
		// http://dev.freebox.fr/sdk/os/parental/#retrieve-a-parental-filter
		$appURL = "parental/filter/".$id;
		return $this->GetDatas($appURL);
	}
	
	public function DeleteParentalFilter($id)
	{
		// Delete the ParentalFilter task with the given id
		// http://dev.freebox.fr/sdk/os/parental/#delete-a-parental-filter
		$appURL = "parental/filter/".$id;
		return $this->DeleteDatas($appURL);
	}
	
	public function UpdateParentalFilter($id,$array_config)
	{
		// Update the ParentalFilter with the given id
		// http://dev.freebox.fr/sdk/os/parental/#update-a-parental-filter
		$appURL = "parental/filter/".$id;
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function AddParentalFilter($array_config)
	{
		// Add a ParentalFilter
		// http://dev.freebox.fr/sdk/os/parental/#add-a-parental-filter
		$appURL = "parental/filter/";
		return $this->PostDatas($appURL,$array_config);
	}
	
	public function GetParentalFilterPlanning($id)
	{
		// Returns the ParentalFilterPlanning for the filter with the given id
		// http://dev.freebox.fr/sdk/os/parental/#get-a-parental-filter-planning
		$appURL = "parental/filter/".$id."/planning";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateParentalFilterPlanning($id,$array_config)
	{
		// Update the ParentalFilterPlanning with the given id
		// http://dev.freebox.fr/sdk/os/parental/#update-a-parental-filter-planning
		$appURL = "parental/filter/".$id."/planning";
		return $this->PutDatas($appURL,$array_config);
	}
}
?>
