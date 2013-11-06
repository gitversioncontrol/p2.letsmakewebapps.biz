

<h1>Edit post:<h1>

<p>Existing post is: <?=$post_content?> </p>

<form method='POST' action='/posts/p_edit/<?=$post_id?>'>

    <label for='content'>Edit Post:</label><br>
    <textarea name='content' id='content' required></textarea>

    <br><br>
    <input type='submit' value='Edit post'>

</form> 