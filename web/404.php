<?php /** @var Exception $exception */ ?>
<div style="margin: 20px auto; min-width: 500px; width: 80%;">
    <h2>Oops! <small>An error has occurred</small></h2>
    Page <?php echo $_SERVER['REQUEST_URI'] ?> was not found.
    <br/><br/><hr/>
    <?php if (isset($exception)): ?>
        <a style="float: right" href="<?php echo url('/') ?>">@framework</a>
        <pre><?php echo $exception->getMessage() ?></pre>
    <?php endif ?>
</div>
