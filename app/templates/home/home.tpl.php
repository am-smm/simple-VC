<?php
// tvars(get_defined_vars());

view()->load('base/header');
view()->load('base/navbar');
?>

<div class="container p404">
    <div class="row mb-3">
        <div class="flash-messages"><?= flash()->get() ?></div>
    </div>
    <div class="row">

        <div class="col"><h1>Home</h1></div>

    </div>
</div>

<?php
tvars(get_defined_vars());

view()->load('base/footer');
?>
