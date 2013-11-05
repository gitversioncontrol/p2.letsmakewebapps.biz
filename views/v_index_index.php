		<?php if($user): ?>	
				<a href='/posts/add'>New-Post</a>
				<a href='/posts'>View-Chats</a>
				<a href='/posts/users'>Manage-Pals</a>
				<a href='/users/profile'>Profile</a>
		<?php endif; ?>
		
		<h1>Welcome to <?=APP_NAME?><?php if($user) echo ', '.$user->first_name; ?></h1>
