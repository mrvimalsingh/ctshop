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
 * File: banners.php
 * Created: Jul 23, 2010
 * 
 */

class Banners extends MY_Controller {
	
	function Banners() {
		parent::MY_Controller();
		$this->load->library('BannerRotator');
	}
	
	function next($group) {
		// scoatem urmatorul banner
		echo $this->bannerrotator->getNextBanner($group);
	}
	
	function navigate($banner_id) {
		// adaugam ca o fost dat click si redirectam la ce trebuie...
		redirect($this->bannerrotator->getBannerLink($banner_id), 'location');
	}
	
}

?>