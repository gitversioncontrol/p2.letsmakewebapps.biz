				
		<div id="center"> <h1>Welcome to <?=APP_NAME?><?php if($user) echo ', '.$user->first_name; ?></h1> </div>
		<?php if($user): ?>	
				<div id="landing">
				
				<p> Would like to add a new post? <a href='/posts/add'>New-Post</a> </p>
				<br>
				<p>Want to see posts sent by friends you follow ? <a href='/posts'>View-Chats</a> </p>
				<br>
				<p>Don't like posts of someone or missing posts from a special one?  <a href='/posts/users'>Manage-Pals</a> </p>
				<br>
				<p>Want to see posts sent by you and your profile ? <a href='/users/profile'>Profile</a> </p>
				</div>
				
		<!-- Menu options for users who are not logged in -->
        <?php else: ?>
		<div id="top">
		 <a href='/users/login'>Log in</a>
		 <a href='/users/signup'>Sign up</a>
         </div>
         
	
		 
		 <div  id="right"> 
		<h3>Are you a new chatter? <a href='/users/signup'>Sign up</a>	</h3>
		<?=$login_module?>
		</div>	

	    
		 <div  id="left"> 
		
		<p>Join Chatter-Box to chat and post your valuable ideas,gossips and banters with your friends out there.
		Unlike some new *.gov sites :),we encrypt your password and security tokens on the backend.</p>
		<p>Also,for your convenience we have worked hard to add these +1 ideas.
		Hmm,Alright,yes these were added in the hopes of an 'A' grade.</p>
		+1 Edit your posts.<br>
		+1 Delete your posts.
		
		</div>	
		
		<?php endif; ?>
		
		
		
		
		
