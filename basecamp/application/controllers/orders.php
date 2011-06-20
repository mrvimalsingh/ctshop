<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/

class Orders extends MY_Controller {
	
	function Orders() {
		parent::MY_Controller();
	}
	
	function add_order() {
		// preluam toate datele si bagam in tabele
		// dupa ce am terminat de bagat in tabele redirectam la pagina cu comenzile efectuate (in caz ca este logat)
		
		$client_id = $this->session->userdata('client_id');
		
		$order_transport = $this->input->post('order_transport');
		$order_payment = $this->input->post('order_payment');
		$order_client_type = $this->input->post('order_client_type');
		
		$order_company_name = $this->input->post('order_company_name');
		$order_fiscal_code = $this->input->post('order_fiscal_code');
		$order_nr_ord_reg_com = $this->input->post('order_nr_ord_reg_com');
		
		$order_person_name = $this->input->post('order_person_name');
		$order_cnp = $this->input->post('order_cnp');
		
		$order_phone = $this->input->post('order_phone');
		$order_address = $this->input->post('order_address');
		$order_town = $this->input->post('order_town');
		$order_zip = $this->input->post('order_zip');
		$order_county = $this->input->post('order_county');
		
		$order_obs = $this->input->post('order_obs');
		
		$order_new_email = $this->input->post('order_new_email');
		$order_new_password = $this->input->post('order_new_password');
		
		$cart_contents = $this->cart->contents();
		
		$client_set = "
			 `type` = '$order_client_type', 
			 `company_name` = '$order_company_name', 
			 `fiscal_code` = '$order_fiscal_code', 
			 `nr_ord_reg_com` = '$order_nr_ord_reg_com', 
			 `person_name` = '$order_person_name', 
			 `cnp` = '$order_cnp', 
			 `phone` = '$order_phone', 
			 `address` = '$order_address', 
			 `town` = '$order_town', 
			 `zip` = '$order_zip', 
			 `county` = '$order_county'
		";
		
		// am gatat de preluat datele
		// verificam daca exista clientul, daca nu il creem...
		if ($client_id === false) {
			// intai verificam daca are deja cont pe email-ul asta...
			
			$query = $this->db->query("SELECT `password` FROM `clients` WHERE `email` = '$order_new_email' ");
			$row = $query->row_array();
			if ($query->num_rows() > 0) {
				// TODO trebuie afisat un mesaj de eroare si trimis un mail cu parola...
				$this->load->helper('email');
				send_email($order_new_email, 'Parola shop', 'Parola pentru aceasta adresa la shop este: '.$row["password"]);
				$this->session->set_userdata('review_order_error', "Acest email a fost inregistrat deja! A fost trimis un email cu parola la aceasta adresa...");
				redirect('review_order', 'location');
			}
			
			$this->db->query("INSERT INTO `clients` SET 
					$client_set ,  
					`email` = '$order_new_email', 
			 		`password` = '$order_new_password' ");
			$client_id = $this->db->insert_id();
			$this->session->set_userdata('client_id', $client_id);
		} else {
			$this->db->query("UPDATE `clients` SET 
					$client_set 
					WHERE `id` = '$client_id' ");
		}
		
		// am rezolvat clientul acuma bagam comanda
		// TODO trebuie sa generam un numar de comanda... (deocamdata bag id-ul si un C in fata)
		// scoatem cel mai mare id din client_orders
		$query = $this->db->query("SELECT MAX(`id`) as `maxid` FROM `client_orders` ");
		$res = $query->row_array();
		$next_code = "C".($res["maxid"]+1);
		
		$total = $this->cart->total();
		
		$order_set = "
				`order_nr` = '$next_code', 
				`client_id` = '$client_id', 
				`status` = 'n', 
				`pay_type` = '$order_payment', 
				`transport_type` = '$order_transport', 
				`pay_type_price` = (SELECT `price` FROM `payment_type` WHERE `id` = '$order_payment'), 
				`transport_price` = (SELECT `price` FROM `transport_type` WHERE `id` = '$order_transport'), 
				`total` = $total + `pay_type_price` + `transport_price`, 
				`client_obs` = '$order_obs' 
		";
		
		$this->db->query("INSERT INTO `client_orders` SET 
					$order_set ");
		$order_id = $this->db->insert_id();
		// avem o comanda... bagam produsele pentru ea
		
		foreach ($cart_contents as $k => $v) {
			$data = array(
					'order_id' => $order_id, 
					'product_id' => $v["id"], 
					'quantity' => $v["qty"], 
					'price' => $v["price"]
				);
			$str = $this->db->insert_string('client_orders_re_products', $data);
			$this->db->query($str);
		}
		
		$this->cart->destroy();
		
		redirect('client/my_account/#comenzile_mele_tab', 'location');
		
	}
	
}

?>