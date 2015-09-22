<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class testCtrl extends WPController{
	
	function index()
	{
		$this->load->model('news_m');
		$data['string'] = $this->news_m->getAll();
		
		$this->load->view('welcome',$data);
	}
		
	function listPage()
	{
		
		$this->load->view('content');	
	}
}
