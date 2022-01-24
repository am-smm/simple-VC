<?php
// tvars(get_defined_vars());

view()->load('base/header');

?>
<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>

<div class="container p404">
    <div class="row mb-3">
        <div class="flash-messages"><?= flash()->get() ?></div>
    </div>
    <div class="row">

        <div class="col-sm-12 col-lg-6"><h1> Root / </h1>

            <h4> DDL </h4>
            <pre class="prettyprint"><?php
                require PUBLIC_PATH . 'material/bd/smm_tarefas_DDL.sql' ?></pre>
        </div>
        <div class="col-sm-12 col-lg-6">
            <h4>Links</h4>
            <p><a href="https://getbootstrap.com/docs/5.1/getting-started/introduction/">Bootstrap</a></p>
            <p><a href="https://fontawesome.bootstrapcheatsheets.com/">FONT AWESOME</a></p>
            <p><a href="https://www.flaticon.com/">Icons</a></p>
            <p><a href="https://api.jquery.com/">jQuery</a></p>
            <p>Dados gerados com <a href="https://generatedata.com/">https://generatedata.com</a></p>
            <p><br></p>
            <img src="<?= PUBLIC_URL ?>material/bd/smm_tarefas_ER_all.png" class="img-fluid" alt="ER">
            <p><br></p>
            <a href="<?= ASSETS_URL ?>lap.sql" download>DDL + Dados (SQL create script)</a>
            <p><br></p>
            <h3><a href="<?= url()->to('home') ?>">Home...</a></h3>
        </div>
    </div>
</div>
<?php
// tvars(get_defined_vars());

view()->load('base/footer')
?>
