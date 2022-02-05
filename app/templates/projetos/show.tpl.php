<?php
// tvars(get_defined_vars());

view()->load('base/header');
view()->load('base/navbar');
?>
<div class="mb-3">
    <div class="flash-messages"><?= flash()->get() ?></div>
</div>
<div class="container">
    <div class="row">

        <div class="col">
           show projeto
        </div>

    </div>
</div>

<?php
tvars(get_defined_vars());

view()->load('base/footer');
?>
