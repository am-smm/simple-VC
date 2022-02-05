<?php
// tvars(get_defined_vars());

view()->load('base/header');
view()->load('base/navbar');
?>
<div class="mb-3">
    <div class="flash-messages"><?= flash()->get() ?></div>
</div>
<div class="container">
    <div class="row"><h2><?= $title ?></h2></div>
    <div class="row">

        <div class="col"></div>

    </div>
</div>

<?php
// tvars(get_defined_vars());

view()->load('base/footer');
?>
