<?php

class Contact extends MY_Controller {
	
	function Contact() {
		parent::MY_Controller();
	}
	
	function index($data = false) {
		if ($data === false) {
			$data["captcha_error"] = "";
			$data["success"] = "";
		}
		$this->setTemplateDataArr($data);
		$this->showMainTemplate("contact");
	}
	
	function send() {
		$data["captcha_error"] = "";
		$data["success"] = "";
		
		$session_security_code = $this->session->userdata('security_code');
		
		$nume = $this->input->post('nume');
		$email = $this->input->post('email');
		$titlu = $this->input->post('titlu');
		$mesaj = $this->input->post('mesaj');
		$security_code = $this->input->post('security_code');
		if (strtolower($session_security_code) != strtolower($security_code)) {
			$data["captcha_error"] = "true";
		} else {
			$this->load->library('email');
			$this->email->from($email, "Formular contact: ".$nume);
			$this->email->to($this->dbgeneralsettings->getKey("contact_email")); 
			
			$this->email->subject($titlu);
			$this->email->message($mesaj);	
			
			$this->email->send();
			$data["success"] = "true";
		}
		
		$this->index($data);
	}
	
	function captcha() {
		$this->load->library('captchaSecurityImages', array("font" => FCPATH.'/monofont.ttf'));
	}
	
}