<?php

/********
* API Calls Contacts - Freebox OS
* http://dev.freebox.fr/sdk/os/#calls-contacts
*
* http://www.github.com/DjMomo/ClassePhpFreebox
********/

class Calls_Contacts
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
	
	public function GetCallsList()
	{
		// Returns the collection of all CallEntry call entries
		// http://dev.freebox.fr/sdk/os/call/#list-every-calls
		$appURL = "call/log/";
		return $this->GetDatas($appURL);
	}
	
	public function GetCallEntry($id)
	{
		// Returns the CallEntry task with the given id
		// http://dev.freebox.fr/sdk/os/call/#access-a-given-call-entry
		$appURL = "call/log/".$id;
		return $this->GetDatas($appURL);
	}
	
	public function DeleteCallEntry($id)
	{
		// Deletes the CallEntry with the given id
		// http://dev.freebox.fr/sdk/os/call/#delete-a-call
		$appURL = "call/log/".$id;
		return $this->DeleteDatas($appURL);
	}
	
	public function UpdateCallEntry($id, $array_datas)
	{
		// Updates the CallEntry task with the given id
		// http://dev.freebox.fr/sdk/os/call/#update-a-call-entry
		$appURL = "call/log/".$id;
		return $this->PutDatas($appURL,$array_datas);
	}
	
	public function GetContactsList()
	{
		// Returns the collection of all ContactEntry
		// http://dev.freebox.fr/sdk/os/contacts/#get-a-list-of-contacts
		$appURL = "contact/";
		return $this->GetDatas($appURL);
	}
	
	public function GetContactEntry($id)
	{
		// Returns the ContactEntry with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#access-a-given-contact-entry
		$appURL = "contact/".$id;
		return $this->GetDatas($appURL);
	}
	
	public function CreateContact($array_contact)
	{
		// Creates a new ContactEntry
		// http://dev.freebox.fr/sdk/os/contacts/#create-a-contact
		$appURL = "contact/";
		return $this->PostDatas($appURL,$array_contact);
	}
	
	public function DeleteContactEntry($id)
	{
		// Deletes the ContactEntry with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#delete-a-contact
		$appURL = "contact/".$id;
		return $this->DeleteDatas($appURL);
	}
	
	public function UpdateContactEntry($id,$array_contact)
	{
		// Updates the ContactEntry with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#update-a-contact-entry
		$appURL = "contact/".$id;
		return $this->PutDatas($appURL,$array_contact);
	}
	
	private function GetAllContactObj($id,$object)
	{
		// Returns the collection of all Contactxxx for a given contact
		// http://dev.freebox.fr/sdk/os/contacts/#get-the-list-of-numbers-for-a-given-contact
		$appURL = "contact/".$id."/".$object;
		return $this->GetDatas($appURL);
	}
		
	public function GetAllContactNumbers($id)
	{
		// Returns the collection of all ContactNumber for a given contact
		// http://dev.freebox.fr/sdk/os/contacts/#get-the-list-of-numbers-for-a-given-contact
		return $this->GetAllContactObj($id,"numbers");
	}
	
	public function GetAllContactAddresses($id)
	{
		// Returns the collection of all ContactAdresse for a given contact
		// http://dev.freebox.fr/sdk/os/contacts/#get-the-list-of-numbers-for-a-given-contact
		return $this->GetAllContactObj($id,"addresses");
	}
	
	public function GetAllContactUrls($id)
	{
		// Returns the collection of all ContactUrl for a given contact
		// http://dev.freebox.fr/sdk/os/contacts/#get-the-list-of-numbers-for-a-given-contact
		return $this->GetAllContactObj($id,"urls");
	}
	
	public function GetAllContactEmails($id)
	{
		// Returns the collection of all ContactEmail for a given contact
		// http://dev.freebox.fr/sdk/os/contacts/#get-the-list-of-numbers-for-a-given-contact
		return $this->GetAllContactObj($id,"emails");
	}
	
	private function GetContactObj($object,$id)
	{
		// Returns the ContactObject with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#access-a-given-contact-number
		$appURL = $object."/".$id;
		return $this->GetDatas($appURL);
	}
		
	public function GetContactNumber($id)
	{
		// Returns the ContactNumber with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#access-a-given-contact-number
		return $this->GetContactObj("number",$id);
	}
	
	public function GetContactAddress($id)
	{
		// Returns the ContactAddress with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#access-a-given-contact-number
		return $this->GetContactObj("address",$id);
	}
	
	public function GetContactUrl($id)
	{
		// Returns the ContactUrl with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#access-a-given-contact-number
		return $this->GetContactObj("url",$id);
	}
	
	public function GetContactEmail($id)
	{
		// Returns the ContactEmail with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#access-a-given-contact-number
		return $this->GetContactObj("email",$id);
	}
	
	private function CreateContactObj($object,$array_contact)
	{
		// Create the ContactObject
		// http://dev.freebox.fr/sdk/os/contacts/#create-a-contact-number
		$appURL = $object."/";
		return $this->PostDatas($appURL,$array_contact);
	}
		
	public function CreateContactNumber($array_contact)
	{
		// Create the ContactNumber
		// http://dev.freebox.fr/sdk/os/contacts/#create-a-contact-number
		return $this->CreateContactObj("number",$array_contact);
	}
	
	public function CreateContactAddress($array_contact)
	{
		// Create the ContactAddress
		// http://dev.freebox.fr/sdk/os/contacts/#create-a-contact-number
		return $this->CreateContactObj("address",$array_contact);
	}
	
	public function CreateContactUrl($array_contact)
	{
		// Create the ContactUrl
		// http://dev.freebox.fr/sdk/os/contacts/#create-a-contact-number
		return $this->CreateContactObj("url",$array_contact);
	}
	
	public function CreateContactEmail($array_contact)
	{
		// Create the ContactEmail
		// http://dev.freebox.fr/sdk/os/contacts/#create-a-contact-number
		return $this->CreateContactObj("email",$array_contact);
	}
	
	private function DeleteContactObj($object,$id)
	{
		// Delete the ContactObject with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#delete-a-contact-number
		$appURL = $object."/".$id;
		return $this->DeleteDatas($appURL);
	}
		
	public function DeleteContactNumber($id)
	{
		// Delete the ContactNumber with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#delete-a-contact-number
		return $this->DeleteContactObj("number",$id);
	}
	
	public function DeleteContactAddress($id)
	{
		// Delete the ContactAddress with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#delete-a-contact-number
		return $this->DeleteContactObj("address",$id);
	}
	
	public function DeleteContactUrl($id)
	{
		// Delete the ContactUrl with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#delete-a-contact-number
		return $this->DeleteContactObj("url",$id);
	}
	
	public function DeleteContactEmail($id)
	{
		// Delete the ContactEmail with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#delete-a-contact-number
		return $this->DeleteContactObj("email",$id);
	}
	
	private function UpdateContactObj($object,$id,$array_contact)
	{
		// Updates the ContactObject with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#update-a-contact-number
		$appURL = $object."/".$id;
		return $this->PutDatas($appURL,$array_contact);
	}
		
	public function UpdateContactNumber($id,$array_contact)
	{
		// Updates the ContactNumber with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#update-a-contact-number
		return $this->UpdateContactObj("number",$id,$array_contact);
	}
	
	public function UpdateContactAddress($id,$array_contact)
	{
		// Updates the ContactAddress with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#update-a-contact-number
		return $this->UpdateContactObj("address",$id,$array_contact);
	}
	
	public function UpdateContactUrl($id,$array_contact)
	{
		// Updates the ContactUrl with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#update-a-contact-number
		return $this->UpdateContactObj("url",$id,$array_contact);
	}
	
	public function UpdateContactEmail($id,$array_contact)
	{
		// Updates the ContactEmail with the given id
		// http://dev.freebox.fr/sdk/os/contacts/#update-a-contact-number
		return $this->UpdateContactObj("email",$id,$array_contact);
	}
}
?>
