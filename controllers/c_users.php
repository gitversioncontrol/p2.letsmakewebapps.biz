<?php
class users_controller extends base_controller {

	public $error_provided;
		
    public function __construct() {
        parent::__construct();
	    //echo "users_controller construct called<br><br>";
		
    } 

    public function index() {
       // echo "This is the index page";
	   Router::redirect("/");
    }

    public function signup($error=null) {
       // echo "This is the signup page";
		//RemindeR:Add Styles here for signup page
		$this->template->content=View::instance('v_users_signup');
		$this->template->title="Sign up";
		#Error Condition
		$this->template->content->error=$error;
		
		//Render Template
		echo $this->template;
    }
	
	public function p_signup(){
		//print_r($_POST);
		# Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
		
		//Time stamp for created and Modified columns
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
		
		//Password Encryption using Crypt 
		$_POST['password'] = crypt($_POST['password'],PASSWORD_SALT);
		
		//Token generation and encryption using email address
		$_POST['token'] = crypt($_POST['email'],TOKEN_SALT).Utils::generate_random_string();
		
		//Search for exisiting userid/email
		$q="select email from users where email='".$_POST['email']."'";
		//echo $q;
		$userid=DB::instance(DB_NAME)->select_field($q);
		
		if(! $userid){
		
		//print_r($_POST);
		DB::instance(DB_NAME)->insert('users',$_POST);
		
		# For now, just confirm they've signed up - 
		# You should eventually make a proper View for this
		//echo 'You\'re signed up';Please login.
		$msg="Signup is successful.Please proceed with log-in.";
		Router::redirect("/users/login/$msg");
		}
		else{
		 //Send them back to the Sign-up page
				//$this->error_generate(); //To pass corresponding error message
		$error_received="User-id ".$_POST['email']." is already registered.Please log-in";
		//echo $error_received;
		Router::redirect("/users/signup/$error_received");
		}
		
	}
	
	
    public function login($error_passed=null) {
		# Settle Login View
		$this->template->content=View::instance('v_users_login');
		$this->template->title="Log in";
		
		#Error Condition
		$this->template->content->error=$error_passed;
		
		# Render template
        echo $this->template;
		       	
	 }
		
		
	public function p_login(){
	
			 # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
			$_POST = DB::instance(DB_NAME)->sanitize($_POST);
			
			$password_received=crypt($_POST['password'],PASSWORD_SALT); //Crypt the password to match it with db entry
			//echo $password_received;
			$q="select token from users 
				where email='".$_POST['email']."'
				and password='$password_received' ";
			

			//echo $q;
			
			$token=DB::instance(DB_NAME)->select_field($q);
	
		//	echo "$token <br>";
	
			if($token){
			setcookie("token", $token, strtotime('+1 year'), '/'); //Store this token in a cookie using setcookie()
			//echo "Logged in Successfully <br>";
			//echo "Token cookie settled as :".$_COOKIE['token'];
			# Send them to the main page - or whever you want them to go
			Router::redirect("/");
			
			}
			else{
			
				# Send them back to the login page
				$this->error_msg(); //To pass corresponding error message
				Router::redirect("/users/login/$this->error_provided");
			}
			
	}
	
	public function error_msg(){
			$q_findemail="select email from users where email='".$_POST['email']."'" ;
			
			$username=DB::instance(DB_NAME)->select_field($q_findemail);
		
			if(!$username){
			$this->error_provided="Username ". $_POST['email']."  is not present";
			}
			else
			{
			$this->error_provided="Password supplied for user  is incorrect";
			}
		
	}

    public function logout() {
        
		$existing_token=$this->user->token;
		
		# Generate and save a new token for next login
		$new_token=crypt($this->user->email,TOKEN_SALT).Utils::generate_random_string();
		
		# Create the data array we'll use with the update method
		# In this case, we're only updating one field, so our array only has one entry
		$data = Array("token" => $new_token);

		
		# Do the update
		DB::instance(DB_NAME)->update("users", $data, "WHERE token = '$existing_token'");

		# Delete their token cookie by setting it to a date in the past - effectively logging them out
		setcookie("token", "", strtotime('-1 year'), '/');

		# Send them back to the main index.
		Router::redirect("/");
		#Insert new to database
		//echo $new_token;
    }

    public function profile() {
	
		
		if ($this->user){
		//print_r($this->user);
		$this->template->content=View::instance('v_users_profile');
		$this->template->title="Profile of ".$this->user->first_name;
		
		//Posts for this user
		$this->template->content->posts=$this->post->get_post_for_user($this->user->user_id);
		//print_r($this->post->get_post_for_user($this->user->user_id));
		echo $this->template;
		
		//See your own posts and edit/delete them.
		//$this->$postsobj->get;
		
		//echo " This is the profile for ". $this->user->first_name;
		}
		else{
		$error="Please  first log-in to check profile page.";
		Router::redirect("/users/login/$error");
		}
	
    }
	
	public function edit_profile(){
	
	
	}

} # end of the class