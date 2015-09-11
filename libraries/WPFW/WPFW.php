<?php
if(!class_exists('WPFW')){
/*
class Benchmark{
	
	var $marker = array();
	
	function marker($name){
		$this->marker[$name] = microtime();
	}
	
	function elapsed_time($point1 = '', $point2 = '', $decimals = 4)
	{
		if ($point1 == '')
		{
			return '{elapsed_time}';
		}

		if ( ! isset($this->marker[$point1]))
		{
			return '';
		}

		if ( ! isset($this->marker[$point2]))
		{
			$this->marker[$point2] = microtime();
		}

		list($sm, $ss) = explode(' ', $this->marker[$point1]);
		list($em, $es) = explode(' ', $this->marker[$point2]);

		return number_format(($em + $es) - ($sm + $ss), $decimals);
	}
	
}
*/
include_once('WPController.php');
include_once('WPLoader.php');
include_once('WPModel.php');
include_once('phpfastcache/phpfastcache.php');

class WPFW {
	
	public $version = 0.1;
	
	private $pages = array();
	
	private $shortcode = array();
	
	public $plugin_name;
	public $base_url;
	public $plugin_url;
	
	private $_header = array();
	
	function __construct($data=array()){
		$this->base_url = (isset($data['base_url']))? $data['base_url'] : '';
		$this->plugin_url = (isset($data['plugin_url']))? $data['plugin_url'] : '';
		$this->plugin_name = plugin_basename($this->base_url);
		
		if(session_id() == '') {
			session_start();// session isn't started
    	}
		
		add_action('init',array($this,'wpinit'));
		add_action('shutdown',array($this,'wpshotdown'));
		add_action('admin_head', array($this,'wphead'));
		add_action('wp_head', array($this,'wphead'));
	}
	
	function wpheader($data){
		$this->_header[] = $data;
	}
	
	function wphead(){
		echo '<script type="text/javascript">
/* <![CDATA[ */
var WPFW = {"ajaxurl":"'.admin_url( 'admin-ajax.php').'"};
/* ]]> */
</script>';
		foreach($this->_header as $data){
			echo $data;
		}
	}
	
	function wpinit(){
		ob_start();
	}
	
	function wpshotdown(){
		 try { while( @ob_end_flush() ); } catch( Exception $e ) {}
	}
	
	function addMenuPage($add){
		if(is_array($add)){				
			foreach($add as $item){
				$this->pages[] = $item;
			}
		}else{
			$this->pages[] = $add;
		}
		
	}
	
	function createMenu(){		
		add_action( 'admin_menu', array($this,'_creatingMenu'));
	}
	
	/*
	 * Creating the wordpress admin menus from the pages in the array pages
	*/
	function _creatingMenu(){
		
		foreach($this->pages as $page){
			
			// Check if the file exists
			if(isset($page['url'])){
				$file = $this->base_url.'/'.$page['url'];
			}else{
				if(file_exists($this->base_url.'/controller/'.strtolower($page['controller']).'.php'))
				{
					$file = $this->base_url.'/controller/'.strtolower($page['controller']).'.php';
				}
			}
			
			if(file_exists($file))
			{
				// Include the file once
				
				include_once($file);
				
				// Check so the class exists
				if(class_exists($page['controller'])){
						$slug= (isset($page['slug']))? $page['slug'] : $this->create_slug($page['label']);
						$badge = (isset($page['badge']) && $page['badge']!=0)? '<span class=\'update-plugins count-1\' title=\'title\'><span class=\'update-count\'>'.$page['badge'].'</span></span>': '';
						// Create the menu-page
						add_menu_page(
										$page['label'],
										$page['label'].$badge,
										'manage_options',
										$slug, 
										array
										(
											new $page['controller'](),
											'initCtrl'
										),
										null,
										$page['order']
										); 
										
						if(isset($page['children']))
						{
							foreach($page['children'] as $child)
							{
								// Check if file should be included and if it exits
								if(isset($child['url']) && file_exists($this->base_url.'/'.$child['url']))
									include_once($this->base_url.'/'.$child['url']);
								
								if(isset($child['controller']) && class_exists($child['controller']))
								{
									$class = $child['controller'];
									
									if(!isset($child['method']) && method_exists($class,'index'))
									{
										$child['method'] = 'index';
									}
								}
								else
								{
									$class = $page['controller'];
								}	
								
							
								$subslug= (isset($child['slug']))? $child['slug'] : $this->create_slug($child['label']);
						
								add_submenu_page(
										$slug, 
										$child['label'], 
										$child['label'], 
										'manage_options', 
										$subslug, 
										array
										(
											new $class(),
											$child['method']
										)
										);
							}	
						}
					
				}//.class exists end
				
			}//.file exists end
	
		}//.foreach end
		
		
		
	}	
	
	private function create_slug($name){
		return str_replace(array('å','ä','ö','Å','Ä','Ö',' ','!','#','&'), array('a','a','o','A','A','O','','','',''), $name);
	}
	
	function addShortcode($add){
		$this->shortcode[] = $add;
	}
	
	function createShortcode(){
		
		foreach($this->shortcode as $sc){
			
			if(file_exists($this->base_url.'/'.$sc['url'])){
				
				include_once($this->base_url.'/'.$sc['url']);
				
				if(class_exists($sc['controller']))
				{
					
					add_shortcode($sc['name'],array(new $sc['controller'](),'index'));
				}
			}
			
			
		}
		
	}
	
}


}