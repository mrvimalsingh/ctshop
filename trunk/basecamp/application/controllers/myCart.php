<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/

class MyCart extends MY_Controller {
	
	function MyCart() {
		parent::MY_Controller();
	}
	
	function show_cart() {
		
		$data["error"] = $this->session->userdata('review_order_error');
		$this->session->set_userdata('review_order_error', "");
		
		$query = $this->db->query("SELECT * FROM `clients` WHERE `id` = '".$this->template_data["client_id"]."' ");
		if ($query->num_rows() > 0) {
			$data["client"] = $query->row_array();
		} else {
			// bagam datele din sesiune
			$data["client"] = array(
				 "id" => '0',
				 "type" => '', 
				 "company_name" => '', 
				 "fiscal_code" => '', 
				 "nr_ord_reg_com" => '', 
				 "person_name" => '', 
				 "cnp" => '', 
				 "phone" => '', 
				 "address" => '', 
				 "town" => '', 
				 "zip" => '', 
				 "county" => ''
			);
		}
		
		$query = $this->db->query("SELECT * FROM `counties` WHERE 1 ORDER BY `name` ");
		$data["counties"] = $query->result_array();
		
		$query = $this->db->query("SELECT * FROM `transport_type` WHERE `language_id` = '".$this->lang_id."' ORDER BY `name` ");
		$data["transport_types"] = $query->result_array();
		
		$query = $this->db->query("SELECT * FROM `payment_type` WHERE `language_id` = '".$this->lang_id."' ORDER BY `name` ");
		$data["payment_types"] = $query->result_array();
		
		$this->setTemplateDataArr($data);
		$this->showMainTemplate("show_cart");
	}
	
	function add($product_id) {
		
		$cart_add_count = mysql_real_escape_string($this->input->post('cart_add_count'));
		if (!$cart_add_count || $cart_add_count < 1) {
			$cart_add_count = 1;
		}
		
		$this->load->model('Productmodel');
			$this->Productmodel->load_product($product_id);
//			$data["product_model"] = $this->Productmodel->return_array();
		
		$data = array(
               'id'      => $product_id,
               'qty'     => $cart_add_count,
               'price'   => $this->Productmodel->discount_price,
               'name'    => preg_replace("/([^\.\:\-_ a-z0-9])+/i", "", $this->Productmodel->name),
               'options' => array(
               					'cod' => $this->Productmodel->code, 
               					'image_id' => $this->Productmodel->main_picture["id"],
								'original_price' => $this->Productmodel->price,
							)
            );

		$this->cart->insert($data);

		redirect('cart', 'location');
	}
	
	function remove($row_id) {
		$data = array("qty" => 0, "rowid" => $row_id);
		$this->cart->update($data); 
		redirect('cart', 'location');
	}
	
	function update() {
		$data = $this->input->post('cart');
		$this->cart->update($data); 
		redirect('cart', 'location');
	}
	
}

?>