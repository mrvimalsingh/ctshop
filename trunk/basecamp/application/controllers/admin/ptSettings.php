<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/

class PtSettings extends MY_Controller {
	
	function PtSettings()
	{
		parent::MY_Controller();
	}
	
	function index()
	{
		$query = $this->db->query("SELECT `pt`.*, `l`.`name` as `lang_name` FROM `payment_type` as `pt` LEFT JOIN `languages` as `l` ON (`pt`.`language_id` = `l`.`id`) WHERE 1 ");
		$data["payment_types"] = $query->result_array();
		
		$query = $this->db->query("SELECT `tt`.*, `l`.`name` as `lang_name` FROM `transport_type` as `tt` LEFT JOIN `languages` as `l` ON (`tt`.`language_id` = `l`.`id`)  WHERE 1 ");
		$data["transport_types"] = $query->result_array();
		
		$this->showMainTemplate("admin/pt_settings", $data, true);
	}
	
	function save($type) {
		$id = mysql_real_escape_string($this->input->post('edit_'.$type.'_id'));
		$name = mysql_real_escape_string($this->input->post('edit_'.$type.'_name'));
		$price = mysql_real_escape_string($this->input->post('edit_'.$type.'_price'));
		$language_id = mysql_real_escape_string($this->input->post('edit_'.$type.'_lang'));
		
		$set = "`name` = '$name', 
				`price` = '$price',
				`language_id` = '".$language_id."' ";
		
		$table = "transport_type";
		if ($type == "pt") {
			$table = "payment_type";
		}
		
		if ($id > 0) {
//			echo "UPDATE `$table` SET $set WHERE `id` = '$id' ";
			$query = $this->db->query("UPDATE `$table` SET $set WHERE `id` = '$id' ");
		} else {
			$query = $this->db->query("INSERT INTO `$table` SET $set ");
		}
		
		redirect('/admin/ptSettings', 'location');
	}
	
	function delete($type, $id) {
		$query = $this->db->query("DELETE FROM `$type` WHERE `id` = '$id' ");
		redirect('/admin/ptSettings', 'location');
	}
	
}

?>