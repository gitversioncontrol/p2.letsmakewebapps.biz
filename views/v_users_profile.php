
<h2>
	<div id="top">
	Hello <?=$user->first_name;?> 
	</div>
</h2>
	
	
<div id="posts">
	
	<p>
	These are your posts with the option to Edit or Delete it:
	</p>
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




