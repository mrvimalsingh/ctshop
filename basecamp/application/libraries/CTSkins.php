<?php
/*
 * Copyright (C)
 * _________            .___      
 * \_   ___ \  ____   __| _/____  
 * /    \  \/ /  _ \ / __ |/ __ \ 
 * \     \___(  <_> ) /_/ \  ___/ 
 *  \______  /\____/\____ |\___  >
 *         \/            \/    \/ 
 * ___________       .__          __                       
 * \__    ___/_  _  _|__| _______/  |_  ___________  ______
 *   |    |  \ \/ \/ /  |/  ___/\   __\/ __ \_  __ \/  ___/
 *   |    |   \     /|  |\___ \  |  | \  ___/|  | \/\___ \ 
 *   |____|    \/\_/ |__/____  > |__|  \___  >__|  /____  >
 *                           \/            \/           \/
 * 
 * Nagy Mihaly Ferencz
 * 
 * File: CTSkins.php
 * Created: Aug 2, 2010
 * 
 */

class CTSkins {
	
	var $settings = array(
		"skin_dir" => false, // daca-i false se va calcula automat...
		"selected_skin" => "default", 
		"default_skin" => "default"
	);
	var $available_skins = array();
	
	function CTSkins($params = array()) {
		if (is_array($params)) {
			foreach ($params as $k => $v) {
				$this->settings[$k] = $v;
			}
		}
		
		$CI =& get_instance();
		$CI->load->library('parser');
		if ($this->settings["skin_dir"] === false){
			$this->settings["skin_dir"] = FCPATH."skins/";
		}
		
		// scoatem skinurile disponibile...
		$filter = array(".", "..", ".svn");
		if ($handle = opendir($this->settings["skin_dir"])) {
			while (false !== ($file = readdir($handle))) {
				if (!in_array($file, $filter) && is_dir($this->settings["skin_dir"].$file)){
					$this->available_skins[] = $file;
				}
			}
			closedir($handle);
		}
		
		// if the selected skin is not in the available list we set it to the default one...
		if (!in_array($this->settings["selected_skin"], $this->available_skins)) {
			$this->settings["selectd_skin"] = $this->settings["default_skin"];
		}
		
	}
	
	function getAvailableSkins() {
		return $this->available_skins;
	}
	
	function getSkinDir() {
		return $this->settings["skin_dir"];
	}
	
	function getSelectedSkin() {
		return $this->settings["selected_skin"];
	}
	
	function getTemplate($template, $data) {
		$CI =& get_instance();
		$file_name = $this->getSkinDir()."".$this->getSelectedSkin()."/".$template;
		$default_name = $this->getSkinDir()."".$this->settings["default_skin"]."/".$template;
		$template_string = "";
		if (file_exists($file_name)) {
			$template_string = file_get_contents($file_name);
		} else if (file_exists($default_name)) {
			$template_string = file_get_contents($default_name);
		}
		return $CI->parser->parse($template_string, $data, TRUE, TRUE);
	}
	
}

?>