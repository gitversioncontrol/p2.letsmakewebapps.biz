<?php
class Post{
	
	
	public function __construct($posts_table = 'posts') {
		
		$this->posts_table = $posts_table;
	
	}
	
	public function get_single_post($post_id){//get a particular post using post id
		$q = 'SELECT *
				FROM posts
				WHERE post_id = '.$post_id;
		
		$posts = DB::instance(DB_NAME)->select_rows($q);	
		return $posts;
	}
	
	
	public function get_post_for_user($user_id){ //get All posts posted by logged in User
		$q = 'SELECT *
				FROM posts
				WHERE user_id = '.$user_id;
			
		$posts = DB::instance(DB_NAME)->select_rows($q);
		
		return $posts;
	}
	
	public function delete_post($post_id){//Delete post using post_id
		
		$where_condition="WHERE post_id = '$post_id'";
		
		DB::instance(DB_NAME)->delete($this->posts_table, $where_condition);
			
	}
	
	public function edit_post($data,$post_id){//Edit post using post_id with the data needs to be updated.
		
		# Do the update
		DB::instance(DB_NAME)->update($this->posts_table, $data, "WHERE post_id = '$post_id'");
	}
	
}
