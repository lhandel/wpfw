<?php
/*
Plugin Name: WPFW Plugin
Description: MVC framework for wordpress plugins
Author: Ludwig Händel
Version: 0.1
Author URI: http://ludwighandel.se
*/



include_once(dirname(__FILE__).'/libraries/WPFW/WPFW.php');



$config['environment'] = 'development';
$config['base_url'] = dirname(__FILE__);
$app = new WPFW($config);

$app->admin_menu(array(
						array
						(
							'label'			=>'Your Plugin',
							'controller'	=>'testCtrl',
							'order'			=>44,
							'children'		=> array
							(
								array
								(
									'label'		=>'Subpage1',
									'controller'=>'child2Controller',
								)
							)
						)
				));
		
$app->shortcode(array
				(
					'name'			=>'testPlugin',
					'controller'	=>'startController',
				));
		
		
		
// Execute plugin
$app->run();


//$bm->marker('shotdown');
//echo 'Benchmark '.$bm->elapsed_time('init','shotdown');