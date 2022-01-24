<?php
// tvars(get_defined_vars());

view()->load('base/header');
view()->load('base/navbar');
?>

<div class="container">
    <div class="row">
        <div class="row mb-3">
            <div class="flash-messages"><?= flash()->get() ?></div>
        </div>
        <div class="col"><h1>Lista dos utilizadores</h1></div>
        <table class="table table-striped table-hover">
            <?php
            foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['dh_registo'] ?></td>
                    <td><a href="<?= url()->route('user-show', [$user['id']]) ?>"><i class="fa fa-ellipsis-h"></i></a>
                    </td>
                </tr>
            <?php
            endforeach; ?>
        </table>
    </div>
</div>

<?php
// tvars(get_defined_vars());

view()->load('base/footer');
?>
