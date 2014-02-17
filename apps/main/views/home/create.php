<?php use_helper('html.php') ?>
<?php if ($msg): ?>
    <div class="alert alert-info">
        <?php echo $msg ?>
    </div>
<?php endif ?>
<?php echo href('/', '<< Back to index') ?>
<form action="/home/create" method="post"><br/>
    <input name="username" type="text" placeholder="Username"><br/>
    <input name="password" type="text" placeholder="Password"><br/>
    <button class="btn btn-primary" type="submit">Create</button><br/>
</form>