<?php

class Install extends Controller {
	
	function Install() {
		parent::Controller();
		$this->load->helper('file');
		$info = get_file_info(APPPATH."config/site_config.php");
        if ($info !== false) {
        	// daca site-ul este deja instalat iesim de aici...
        	redirect('/home', 'location');
        }
	}
	
	function index() {
		// TODO de facut si aici nishte verificari de baza.... 
		// de ex daca are scriptul dreptul de a crea fisierul de configurare
		// si alte minuni...
		$this->load->view('install');
	}
	
	function do_install() {
		// TODO de facut nishte verificari...
		$db_name = $this->input->post('db_name');
		$db_host = $this->input->post('db_host');
		$db_user = $this->input->post('db_user');
		$db_pass = $this->input->post('db_pass');
		$lang = $this->input->post('lang');
		$currency = $this->input->post('currency');
		$admin_user = $this->input->post('admin_user');
		$admin_pass = $this->input->post('admin_pass');
		
		$this->load->helper('file');
		
		$this->_create_config_file($lang, $db_host, $db_user, $db_pass, $db_name, $currency);
		$this->_create_tables($db_host, $db_user, $db_pass, $db_name);
		
		$this->db->query("INSERT INTO `users` SET `username` = '$admin_user', `password` = MD5('$admin_pass')");
//		echo "fdasfds";
		// TODO de bagat un redirect aici
	}
	
	function _create_config_file($lang, $db_host, $db_user, $db_pass, $db_name, $currency) {
		// cream fisierul de configurare...
		$config_file_string = "<?\n\n/* THIS IS GENERATED DURING INSTALATION PLEASE EDIT ONLY IF YOU'RE CONFIDENT YOU KNOW WHAT YOU'RE DOING */\n";
		$config_file_string .= "\$config['language'] = '".$lang."';\n\n";

		$config_file_string .= "// database configuration\n";
		$config_file_string .= "\$config['db']['hostname'] = '".$db_host."';\n";
		$config_file_string .= "\$config['db']['username'] = '".$db_user."';\n";
		$config_file_string .= "\$config['db']['password'] = '".$db_pass."';\n";
		$config_file_string .= "\$config['db']['database'] = '".$db_name."';\n";
		$config_file_string .= "\$config['db']['dbdriver'] = 'mysql';\n";

		$config_file_string .= "define('DEFAULT_CURRENCY', '".$currency."');\n";
		$config_file_string .= "\n?>";
		
		write_file(APPPATH."config/site_config.php", $config_file_string);
	}
	
	function _create_tables($db_host, $db_user, $db_pass, $db_name) {
		$config['hostname'] = $db_host;
		$config['username'] = $db_user;
		$config['password'] = $db_pass;
		$config['database'] = $db_name;
		$config['dbdriver'] = "mysql";
//		echo "<pre>";
//		print_r($config);
//		echo "</pre>";
		$this->load->database($config);
		
		// si acuma vine partea interesanta
		$file_content = file_get_contents(APPPATH."config/create_db.sql");
		$queries = explode(";", $file_content);
		foreach ($queries as $query) {
			$this->db->query($query);
		}
		
		// si acuma bagam nishte valori default pentru:
		// 	- counties
		$counties = array(
			array("name" => "Arad", "short_name" => "AR"),
			array("name" => "Arges", "short_name" => "AG"),
			array("name" => "Bacau", "short_name" => "BC"),
			array("name" => "Bihor", "short_name" => "BH"),
			array("name" => "Bistrita Nasaud", "short_name" => "BN"),
			array("name" => "Botosani", "short_name" => "BT"),
			array("name" => "Braila", "short_name" => "BR"),
			array("name" => "Brasov", "short_name" => "BV"),
			array("name" => "Bucuresti", "short_name" => "B"),
			array("name" => "Buzau", "short_name" => "BZ"),
			array("name" => "Calarasi", "short_name" => "CL"),
			array("name" => "Caras Severin", "short_name" => "CS"),
			array("name" => "Cluj", "short_name" => "CJ"),
			array("name" => "Constanta", "short_name" => "CT"),
			array("name" => "Covasna", "short_name" => "CV"),
			array("name" => "Dambovita", "short_name" => "DB"),
			array("name" => "Dolj", "short_name" => "DJ"),
			array("name" => "Galati", "short_name" => "GL"),
			array("name" => "Giurgiu", "short_name" => "GR"),
			array("name" => "Gorj", "short_name" => "GJ"),
			array("name" => "Harghita", "short_name" => "HR"),
			array("name" => "Hunedoara", "short_name" => "HD"),
			array("name" => "Ialomita", "short_name" => "IL"),
			array("name" => "Iasi", "short_name" => "IS"),
			array("name" => "Maramures", "short_name" => "MM"),
			array("name" => "Mehedinti", "short_name" => "MH"),
			array("name" => "Mures", "short_name" => "MS"),
			array("name" => "Neamt", "short_name" => "NT"),
			array("name" => "Olt", "short_name" => "OT"),
			array("name" => "Prahova", "short_name" => "PH"),
			array("name" => "Salaj", "short_name" => "SJ"),
			array("name" => "Satu Mare", "short_name" => "SM"),
			array("name" => "Sibiu", "short_name" => "SB"),
			array("name" => "Suceava", "short_name" => "SV"),
			array("name" => "Teleorman", "short_name" => "TR"),
			array("name" => "Timis", "short_name" => "TM"),
			array("name" => "Tulcea", "short_name" => "TL"),
			array("name" => "Valcea", "short_name" => "VL"),
			array("name" => "Vaslui", "short_name" => "VS"),
			array("name" => "Vrancea", "short_name" => "VN"),
			array("name" => "Alba", "short_name" => "AB"));
		
		foreach ($counties as $c) {
			$this->db->insert('counties', $c); 
		}
		
		$lang_ro = array("code" => "ro", "name" => "Romana", "default" => "y", "admin_default" => "y");
		$lang_en = array("code" => "en", "name" => "English", "default" => "n", "admin_default" => "n");
		$this->db->insert('languages', $lang_ro); 
		$this->db->insert('languages', $lang_en); 
		
	}
	
}

?>