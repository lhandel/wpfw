<?php
/*
Plugin Name: WPFW Plugin
Description: MVC framework for wordpress plugins
Author: Ludwig Händel
Version: 0.1
Author URI: http://ludwighandel.se
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
include_once(dirname(__FILE__).'/libraries/WPFW/WPFW.php');



$config['environment'] = 'development';
$app = new WPFW($config);

// Create the admin page
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
		
// Create the shortcode function
$app->shortcode(array
				(
					'name'			=>'testPlugin',
					'controller'	=>'startController',
				));
		
		

// Set style for admin page
$app->admin_style(array('asset/css/admin.css','asset/css/admin.css2'));

// Set style for front page
$app->front_style('asset/css/admin.css');

// Execute plugin
$app->run();





$bm->marker('shotdown');

//echo '<div style="z-index: 9943439;
//right: 0; position:absolute;">Benchmark '.$bm->elapsed_time('init','shotdown').'</div>';