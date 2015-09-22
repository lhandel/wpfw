<?php

class memberController extends WPController {
	
	
	function index(){
	
		
		$data = array();
		$data['name'] = 'Jaakko';
		$data['orders'] = array(1,2,4);
		
		if(isset($_POST['firstname']))
		{
			$data['name'] = $_POST['firstname'];
		}
		
		$this->load->view('forms',$data);
		
	}
	
	
	
}

