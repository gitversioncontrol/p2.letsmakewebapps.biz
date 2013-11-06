<?php foreach($posts as $post): ?>

<article>
 <p>
 At:  <time datetime="<?=Time::display($post['modified'],'Y-m-d G:i')?>"> <?=Time::display($post['modified'])?></time> ,
<?=$post['first_name']?> <?=$post['last_name']?> has posted:
<?=$post['content']?>
</p>
</article>

<?php endforeach; ?>