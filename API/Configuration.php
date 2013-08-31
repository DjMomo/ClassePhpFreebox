<?php

/********
* API Configuration - Freebox OS
* http://dev.freebox.fr/sdk/os/#configuration
*
* http://www.github.com/DjMomo/ClassePhpFreebox
********/

class Configuration 
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
	
	public function GetConnnectionStatus()
	{
		// http://dev.freebox.fr/sdk/os/connection/#get-the-current-connection-status
		$appURL = "connection/";
		return $this->GetDatas($appURL);
	}
	
	public function GetConnnectionConfiguration()
	{
		// http://dev.freebox.fr/sdk/os/connection/#get-the-current-connection-configuration
		$appURL = "connection/config/";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateConnnectionConfiguration($array_config)
	{
		// http://dev.freebox.fr/sdk/os/connection/#update-the-connection-configuration
		$appURL = "connection/config/";
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function GetConnnectionIpv6Configuration()
	{
		// http://dev.freebox.fr/sdk/os/connection/#get-the-current-ipv6-connection-configuration
		$appURL = "connection/ipv6/config/";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateConnnectionIpv6Configuration($array_config)
	{
		// http://dev.freebox.fr/sdk/os/connection/#update-the-ipv6-connection-configuration
		$appURL = "connection/ipv6/config/";
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function GetConnnectionxDSLStatus()
	{
		// http://dev.freebox.fr/sdk/os/connection/#get-the-current-xdsl-infos
		$appURL = "connection/xdsl/";
		return $this->GetDatas($appURL);
	}
	
	public function GetConnnectionFFTHStatus()
	{
		// http://dev.freebox.fr/sdk/os/connection/#get-the-current-ftth-status
		$appURL = "connection/ffth/";
		return $this->GetDatas($appURL);
	}
	
	public function GetConnnectionDDNSStatus($provider)
	{
		// http://dev.freebox.fr/sdk/os/connection/#get-the-status-of-a-dyndns-service
		$appURL = "connection/ddns/".$provider."/status/";
		return $this->GetDatas($appURL);
	}

	public function GetConnnectionDDNSConfiguration($provider)
	{
		// http://dev.freebox.fr/sdk/os/connection/#get-the-config-of-a-dyndns-service
		$appURL = "connection/ddns/".$provider."/";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateConnnectionDDNSConfiguration($provider,$array_config)
	{
		// http://dev.freebox.fr/sdk/os/connection/#set-the-config-of-a-dyndns-service
		$appURL = "connection/ddns/".$provider."/";
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function GetLANConfig()
	{
		// http://dev.freebox.fr/sdk/os/lan/#get-the-current-lan-configuration
		$appURL = "lan/config/";
		return $this->GetDatas($appURL);
	}
	
	public function GetLANInterfaces()
	{
		// http://dev.freebox.fr/sdk/os/lan/#getting-the-list-of-browsable-lan-interfaces
		$appURL = "lan/browser/interfaces/";
		return $this->GetDatas($appURL);
	}
	
	public function GetLANHosts($interface)
	{
		// http://dev.freebox.fr/sdk/os/lan/#getting-the-list-of-hosts-on-a-given-interface
		$appURL = "lan/browser/".$interface."/";
		return $this->GetDatas($appURL);
	}
	
	public function GetLANHostsInformation($interface,$hostid)
	{
		// http://dev.freebox.fr/sdk/os/lan/#getting-an-host-information
		$appURL = "lan/browser/".$interface."/".$hostid."/";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateLANHostsInformation($interface,$hostid)
	{
		// http://dev.freebox.fr/sdk/os/lan/#updating-an-host-information
		$appURL = "lan/browser/".$interface."/".$hostid."/";
		return $this->PutDatas($appURL);
	}
	
	public function SendWolPacket($interface,$mac,$password = null)
	{
		// http://dev.freebox.fr/sdk/os/lan/#send-wake-ok-lan-packet-to-an-host
		$appURL = "lan/wol/".$interface."/";
		$appParams = array(
						"mac" => $mac,
						"password" => $password
						);
		return $this->PostDatas($appURL, $appParams);
	}
	
	public function GetFreeplugsNetwork()
	{
		// http://dev.freebox.fr/sdk/os/freeplug/#get-the-current-freeplugs-networks
		$appURL = "freeplug/";
		return $this->GetDatas($appURL);
	}
	
	public function GetFreeplugInformation($id)
	{
		// http://dev.freebox.fr/sdk/os/freeplug/#get-a-particular-freeplug-information
		$appURL = "freeplug/".$id."/";
		return $this->GetDatas($appURL);
	}
	
	public function ResetFreeplug($id)
	{
		// http://dev.freebox.fr/sdk/os/freeplug/#reset-a-freeplug
		$appURL = "freeplug/".$id."/reset/";
		return $this->PostDatas($appURL);
	}
	
	public function GetDhcpConfig()
	{
		// Returns the current DhcpConfig
		// http://dev.freebox.fr/sdk/os/dhcp/#get-the-current-dhcp-configuration
		$appURL = "dhcp/config/";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateDhcpConfig($array_config)
	{
		// Update the current DhcpConfig
		// http://dev.freebox.fr/sdk/os/dhcp/#update-the-current-dhcp-configuration
		$appURL = "dhcp/config/";
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function GetDhcpStaticLeases()
	{
		// Get the list of DhcpStaticLeases
		// http://dev.freebox.fr/sdk/os/dhcp/#get-the-list-of-dhcp-static-leases
		$appURL = "dhcp/static_lease/";
		return $this->GetDatas($appURL);
	}
	
	public function GetSpecificDhcpStaticLeases($id)
	{
		// Get a given DhcpStaticLease
		// http://dev.freebox.fr/sdk/os/dhcp/#get-a-given-dhcp-static-lease
		$appURL = "dhcp/static_lease/".$id;
		return $this->GetDatas($appURL);
	}
	
	public function UpdateDhcpStaticLeases($id, $array_config)
	{
		// Update a given DhcpStaticLease
		// http://dev.freebox.fr/sdk/os/dhcp/#update-dhcp-static-lease
		$appURL = "dhcp/static_lease/".$id;
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function DeleteDhcpStaticLeases($id)
	{
		// Delete a given DhcpStaticLease
		// http://dev.freebox.fr/sdk/os/dhcp/#delete-a-dhcp-static-lease
		$appURL = "dhcp/static_lease/".$id;
		return $this->DeleteDatas($appURL);
	}
	
	public function AddDhcpStaticLeases($array_config)
	{
		// Add a DhcpStaticLease
		// http://dev.freebox.fr/sdk/os/dhcp/#add-a-dhcp-static-lease
		$appURL = "dhcp/static_lease/";
		return $this->PostDatas($appURL,$array_config);
	}
	
	public function GetDhcpDynamicLeases()
	{
		// Get the list of DhcpDynamicLeases
		// http://dev.freebox.fr/sdk/os/dhcp/#get-the-list-of-dhcp-dynamic-leases
		$appURL = "dhcp/dynamic_lease/";
		return $this->GetDatas($appURL);
	}
	
	public function GetFtpConfig()
	{
		// Get the FtpConfig
		// http://dev.freebox.fr/sdk/os/ftp/#get-the-current-ftp-configuration
		$appURL = "ftp/config/";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateFtpConfig($array_config)
	{
		// Update the FtpConfig
		// http://dev.freebox.fr/sdk/os/ftp/#get-the-current-ftp-configuration
		$appURL = "ftp/config/";
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function GetDmzConfig()
	{
		// Get the DmzConfig
		// http://dev.freebox.fr/sdk/os/nat/#get-the-current-dmz-configuration
		$appURL = "fw/dmz/";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateDmzConfig($array_config)
	{
		// Update the DmzConfig
		// http://dev.freebox.fr/sdk/os/nat/#update-the-current-dmz-configuration
		$appURL = "fw/dmz/";
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function GetListPortForwarding()
	{
		// http://dev.freebox.fr/sdk/os/nat/#getting-the-list-of-port-forwarding
		$appURL = "fw/redir/";
		return $this->GetDatas($appURL);
	}
	
	public function GetSpecificPortForwarding($id)
	{
		// http://dev.freebox.fr/sdk/os/nat/#getting-a-specific-port-forwarding
		$appURL = "fw/redir/".$id;
		return $this->GetDatas($appURL);
	}
	
	public function UpdateSpecificPortForwarding($id,$array_config)
	{
		// Update a PortForwardingConfig properties
		// http://dev.freebox.fr/sdk/os/nat/#updating-a-port-forwarding
		$appURL = "fw/redir/".$id;
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function AddPortForwarding($array_config)
	{
		// Create a PortForwardingConfig
		// http://dev.freebox.fr/sdk/os/nat/#add-a-port-forwarding
		$appURL = "fw/redir/";
		return $this->PostDatas($appURL,$array_config);
	}
	
	public function DeleteSpecificPortForwarding($id)
	{
		// Delete a PortForwardingConfig
		// http://dev.freebox.fr/sdk/os/nat/#delete-a-port-forwarding
		$appURL = "fw/redir/".$id;
		return $this->DeleteDatas($appURL);
	}
	
	public function GetUpnpIgdConfig()
	{
		// Get the UPnPIGDConfig
		// http://dev.freebox.fr/sdk/os/igd/#get-the-current-upnp-igd-configuration
		$appURL = "upnpigd/config/";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateUpnpIgdConfig($array_config)
	{
		// Update the UPnPIGDConfig
		// http://dev.freebox.fr/sdk/os/igd/#update-the-upnp-igd-configuration
		$appURL = "upnpigd/config/";
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function GetUpnpIgdRedir()
	{
		// Get the list of UPnPRedir redirections
		// http://dev.freebox.fr/sdk/os/igd/#get-the-list-of-current-redirection
		$appURL = "upnpigd/redir/";
		return $this->GetDatas($appURL);
	}
	
	public function DeleteUpnpIgdRedir($id)
	{
		// Deletes the given UPnPRedir
		// http://dev.freebox.fr/sdk/os/igd/#delete-a-redirection
		$appURL = "upnpigd/redir/".$id;
		return $this->DeleteDatas($appURL);
	}
	
	public function GetLcdConfig()
	{
		// Get the LcdConfig
		// http://dev.freebox.fr/sdk/os/lcd/#get-the-current-lcd-configuration
		$appURL = "lcd/config/";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateLcdConfig($array_config)
	{
		// Update the LcdConfig
		// http://dev.freebox.fr/sdk/os/lcd/#update-the-lcd-configuration
		$appURL = "lcd/config/";
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function GetSambaConfig()
	{
		// Get the SambaConfig
		// http://dev.freebox.fr/sdk/os/network_share/#get-the-current-samba-configuration
		$appURL = "netshare/samba/";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateSambaConfig($array_config)
	{
		// Update the SambaConfig
		// http://dev.freebox.fr/sdk/os/network_share/#update-the-samba-configuration
		$appURL = "netshare/samba/";
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function GetAfpConfig()
	{
		// Get the AfpConfig
		// http://dev.freebox.fr/sdk/os/network_share/#get-the-current-afp-configuration
		$appURL = "netshare/afp/";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateAfpConfig($array_config)
	{
		// Update the AfpConfig
		// http://dev.freebox.fr/sdk/os/network_share/#update-the-afp-configuration
		$appURL = "netshare/afp/";
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function GetUpnpAvConfig()
	{
		// Get the UPnPAvConfig
		// http://dev.freebox.fr/sdk/os/upnpav/#get-the-current-upnp-av-configuration
		$appURL = "upnpav/config/";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateUpnpAvConfig($array_config)
	{
		// Update the UPnPAvConfig
		// http://dev.freebox.fr/sdk/os/upnpav/#update-the-upnp-av-configuration
		$appURL = "upnpav/config/";
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function GetSwitchStatus()
	{
		// Return the list of swith port status SwitchPortStatus
		// http://dev.freebox.fr/sdk/os/switch/#get-the-current-switch-status
		$appURL = "switch/status/";
		return $this->GetDatas($appURL);
	}
	
	public function GetPortConfig($id)
	{
		// Get the SwitchPortConfig for the given port id
		// http://dev.freebox.fr/sdk/os/switch/#get-a-port-configuration
		$appURL = "switch/port/".$id;
		return $this->GetDatas($appURL);
	}
	
	public function UpdatePortConfig($id,$array_config)
	{
		// Update the SwitchPortConfig for the given port id
		// http://dev.freebox.fr/sdk/os/switch/#update-a-port-configuration
		$appURL = "switch/port/".$id;
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function GetPortStats($id)
	{
		// Get the SwitchPortStats for the given port id
		// http://dev.freebox.fr/sdk/os/switch/#get-a-port-stats
		$appURL = "switch/port/".$id."/stats";
		return $this->GetDatas($appURL);
	}
	
	public function GetWifiStatus()
	{
		// Get the WifiStatus
		// http://dev.freebox.fr/sdk/os/wifi/#wi-fi-status-api
		$appURL = "wifi/";
		return $this->GetDatas($appURL);
	}
	
	public function GetWifiConfig()
	{
		// Get the WifiConfig
		// http://dev.freebox.fr/sdk/os/wifi/#get-the-current-wi-fi-configuration
		$appURL = "wifi/config/";
		return $this->GetDatas($appURL);
	}
	
	public function UpdateWifiConfig($array_config)
	{
		// Update the WifiConfig
		// http://dev.freebox.fr/sdk/os/wifi/#update-the-wi-fi-configuration
		$appURL = "wifi/config/";
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function ResetWifiConfig()
	{
		// Reset the WifiConfig to the factory defaults
		// http://dev.freebox.fr/sdk/os/wifi/#reset-the-wi-fi-configuration
		$appURL = "wifi/config/reset/";
		return $this->PostDatas($appURL);
	}
	
	public function GetWifiStationsList($bss_name)
	{
		// Get the list of WifiStation associated to the BSS
		// http://dev.freebox.fr/sdk/os/wifi/#get-wi-fi-stations-list
		$appURL = "wifi/stations/".$bss_name."/";
		return $this->GetDatas($appURL);
	}
	
	public function GetMacFilterList()
	{
		// Get the list of WifiMacFilter
		// http://dev.freebox.fr/sdk/os/wifi/#get-the-mac-filter-list
		$appURL = "wifi/mac_filter/";
		return $this->GetDatas($appURL);
	}
	
	public function GetMacFilter($id)
	{
		// Returns the requested WifiMacFilter properties
		// http://dev.freebox.fr/sdk/os/wifi/#getting-a-particular-mac-filter
		$appURL = "wifi/mac_filter/".$id;
		return $this->GetDatas($appURL);
	}
	
	public function UpdateMacFilter($id,$array_config)
	{
		// Update a WifiMacFilter properties
		// http://dev.freebox.fr/sdk/os/wifi/#updating-a-mac-filter
		$appURL = "wifi/mac_filter/".$id;
		return $this->PutDatas($appURL,$array_config);
	}
	
	public function DeleteMacFilter($id)
	{
		// Delete the WifiMacFilter with the given id
		// http://dev.freebox.fr/sdk/os/wifi/#delete-a-mac-filter
		$appURL = "wifi/mac_filter/".$id;
		return $this->DeleteDatas($appURL);
	}
	
	public function AddMacFilter($array_config)
	{
		// Crate a new the WifiMacFilter
		// http://dev.freebox.fr/sdk/os/wifi/#create-a-new-mac-filter
		$appURL = "wifi/mac_filter/";
		return $this->PostDatas($appURL,$array_config);
	}
	
	public function GetPhoneConfig()
	{
		// Get phone configuration
		// without documentation
		$appURL = "phone/config/";
		return $this->GetDatas($appURL);
	}
}
?>
