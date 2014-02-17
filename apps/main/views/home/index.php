<?php use_helper('html.php') ?>
<a href="/home/create" class="btn btn-primary">Create</a><br/><br/>
<?php if (!$users): ?>
    <div class="alert alert-danger">No user(s) found.</div>
<?php else: ?>
    <?php if ($msg): ?>
        <div class="alert alert-info"><?php echo $msg ?></div><br/><br/>
    <?php endif ?>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th colspan="2">Password (encrypted)</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td>
                    <a href="/home/edit?id=<?php echo $user->id ?>"><?php echo $user->id ?></a>
                </td>
                <td><?php echo $user->username ?></td>
                <td><?php echo $user->password ?></td>
                <td>
                    <a href="/home/edit?id=<?php echo $user->id ?>" class="btn">Edit</a>
                    <a href="/home/delete?id=<?php echo $user->id ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif ?>