<?php
if(!class_exists('WPFW')){

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

$bm = new Benchmark();
$bm->marker('init');



class WPFW {
	
	public $version = 0.1;
	
	private $pages = array();
	
	private $shortcode = array();
	
	private $style = array();
	
	public $plugin_name;
	public $base_url;
	public $plugin_url;
	
	private $_header = array();
	
	function __construct($data=array())
	{
		include_once('WPController.php');
		include_once('WPLoader.php');
		include_once('WPModel.php');
		
		$this->base_url = (isset($data['base_url']))? $data['base_url'] : $this->_find_base_url();
		$this->plugin_url = (isset($data['base_url']))? $data['base_url'] : $this->_find_base_url();
		$this->plugin_name = plugin_basename($this->base_url);
		
		if(session_id() == '') {
			session_start();// session not started
    	}
    	
    	if(isset($data['environment']))
		{
			switch ($data['environment'])
			{
				case 'development':
					error_reporting(E_ALL);
					ini_set('display_errors', 1);
				break;
		
				case 'testing':
				case 'production':
					error_reporting(0);
				break;
		
				default:
					exit('The application environment is not set correctly.');
			}
		}

    	
		add_action('init',array($this,'wpinit'));
		add_action('shutdown',array($this,'wpshotdown'));
		add_action('admin_head', array($this,'wphead'));
		add_action('wp_head', array($this,'wphead'));
		
	}
	
	private function _find_base_url()
	{
		$url = dirname(plugin_basename(__FILE__));
		$url = explode('/', $url);
		$plugin_name = $url[0];
		return WP_PLUGIN_DIR.'/'.$plugin_name;
	}
	private function _find_plugin_url()
	{
		$url = dirname(plugin_basename(__FILE__));
		$url = explode('/', $url);
		$plugin_name = $url[0];
		return WP_PLUGIN_URL.'/'.$plugin_name;
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
	
	function run()
	{
		if(is_admin())
		{
			// Execute admin menu
			$this->_createMenu();
			add_action( 'admin_enqueue_scripts', array($this,'_loadstyle'));
			add_action('login_enqueue_scripts', array($this,'_loadstyle'));
		}
		else
		{
			// Execute shortcodes
			$this->_createShortcode();
			add_action( 'wp_enqueue_scripts', array($this,'_loadstyle' ));
		}
		
		
	}

	
	function wpinit(){
		ob_start();
	}
	
	function wpshotdown(){
	
		 try { while( @ob_end_flush() ); } catch( Exception $e ) {}
	}
	
	function admin_menu($add){
			
		foreach($add as $item){
			$this->pages[] = $item;
		}
		
	}
	
	
	
	
	private function _createMenu(){		
		add_action( 'admin_menu', array($this,'_creatingMenu'));
		
	}
	
	public function admin_style($style){
		
		if(!is_array($style))
			$style = array($style);
		
		$this->style['admin'] = $style;
	}
	public function front_style($style){
		
		if(!is_array($style))
			$style = array($style);
			
		$this->style['front'] = $style;
	}
	
	public function _loadstyle(){
	
		$styles = array();
		if(is_admin() && !empty($this->style['admin']))
		{
			$styles = $this->style['admin'];
		}
		elseif(!empty($this->style['front']))
		{
			$styles = $this->style['front'];
		}
		
		foreach($styles as $style)
		{
			if(is_array($style)){
				
			}else{
				wp_enqueue_style($this->create_slug($style), $this->plugin_url.'/'.$style);
			}
		}
		
		
	}
	
	/*
	 * Creating the wordpress admin menus from the pages in the array pages
	*/
	function _creatingMenu(){
	
		foreach($this->pages as $page){
			
			// Check if the file exists
			if(isset($page['url']))
			{
				$file = $this->base_url.'/'.$page['url'];
			}
			else
			{
				if(file_exists($this->base_url.'/controllers/'.strtolower($page['controller']).'.php'))
				{
					$file = $this->base_url.'/controllers/'.strtolower($page['controller']).'.php';
				}
				elseif(file_exists($this->base_url.'/'.strtolower($page['controller']).'.php'))
				{
					$file = $this->base_url.'/'.strtolower($page['controller']).'.php';
				}
				else
				{
					trigger_error('Unable to find controller.');
				}
			}
			

			
			if(file_exists($file))
			{
				// Include the file once
				
				include_once($file);
				
				// Check so the class exists
				if(class_exists($page['controller'])){
						$slug= (isset($page['slug']))? $page['slug'] : $this->create_slug($page['controller']);
						$badge = (isset($page['badge']) && $page['badge']!=0)? '<span class=\'update-plugins count-1\' title=\'title\'><span class=\'update-count\'>'.$page['badge'].'</span></span>': '';
						// Create the menu-page
						add_menu_page(
										$page['label'],
										$page['label'].$badge,
										'manage_options',
										$slug, 
										array
										(
											new $page['controller']($this),
											'_initCtrl',
										),
										(isset($page['icon']))? $page['icon'] : null,
										$page['order']
										); 
										
						if(isset($page['children']))
						{
							foreach($page['children'] as $child)
							{
								// Find the file
								if(isset($child['url']))
								{
									$file = $this->base_url.'/'.$child['url'];
								}
								else
								{
									if(file_exists($this->base_url.'/controllers/'.strtolower($child['controller']).'.php'))
									{
										$file = $this->base_url.'/controllers/'.strtolower($child['controller']).'.php';
									}
									elseif(file_exists($this->base_url.'/'.strtolower($child['controller']).'.php'))
									{
										$file = $this->base_url.'/'.strtolower($child['controller']).'.php';
									}
									else
									{
										trigger_error('Unable to find controller.');
									}
								}
								
								// Check if file should be included and if it exits
								if(file_exists($file))
									include_once($file);
								
								
								if(isset($child['controller']) && class_exists($child['controller']))
								{
									$class = $child['controller'];
								}
								
							
								$subslug= (isset($child['slug']))? $child['slug'] : $this->create_slug($child['controller']);
						
								// Add subpage
								add_submenu_page(
										$slug, 
										$child['label'], 
										$child['label'], 
										'manage_options', 
										$subslug, 
										array
										(
											new $class($this),
											'_initCtrl',
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
	
	function shortcode($add){
		$this->shortcode[] = $add;
	}
	
	private function _createShortcode(){
		
		foreach($this->shortcode as $sc){
			
			// Check if the file exists
			if(isset($sc['url']))
			{
				$file = $this->base_url.'/'.$sc['url'];
			}
			else
			{
				if(file_exists($this->base_url.'/controllers/'.strtolower($sc['controller']).'.php'))
				{
					$file = $this->base_url.'/controllers/'.strtolower($sc['controller']).'.php';
				}
				elseif(file_exists($this->base_url.'/'.strtolower($sc['controller']).'.php'))
				{
					$file = $this->base_url.'/'.strtolower($sc['controller']).'.php';
				}
				else
				{
					trigger_error('Unable to find controller. ('.$file.')');
				}
			}
				
			
			if(file_exists($file)){
				
				include_once($file);
				
				if(class_exists($sc['controller']))
				{
					
					add_shortcode($sc['name'],array(new $sc['controller']($this),'_initCtrl'));
				}
			}
			
			
		}
		
	}
	
}


}