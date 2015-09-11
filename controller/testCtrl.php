<?php
class testCtrl extends WPController{
	
	function index(){
		
		$this->load->model('news_m');
		$data['string'] = $this->news_m->getBy();
		
		$this->load->view('welcome',$data);
	}
	
}