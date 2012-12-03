<?
/**
*@package active_directory
*Abstracts Active Directory Connection and ldap functions for interfacing with AD
*/
class active_directory{
	function __construct(){
		/**
		*link_identifier $ad
		*/
		$this->dn = 'DC=swna,DC=wdpr,DC=disney,DC=com';

		$ldapserver = 'sm-cala-dc13.swna.wdpr.disney.com';

		$this->ad = ldap_connect($ldapserver)
    			or die("Couldn't connect to LDAP Server!");

		ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);

		$username = 'SWNA\$Adminp';
		$password = 'Phase1';

		// Bind to the directory server.
		if(!ldap_bind($this->ad,$username,$password)){
        		die('Could not bind to AD');
		}
	}

	/**
	*searches the directory server with given filter
	*@param string $filter
	*@return array results of ldap_search()
	*/
	function search($dn = 'OU=Users',$filter='cn=*'){
		$dn = $dn . ',' . $this->dn;
		$ad = $this->ad;

		//echo "dn is |$dn| ... filter is |$filter| .. ";

		$res = ldap_search($ad,$dn,$filter);
		return ldap_get_entries($ad,$res);
	}

	/**
	*Adds an entry to the Security Groups on the directory server
	*@param array entry
	*/
	/*
	function add_group($entry){
		$dn = 'CN=' . $entry['cn'] . ',OU=Web App Security,OU=Security Groups,' . $this->dn;
		ldap_add($this->ad,$dn,$entry);
	}
	*/

	function delete($entry){
		ldap_delete($this->ad,$entry);
	}

	/**
	*Adds an Employee
	*@param array entry
	*/
	/*
	function add_employee($entry){
		 $dn = 'CN=' . $entry['cn'] . ',OU=Users,' . $this->dn;
		ldap_add($this->ad,$dn,$entry);
	}
	*/
}
?>
