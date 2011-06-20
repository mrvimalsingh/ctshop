<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/

class Client extends MY_Controller {
	
	function Client() {
		parent::MY_Controller();
	}
	
	function my_account() {
		global $client_order_statuses;
		$this->config->load('myconf');
		$client_order_statuses = $this->config->item("client_order_statuses");
		
		if ($this->client_id === false) {
			redirect('client/login', 'location');	
		}
		// aratam contul clientului
		$this->load->helper('form');
		$this->load->helper('misc');
		
		$query = $this->db->query("SELECT * FROM `clients` WHERE `id` = '".$this->client_id."' ");
		$data["client"] = $query->row_array();
		
		$query = $this->db->query("SELECT * FROM `counties` WHERE 1 ORDER BY `name` ");
		$data["counties"] = $query->result_array();
		
		$query = $this->db->query("SELECT 
										`c`.*,
										`tt`.`name` as `transport_type_text`,
										`pt`.`name` as `pay_type_text`
									FROM 
										`client_orders` as `c`
										LEFT JOIN `transport_type` as `tt`
											on (`tt`.`id` = `c`.`transport_type`)
										LEFT JOIN `payment_type` as `pt`
											on (`pt`.`id` = `c`.`pay_type`)
									WHERE 
										`client_id` = '".$this->client_id."' 
									ORDER BY `date_added` DESC ");
		$data["client_orders"] = $query->result_array();
		array_walk($data["client_orders"], "extract_order_status");
		
		$this->setTemplateDataArr($data);
		$this->showMainTemplate("my_account");
	}
	
	function modify_account() {
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
					WHERE `id` = '{$this->client_id}' ");
		redirect('client/my_account', 'location');
	}
	
	function register() {
		$register_name = mysql_real_escape_string($this->input->post('register_name'));
		$register_email = mysql_real_escape_string($this->input->post('register_email'));
		$register_password = mysql_real_escape_string($this->input->post('register_password'));
		$register_password_repeat = mysql_real_escape_string($this->input->post('register_password_repeat'));
		
		// verificam daca nu exista deja utilizatorul...
		$query = $this->db->query("SELECT `id` FROM `clients` WHERE `email` = '$register_email' ");
		if ($query->num_rows() > 0) {
			// TODO aici ii de bagat ceva mesaj de eroare... sa-i spunem la om ca este deja inregistrat
			redirect('client/login', 'location');
		}
		
		// bagam datele
		$client_set = array(
			 'type' => 'person', 
			 'person_name' => $register_name, 
			 'email' => $register_email, 
			 'password' => $register_password
		);
		$this->db->insert("clients", $client_set);
		$client_id = $this->db->insert_id();
		$this->session->set_userdata('client_id', $client_id);
		redirect('client/my_account', 'location');
	}
	
	function login($from_order = false) {
		$email = mysql_real_escape_string($this->input->post('email'));
		$password = mysql_real_escape_string($this->input->post('password'));
		
		$query = $this->db->query("SELECT `id` FROM `clients` WHERE `email` = '$email' AND `password` = '$password' ");
		
		if ($query->num_rows() > 0) {
			$client = $query->row_array();
			$this->session->set_userdata('client_id', $client["id"]);
			
			if ($from_order !== false) {
				redirect('cart', 'location');
			} else {
				redirect('client/my_account', 'location');
			}
		}
		
		$this->showMainTemplate("client_login");
	}
	
	function logout() {
		$this->session->sess_destroy();
		redirect('client/login', 'location');
	}
	
}

?>