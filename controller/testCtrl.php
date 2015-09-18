<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class testCtrl extends WPController{
	
	function index(){
		
			
		$this->load->library('phpfastcache');
		
		$name = $this->phpfastcache->get('name');

		$data['from_cache'] = 'ja';
		if($name==null)
		{
			$name = 'Ludwig';
			$this->phpfastcache->set('name',$name,60);
			$data['from_cache'] = 'nej';
		}
		
		$data['name'] = $name;
		

		$this->load->model('news_m');
		$data['string'] = $this->news_m->getBy();
		// Load style to the page
		
		$this->load->view('welcome',$data);
	}
		
}
