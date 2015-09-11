<?php
class WPLoad{
	
	private $caller; 
	private $wpfw;
	public $load;
	
	function WPLoad(&$ad){
		$this->caller = $ad;
		$this->load = $this;
	}
	

	public function library($class,$args=array()){
		
		
		if(file_exists($this->caller->base_url.'/libraries/'.strtolower($class).'.php'))
			$file = $this->caller->base_url.'/libraries/'.strtolower($class).'.php';  
		elseif(file_exists($this->caller->base_url.'/'.strtolower($class).'.php'))
			$file = $this->caller->base_url.'/'.strtolower($class).'.php';
		else
			return false;
		
		include_once($file);
		
		$this->caller->$class = new $class();
		
	}
	
	public function view($view,$data=array())
	{
		$base=dirname(__FILE__);
			
		
		if(file_exists($this->caller->base_url.'/view/'.$view.'.php'))
			$file = $this->caller->base_url.'/view/'.$view.'.php';
		elseif(file_exists($this->caller->base_url.'/'.$view.'.php'))
			$file = $this->caller->base_url.'/'.$view.'.php';
		else
			return false;

		
		if(isset($data))
			 extract($data);
			 
		include $file;

		
	}

	public function model($model){
		
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