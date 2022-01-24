<?php
// tvars(get_defined_vars());

view()->load('base/header');
view()->load('base/navbar');
?>

<div class="container">
    <div class="row">

        <div class="col"><h1>Perfil</h1></div>
        <p><a href="<?= url()->to('utilizadores') ?>">Lista de utilizadores</a></p>
    </div>
</div>

<?php
tvars(get_defined_vars());

view()->load('base/footer');
?>
