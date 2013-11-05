
	<h2>
	<div id="center">
	Hello <?=$user->first_name;?> .<a href='/users/edit_profile'>View or Edit Profile</a>
	</div>
	</h2>
	
	
<div id="posts">
	
	<p>
	These are your posts with the option to Edit or Delete it:
	<?php foreach($posts as $post): ?>
	<p>-----------------------------------------------------------------------------------------------------------</p>
	<p>
	  This Post was last Modified at:
    <time datetime="<?=Time::display($post['modified'],'Y-m-d G:i')?>">
        <?=Time::display($post['modified'])?>
    </time>
	</p>
	<p>
	<?=$post['content']?>
	<a href='/posts/Delete/<?=$post['post_id']?>'>Delete</a>
	<a href='/posts/Edit/<?=$post['post_id']?>'>Edit</a>
	</p>
	
	
	<?php endforeach; ?>
	
</div>


</p>

