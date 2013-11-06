<form method='POST' action='/users/p_signup'>

    First Name<br>
    <input type='text' name='first_name' required>
    <br><br>

    Last Name<br>
    <input type='text' name='last_name'  required>
    <br><br>

    Email<br>
    <input type='email' name='email'  required>
    <br><br>

    Password<br>
    <input type='password' name='password'  required>
    <br><br>
	
	<?php if(isset($error)): ?>
	        <div class='error'>
            Sign-up failed.
			<? echo "<br> $error <br> "?>
			<a href='/users/login'>Log in</a>
        </div>
        <br>
    <?php endif; ?>
	
    <input type='submit' value='Sign up' >

</form>

