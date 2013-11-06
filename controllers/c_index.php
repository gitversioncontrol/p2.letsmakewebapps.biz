<?php

class index_controller extends base_controller {
	
	public function __construct() {
		parent::__construct();
	} 
		
	public function index() {//Default function called for site
		
		# Any method that loads a view will commonly start with this
		# First, set the content of the template with a view file
		$this->template->content = View::instance('v_index_index');
		
		# Now set the <title> tag
		$this->template->title = "Chatter-Box";
	
		# CSS/JS includes
			/*
			$client_files_head = Array("");
	    	$this->template->client_files_head = Utils::load_client_files($client_files);
	    	
	    	$client_files_body = Array("");
	    	$this->template->client_files_body = Utils::load_client_files($client_files_body);   
	    	*/
	     
		# To have Login form on front page		 
		$this->template->content->login_module= View::instance('v_users_login');			     		
		# Render the view
		echo $this->template;

	} # End of method
	
	
} # End of class
