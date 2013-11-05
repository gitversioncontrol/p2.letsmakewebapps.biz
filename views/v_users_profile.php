

    <h1>Hello <?=$user->first_name;?> .This is your profile.</h1>
	<h3> <a href='/users/edit_profile'>View or Edit Profile</a></h3>
	
	
	<h2>These are your posts with the option to Edit or Delete it: </h2>
	
	<?php foreach($posts as $post): ?>

	<article>
	 This Post was last Modified at:
    <time datetime="<?=Time::display($post['modified'],'Y-m-d G:i')?>">
        <?=Time::display($post['modified'])?>
    </time>
	<p>
	<?=$post['content']?>
	<a href='/posts/Delete/<?=$post['post_id']?>'>Delete</a>
	<a href='/posts/Edit/<?=$post['post_id']?>'>Edit</a>
	</p>
	</article>
	---------------------------------------------------------------------------------------------------------------------------------------------------------------
	<?php endforeach; ?>
	
	




