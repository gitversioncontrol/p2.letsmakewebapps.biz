<form method='POST' action='/users/p_login'>

     Email<br>
    <input type='text' name='email'  required>
    <br><br>

    Password<br>
    <input type='password' name='password'  required>
    <br><br>
	
	<?php if(isset($error)): ?>
	        <div class='error'>
          
			<? echo "<br> $error <br> "?>
        </div>
        <br>
    <?php endif; ?>
	

    <input type='submit' value='Log in'  required>

</form>