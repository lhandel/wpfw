<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class validate {

	protected $_config_rules = array();
	
	
	public function __construct($rules=array())
	{
		$this->_config_rules = $rules;
	}
}