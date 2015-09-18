<?php
class WPController {
	
	private $wpfw = null;
	public $load;
	public $db;
	public $wpdb;
	
	public $base_url=null;
	public $plugin_url=null;
	
	function WPController($caller=''){
		
		global $wpdb;
		// Set wpfw
		if($caller!='')
			$this->wpfw=$caller;
			
		$this->base_url = $this->wpfw->base_url;
		$this->load=new WPLoad($this,$caller);	
		$this->wpdb = $wpdb;
		
		//add_action( 'admin_enqueue_scripts', array($this->load,'admin_enqueue_scripts'));
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
	function _initCtrl($arg=array()){
	
		
		if(!is_admin())
		{
			ob_start();
		}	
			
		// Check if a subpage should be load
		if(isset($_GET['page']) && isset($_GET['page2']))
		{
			// Check if the method exits
			if(method_exists($this,$_GET['page2'])){
				$this->$_GET['page2']($arg);
			}
			
		}
		elseif(isset($_GET['page']))
		{
		
			if(method_exists($this,'index')){
				$this->index($arg);
			}
			
		}else{
		
			if(method_exists($this,'index')){
				$this->index($arg);
			}
		}
		
		// return view if not on admin page
		if(!is_admin())
		{
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}	
		
	}
	
	
}

