<?php
class WPLoad{
	
	private $caller; 
	
	public $load;
	
	function WPLoad(&$ad){
		$this->caller = $ad;
		$this->load = $this;
	}
	
	function _get_base_url(){
	
		// Get plugin_url
		$base=dirname(__FILE__);
		$base = explode('wp-content/plugins/', $base);
		$burl = $base[0].'wp-content/plugins/';
		$base = explode('/', $base[1]);
		
		if(file_exists($burl.$base[0]))
			return $burl.$base[0];
		else
			return null;
	
		
		
	}
	
	public function view($view,$data=array())
	{
		$base=dirname(__FILE__);
		
		
		if($this->caller->base_url==null)
			$this->caller->base_url = $this->_get_base_url();
			
		if(file_exists($this->caller->base_url.'/view/'.$view.'.php'))
			$file = $this->caller->base_url.'/view/'.$view.'.php';
		elseif(file_exists($this->caller->base_url.'/'.$view.'.php'))
			$file = $this->caller->base_url.'/'.$view.'.php';
		else
			return false;
			
		
		if(is_admin())
			echo $this->_bufferView($file,$data);	
		else
			return $this->_bufferView($file,$data);
		
	
		
	}
	
	private function _bufferView($view,$data=array()){
		ob_start();
		if(isset($data))
			 extract($data);
			 
		include $view;
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}
	
	public function model($model){
		
		if($this->caller->base_url==null)
			$this->caller->base_url = $this->_get_base_url();
		
			
		if(file_exists($this->caller->base_url.'/models/'.strtolower($model).'.php'))
			$file = $this->caller->base_url.'/models/'.strtolower($model).'.php';  
		elseif(file_exists($this->caller->base_url.'/'.strtolower($model).'.php'))
			$file = $this->caller->base_url.'/'.strtolower($model).'.php';
		else
			return false;
		
		include_once($file);
		
		$this->caller->$model = new $model();
		
		return true;
	
	}
	
	
}