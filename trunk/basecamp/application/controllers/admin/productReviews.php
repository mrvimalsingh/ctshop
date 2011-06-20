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
 * File: productReviews.php
 * Created: Jul 18, 2010
 * 
 */


class ProductReviews extends MY_Controller {
	
	function ProductReviews() {
		parent::MY_Controller();
		$this->load->library('Review');
	}

	function index() {
		$data["reviews"] = $this->review->getUnapprovedReviews();
		$this->showMainTemplate("admin/products/productReviews", $data, true);
	}
	
	function approve($id) {
		$this->review->approveReview($id);
		redirect('admin/productReviews', 'location');
	}
	
	function delete($id) {
		$this->review->deleteReview($id);
		redirect('admin/productReviews', 'location');
	}
	
}
?>