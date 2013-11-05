<?php
class practice_controller extends base_controller{
# Our SQL command


	public $q = "Delete from users where 
    first_name = 'Samual'
   And last_name = 'Seaborn'
    And email = 'seaborn@white.gov'";
	
	
	//public $q2="select last_name from users where first_name='cheeku' or '1=1'";
	
	public $first_name="cheeku' or '1=1";
	
	
	// Run the command
	public function test(){
	//Santize test using a bad query:
	//	$data=$this->first_name;
	 $data=DB::instance(DB_NAME)->sanitize($this->first_name) ;
	 $q2="select last_name from users where first_name='$data'";
	//echo DB::instance(DB_NAME)->query($this->q);
	//print_r( DB::instance(DB_NAME)->query($this->q2));
	$result=DB::instance(DB_NAME)->select_field($q2);
	echo "query is: $q2 <br>";
	
	//Sanitized query
	//$q2_sanitized= DB::instance(DB_NAME)->sanitize($q2) ;
	//$result=DB::instance(DB_NAME)->select_field($q2_sanitized);
	//echo "query is: $this->q2_sanitized <br>";
	//print_r  ($result);
	echo $result;
	
	/*foreach($result as $key=>$value){
	echo  "$key has $value<br>";
	print_r($value);
	}*/
	//echo "hello";
	}
	

	
	
	/*public function insertUser($firstname,$lastname,$username=null,$password=null){
	$data=array('first_name'=>$firstname,
				'last_name'=>$lastname);
	echo DB::instance(DB_NAME)->insert('users',$data);
	
	}*/



}
?>