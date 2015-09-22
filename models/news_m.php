<?php
class news_m extends WPModel{

	
	function getAll(){
		return $this->wpdb->get_results('THE QUERY');
	}
	
}