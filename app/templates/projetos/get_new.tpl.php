<?php
// tvars(get_defined_vars());

view()->load('base/header');
view()->load('base/navbar');
?>
<div class="mb-3">
    <div class="flash-messages"><?= flash()->get() ?></div>
</div>

<div class="container editar editar-projeto">
    <div class="row mb-4">
        <div class="col-xs-8 col-lg-4 pag-title">Novo Projeto</div>
    </div>

    <form action="<?= url()->route('prj_post_new') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $elem['id'] ?>"/>
        <div class="row">

            <div class="col-12">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome"
                           name="nome" value="<?= $elem['nome'] ?? '' ?>">
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label for="nome" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao"
                              name="descricao"><?= $elem['descricao'] ?? '' ?></textarea>
                </div>
            </div>

        </div>
        <div class="row mt-3">
            <div class="col-8"></div>
            <div class="col-2">
                <a href="<?= url()->route('prj_list_em_curso') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-success" name="guardare"><i
                            class="fas fa-check"></i></button>
            </div>
        </div>
    </form>

</div>

<?php
tvars(get_defined_vars());

view()->load('base/footer');
?>
