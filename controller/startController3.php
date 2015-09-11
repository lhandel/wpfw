<?php
class startController3 extends WPController{
	

	function index(){
	
		$data = array();
		$data['posts'] = new stdClass();
		$this->load->view('view');
		

	}
	
}