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
	
	function Orders()
	{
		parent::MY_Controller();
	}
	
	function index()
	{
		$this->config->load('myconf');
		$data_orders["status_options"] = $this->config->item("client_order_statuses");
		$data_orders["status_options"]["0"] = " - toate - ";
		
		$this->load->helper('form');
		$this->showMainTemplate("admin/orders", $data_orders, true);
	}
	
	function order_table($page=1, $status = 'n', $client_id = "0", $start_date = "0", $end_date = "0") {
		global $client_order_statuses;
//		
//		echo "page=".$page."<br />\n";
//		echo "status=".$status."<br />\n";
//		echo "client_id=".$client_id."<br />\n";
//		echo "start_date=".$start_date."<br />\n";
//		echo "end_date=".$end_date."<br />\n";
		
		$this->config->load('myconf');
		$client_order_statuses = $this->config->item("client_order_statuses");
		$this->load->helper('misc');
		
		$this->load->library('pagination');
		
		$where = array();
		if ($status !== "0") {
			$where[] = "`status` = '$status'";
		}
		if ($client_id > 0) {
			$where[] = "`client_id` = '$client_id'";
		}
		if ($start_date != "0") {
			$where[] = "`date_added` >= '$start_date'";
		}
		if ($end_date != "0") {
			$where[] = "`date_added` <= '$end_date'";
		}

		$where_string = implode(" AND ", $where);
		if ($where_string == "") {
			$where_string = "1";
		}
		
//		echo "where_string=".$where_string."<br />\n";
		
		$query = $this->db->query("SELECT 
										COUNT(`o`.`id`) as `rc`
									FROM 
										`client_orders` as `o`
									WHERE $where_string");
		$row = $query->row_array();
		
		$config['base_url'] = site_url("admin/orders/order_table")."/";
		$config['total_rows'] = $row["rc"];
		$config['per_page'] = 25;
		$config["page_query_string"] = FALSE;
		$config['uri_segment'] = 4;
		$config["js_function"] = "loadOrders";
		
		$this->pagination->initialize($config);
		
		$data_orders["pagination_links"] = $this->pagination->create_links(true);
		
//		echo $this->pagination->cur_page;
		
		$offset = ($this->pagination->cur_page-1) * $config['per_page'];
		if ($offset < 0) {
			$offset = 0;
		}

		$query = $this->db->query("SELECT 
										`o`.*
									FROM 
										`client_orders` as `o`
									WHERE $where_string
									ORDER BY `date_added` DESC
									LIMIT $offset, ".$config["per_page"]);
		
		$data_orders["orders"] = $query->result_array();
		array_walk($data_orders["orders"], "extract_order_status");
		
		// scoatem numele clientului
		foreach ($data_orders["orders"] as $k => $order) {
			$query = $this->db->query("SELECT 
											IF(`c`.`type` = 'person', `c`.`person_name`, `c`.`company_name`) as `client_name` 
										FROM 
											`clients` as `c` 
										WHERE `id` = '".$order["client_id"]."' ");
			$row = $query->row_array(); 
			$data_orders["orders"][$k]["client_name"] = $row["client_name"];
		}
		$this->load->view('admin/order_table', $data_orders);
	}
	
	function edit_order($order_id) {
		$this->config->load('myconf');
		$data_orders["status_options"] = $this->config->item("client_order_statuses");
		$this->load->helper('misc');
		$this->load->helper('form');
		
		$sql = "SELECT 
					`o`.*,
					IF(`c`.`type` = 'person', `c`.`person_name`, `c`.`company_name`) as `client_name` 
				FROM 
					`client_orders` as `o`
					LEFT JOIN `clients` as `c`
						ON (`c`.`id` = `o`.`client_id`)
				WHERE `o`.`id` = '$order_id' ";
		$query = $this->db->query($sql);
//		echo "sql= ".$sql."<br />";
		$data_orders["order"] = $query->row_array();
		
		$sql = "SELECT 
					`rp`.*,
					`p`.`code`,
					`pl`.`name`, 
					`rp`.`quantity` * `rp`.`price` as `subtotal`
				FROM
					`client_orders_re_products` as `rp`
					LEFT JOIN `products` as `p`
						ON (`rp`.`product_id` = `p`.`id`)
					LEFT JOIN `products_lang` as `pl`
						ON (`pl`.`product_id` = `p`.`id`) 
				WHERE 
					`pl`.`language_id` = '".$this->lang_id."'
					AND `rp`.`order_id` = '$order_id' ";
		$query = $this->db->query($sql); 
//		echo "sql= ".$sql."<br />";
		$data_orders["order_products"] = $query->result_array();
		
		$query = $this->db->query("SELECT * FROM `transport_type` WHERE 1 ORDER BY `name` ");
		$data_orders["transport_types"] = $query->result_array();
		
		$query = $this->db->query("SELECT * FROM `payment_type` WHERE 1 ORDER BY `name` ");
		$data_orders["payment_types"] = $query->result_array();
		
		$this->showMainTemplate("admin/edit_order", $data_orders, true);
	}
	
	function save_order($order_id) {
		
		$order_transport = $this->input->post('order_transport');
		$order_payment = $this->input->post('order_payment');
		$order_obs = $this->input->post('order_obs');
		$client_obs = $this->input->post('client_obs');
		$order_status = $this->input->post('order_status');
		
		$data = array(
					'status' => $order_status, 
					'pay_type' => $order_payment, 
					'transport_type' => $order_transport, 
					'client_obs' => $client_obs, 
					'obs' =>$order_obs
				);
		$str = $this->db->update_string('client_orders', $data, "`id` = '$order_id'");
//		echo "str=".$str."<br />\n";
		$this->db->query($str);
		
		$this->db->query("UPDATE 
								`client_orders` as `o`
							SET
								`pay_type_price` = (SELECT `price` FROM `payment_type` WHERE `id` = `o`.`pay_type`),
								`transport_price` = (SELECT `price` FROM `transport_type` WHERE `id` = `o`.`transport_type`),
								`total` = `pay_type_price` + `transport_price` + (SELECT SUM(`price` * `quantity`) FROM `client_orders_re_products` WHERE `order_id` = `o`.`id`) 
							WHERE `o`.`id` = '$order_id' ");
		
		redirect('/admin/orders/edit_order/'.$order_id, 'location');
	}
	
}

?>