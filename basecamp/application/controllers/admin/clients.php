<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/


class Clients extends MY_Controller {
	
	function Clients()
	{
		parent::MY_Controller();
	}
	
	function index()
	{
		$this->showMainTemplate("admin/clients", "", true);
	}
	
	function client_table() {
		$this->load->library('pagination');
		
		$query = $this->db->query("SELECT 
										COUNT(`c`.`id`) as `rc`
									FROM 
										`clients` as `c`
									WHERE 1");
		$row = $query->row_array();
		
		$config['base_url'] = site_url("admin/clients/client_table")."/";
		$config['total_rows'] = $row["rc"];
		$config['per_page'] = 25;
		$config["page_query_string"] = FALSE;
		$config['uri_segment'] = 4;
		$config["js_function"] = "loadClients";
		
		$this->pagination->initialize($config);
		
		$data["pagination_links"] = $this->pagination->create_links(true);
		
		$ofset = ($this->pagination->cur_page-1) * $config['per_page'];
		if ($ofset < 0) {
			$ofset = 0;
		}
		
		$query = $this->db->query("SELECT 
										`c`.*,
										IF(`c`.`type` = 'person', `c`.`person_name`, `c`.`company_name`) as `client_name` 
									FROM 
										`clients` as `c`
									WHERE 1
									ORDER BY `date_added` DESC
									LIMIT $ofset, ".$config["per_page"]);
		
		$data["clients"] = $query->result_array();
		
		$this->load->view('admin/client_table', $data);
		
	}
	
	function edit_client($client_id) {
		$this->load->helper('form');
		$query = $this->db->query("SELECT * FROM `clients` WHERE `id` = '".$client_id."' ");
		$data["client"] = $query->row_array();
		
		$query = $this->db->query("SELECT * FROM `counties` WHERE 1 ORDER BY `name` ");
		$data["counties"] = $query->result_array();
		
		$this->showMainTemplate("admin/edit_client", $data, true);
	}
	
	function save_client($client_id) {
		$client_type = $this->input->post('client_type');
		
		$company_name = $this->input->post('company_name');
		$fiscal_code = $this->input->post('fiscal_code');
		$nr_ord_reg_com = $this->input->post('nr_ord_reg_com');
		
		$person_name = $this->input->post('person_name');
		$cnp = $this->input->post('cnp');
		
		$phone = $this->input->post('phone');
		$address = $this->input->post('address');
		$town = $this->input->post('town');
		$zip = $this->input->post('zip');
		$county = $this->input->post('county');
		
		$new_email = $this->input->post('new_email');
		$new_password = $this->input->post('new_password');
		
		$client_set = "
			 `type` = '$client_type', 
			 `company_name` = '$company_name', 
			 `fiscal_code` = '$fiscal_code', 
			 `nr_ord_reg_com` = '$nr_ord_reg_com', 
			 `person_name` = '$person_name', 
			 `cnp` = '$cnp', 
			 `phone` = '$phone', 
			 `address` = '$address', 
			 `town` = '$town', 
			 `zip` = '$zip', 
			 `county` = '$county',
			 `email` = '$new_email', 
			 `password` = '$new_password'
		";
		
		$this->db->query("UPDATE `clients` SET 
					$client_set 
					WHERE `id` = '{$client_id}' ");
		redirect('admin/clients/edit_client/'.$client_id, 'location');
	}
	
	function autocomplete($q = "") {
		$query = $this->db->query("SELECT 
										`c`.`id`,
										IF(`c`.`type` = 'person', `c`.`person_name`, `c`.`company_name`) as `client_name` 
									FROM 
										`clients` as `c` 
									WHERE 
										`c`.`person_name` LIKE '%$q%'
										OR `c`.`company_name` LIKE '%$q%'
									LIMIT 15");
		$clients = $query->result_array();
		foreach ($clients as $c) {
			echo $c["client_name"]."|".$c["id"]."\n";
		}
	}
	
}

?>