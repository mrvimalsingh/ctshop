<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/


class Firm extends MY_Controller {
	
	function Firm()
	{
		parent::MY_Controller();
	}
	
	function index()
	{
		$data["company_name"] = $this->dbgeneralsettings->getKey("company_name");
		$data["company_fiscal_code"] = $this->dbgeneralsettings->getKey("company_fiscal_code");
		$data["company_register_nr"] = $this->dbgeneralsettings->getKey("company_register_nr");
		$data["contact_email"] = $this->dbgeneralsettings->getKey("contact_email");
		
		$this->showMainTemplate("admin/firm", $data, true);
	}
	
	function save() {
		$company_name = mysql_real_escape_string($this->input->post('company_name'));
		$company_fiscal_code = mysql_real_escape_string($this->input->post('company_fiscal_code'));
		$company_register_nr = mysql_real_escape_string($this->input->post('company_register_nr'));
		$contact_email = mysql_real_escape_string($this->input->post('contact_email'));
		
		$this->dbgeneralsettings->setKey("company_name", $company_name);
		$this->dbgeneralsettings->setKey("company_fiscal_code", $company_fiscal_code);
		$this->dbgeneralsettings->setKey("company_register_nr", $company_register_nr);
		$this->dbgeneralsettings->setKey("contact_email", $contact_email);
		
		redirect("/admin/firm", 'location');
		
	}
	
}

?>