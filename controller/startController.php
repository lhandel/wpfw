<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class startController extends WPController{
	

	function index($args){
	
		var_dump($args);
		
		 $this->load->view('view/content');

	}
	
}