<?php
class WPController {
	
	public $load;
	public $cache;
	public $base_url=null;
	public $plugin_url=null;
	
	function WPController(){
		$this->load=new WPLoad($this);	
		$this->cache = new phpFastCache();
	}
	
	function anchor($controller,$method){
		$plugin_name = explode('/',$_GET['page']);

		$url = 'admin.php?page='.$plugin_name[0].'/';
		
		if(isset($controller) && $controller!=null)
			$url.=$controller;		# New controller
		else
			$url.=$plugin_name[1]; 	# Current name
		
		if(isset($method))
			$url.='&page2='.$method;
			
		return $url;
	}
	
	// Controlling with method in class should be load
	function initCtrl($arg){
		// Check if a subpage should be load
		if(isset($_GET['page']) && isset($_GET['page2']))
		{
			// Check if the method exits
			if(method_exists($this,$_GET['page2'])){
				$this->$_GET['page2']();
			}
			
		}
		elseif(isset($_GET['page']))
		{
		
			if(method_exists($this,'index')){
				$this->index();
			}
			
		}
		
	}
	
	
}

