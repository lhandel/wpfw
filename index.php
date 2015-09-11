<?php
/*
Plugin Name: WPFW Plugin
Plugin URI: #	#
Description: _#_
Author: Ludwig Händel
Version: 0.1
Author URI: http://ludwighandel.se
*/






if(!class_exists('WPFW'))
	include_once(dirname(__FILE__).'/libraries/WPFW/WPFW.php');


class Test2 extends WPFW{
	
	public function __construct($data){
	
		parent::__construct($data);
		
		$this->addMenuPage(array(
			array
			(
				'label'			=>'Test Plugin 2',
				'controller'	=>'startController3',
				'order'			=>41,
				'badge'			=>2
			),
			array
			(
				'label'			=>'Test Controller',
				'controller'	=>'testCtrl',
				'order'			=>42
			)
		));
		
		// Add the pages
		
		$this->createMenu();
	}
	
	public function runMenu(){
		echo 'assad';
		
	}
	
}

$config = array
			(
				'plugin_url'	=> plugins_url('',__FILE__),
				'base_url'		=> dirname(__FILE__),
			);

$test2 = new Test2($config);


//$bm->marker('shotdown');
//echo 'Benchmark '.$bm->elapsed_time('init','shotdown');