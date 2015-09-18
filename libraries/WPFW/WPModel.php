<?php
class WPModel  {
	
	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = '';
	protected $_order_type = '';
	
	public $wpdb = null;
	
	public function __construct(){
		global $wpdb;
		
		$this->wpdb = $wpdb;
	}
		
	
}