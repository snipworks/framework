<?php use_helper('html.php') ?>
<?php if ($msg): ?>
    <div class="alert-info alert"><?php echo $msg ?></div>
<?php else: ?>
    <?php if (!$user): ?>
        <div class="alert-info alert">User not found.</div>
    <?php else: ?>
        <?php echo href('/', '<< Back to index') ?><br>
        <form action="/home/edit" method="post"><br/>
            <input type="hidden" name="id" value="<?php echo $user->id ?>">
            <input name="username" type="text"  value="<?php echo $user->username ?>"><br/>
            <input name="password" type="text" placeholder="Password"><br/>
            <button class="btn btn-primary" type="submit">Update</button><br/>
        </form>
    <?php endif; ?>
<?php endif ?>

