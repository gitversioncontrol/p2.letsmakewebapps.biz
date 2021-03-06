<?php 
class posts_controller extends base_controller{
	public $postid;
	
	 public function __construct() {
		parent::__construct();
		# Make sure user is logged in if they want to use anything in this controller
		if(!$this->user) {
		die("Members only. <a href='/users/login'>Login</a>");
		}
	}

    public function add() {
        # Setup view
        $this->template->content = View::instance('v_posts_add');
        $this->template->title   = "New Post";

        # Render template
        echo $this->template;
    }

    public function p_add() {
		# Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
	
        # Associate this post with this user
        $_POST['user_id']  = $this->user->user_id;

        # Unix timestamp of when this post was created / modified
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();

        # Insert
        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        DB::instance(DB_NAME)->insert('posts', $_POST);

        # Route to Profile page to show addition of post
      	Router::redirect("/users/profile");
    }
	
	public function delete($post_id){	
		#Delete Post
		$this->post->delete_post($post_id);
		
		# Route to Profile page to posts
		Router::redirect("/users/profile");
	}
	
	public function edit($post_id){
		# Setup view
		$this->template->content=View::instance('v_posts_edit');
		$this->template->title   = "Edit Post";
		$this->template->content->post_id=$post_id;
		
		#Get Single post
		$single_post=$this->post->get_single_post($post_id);
		
		$this->template->content->post_content=$single_post[0]['content'];
		echo $this->template;
	}
	
	public function p_edit($post_id){
	 # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
		//Change modified time and content for post in db
		$_POST['modified'] = Time::now();
		$data = Array("modified" => $_POST['modified'],
					  "content" => $_POST['content'] );
	
		# Call Post Library edit_post()
		$this->post->edit_post($data,$post_id);
		
		#Route back to profile page to show edited post
		Router::redirect("/users/profile");
	
	}
	
	
	
	
	public function index() { //Default method of posts controller to show all posts sent by yourself
		# Set up the View
		$this->template->content = View::instance('v_posts_index');
		$this->template->title   = "Posts";

		# Build the query ,this is one way
		/*$q = "SELECT 
				posts .* , 
				users.first_name, 
				users.last_name
			FROM posts
			INNER JOIN users 
				ON posts.user_id = users.user_id";*/
		
		# Using this query
		$q='select uu.user_id_followed ,p.content,u.first_name ,u.last_name,p.created,p.modified
			from users u,posts p,users_users uu
			where uu.user_id_followed=u.user_id
			and p.user_id=u.user_id
			and uu.user_id='.$this->user->user_id;				
		
		
		# Run the query to get posts
		$posts = DB::instance(DB_NAME)->select_rows($q);

		# Pass data to the View
		$this->template->content->posts = $posts;

		# Render the View
		echo $this->template;

	}
	
	
	public function users() {

		# Set up the View
		$this->template->content = View::instance("v_posts_users");
		$this->template->title   = "Users";

		# Build the query to get all the users
		$q = "SELECT *
			FROM users";

		# Execute the query to get all the users. 
		# Store the result array in the variable $users
		$users = DB::instance(DB_NAME)->select_rows($q);

		# Build the query to figure out what connections does this user already have? 
		# I.e. who are they following
		$q = "SELECT * 
			FROM users_users
			WHERE user_id = ".$this->user->user_id;

		# Execute this query with the select_array method
		# select_array will return our results in an array and use the "users_id_followed" field as the index.
		# This will come in handy when we get to the view
		# Store our results (an array) in the variable $connections
		$connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

		# Pass data (users and connections) to the view
		$this->template->content->users       = $users;
		$this->template->content->connections = $connections;

		# Render the view
		echo $this->template;
	}
	
	
	public function follow($user_id_followed) {

		# Prepare the data array to be inserted
		$data = Array(
			"created" => Time::now(),
			"user_id" => $this->user->user_id,
			"user_id_followed" => $user_id_followed
			);

		# Do the insert
		DB::instance(DB_NAME)->insert('users_users', $data);

		# Send them back
		Router::redirect("/posts/users");

	}
	
	
	public function unfollow($user_id_followed) {

		# Delete this connection
		$where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
		DB::instance(DB_NAME)->delete('users_users', $where_condition);

		# Send them back
		Router::redirect("/posts/users");

	}


} #EOC