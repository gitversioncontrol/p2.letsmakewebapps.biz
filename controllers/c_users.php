<?php
class users_controller extends base_controller {

	public $error_provided;
		
    public function __construct() {
        parent::__construct();  
    } 

    public function index() {
       // Route it to Landing page
	   Router::redirect("/");
    }

    public function signup($error=null) { //Error arguments to show on screen
       	
		$this->template->content=View::instance('v_users_signup');
		$this->template->title="Sign up";
		
		#Error Condition
		$this->template->content->error=$error;
									
		//Render Template
		echo $this->template;
    }
	
	public function p_signup(){
		# Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
		
		if (! (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['password'])) ){//When none of the input field by user is empty:
				
			//Time stamp for created and Modified columns
			$_POST['created']  = Time::now();
			$_POST['modified'] = Time::now();
			
			//Password Encryption using Crypt 
			$_POST['password'] = crypt($_POST['password'],PASSWORD_SALT);
			
			//Token generation and encryption using email address
			$_POST['token'] = crypt($_POST['email'],TOKEN_SALT).Utils::generate_random_string();
			
			//Search for existing user-id/email
			$q="select email from users where email='".$_POST['email']."'";
			
			$userid=DB::instance(DB_NAME)->select_field($q);
			
				if(! $userid){ //There is no another userid with same email registered
					#Insert users data in users table
					DB::instance(DB_NAME)->insert('users',$_POST);
					$msg="Signup is successful.Please proceed with log-in.";
					Router::redirect("/users/login/$msg");
				}
				else{//There is already another user registered with same email id
					 //Send them back to the Sign-up page
					$error_received="User-id ".$_POST['email']." is already registered.Please log-in";					
					Router::redirect("/users/signup/$error_received/");
				}
		}
		else{//When any input field is empty
			$error_received="A field can not be empty during sign-up";
			Router::redirect("/users/signup/$error_received/");
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
		
		if (! (empty($_POST['email']) || empty($_POST['password'])) ){//When none of the input field by user is empty
		
				//Crypt the password to match it with db entry
				$password_received=crypt($_POST['password'],PASSWORD_SALT); 
				
				//Build query to get token
				$q="select token from users 
					where email='".$_POST['email']."'
					and password='$password_received' ";				
						
				$token=DB::instance(DB_NAME)->select_field($q);
		

				if($token){//If that user is registered and password matches to bring token
					
					setcookie("token", $token, strtotime('+1 year'), '/'); //Store this token in a cookie using setcookie()
					
					# Send them to the main page
					Router::redirect("/");
				
				}
				else{
					# Send them back to the login page
					$this->error_msg(); //To pass corresponding error message
					Router::redirect("/users/login/$this->error_provided");
				}
		}
		else{//When an input field during login is empty
				$error_sent="Need both email and password to login";
				Router::redirect("/users/login/$error_sent");
		}
			
	}
	
	private function error_msg(){ //Private function called by p_login() to find exact error cause.
		# Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
		
		//Build query to find email/user
		$q_findemail="select email from users where email='".$_POST['email']."'" ;
		
		$username=DB::instance(DB_NAME)->select_field($q_findemail);
	
		if(!$username){ //Check if email is registered
			$this->error_provided="Username ". $_POST['email']."  is not registered";
		}
		else //Email is registered but password supplied by user is incorrect
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
		
    }

    public function profile() {
		
		if ($this->user){//Show profile for logged in user only
		
			$this->template->content=View::instance('v_users_profile');
			$this->template->title="Profile of ".$this->user->first_name;
			
			//Posts for this user by calling post library function
			$this->template->content->posts=$this->post->get_post_for_user($this->user->user_id);
			echo $this->template;
			
		}
		else{
			$error="Please  first log-in to check profile page.";
			Router::redirect("/users/login/$error");
		}
	
    }
	
	

} # end of the class