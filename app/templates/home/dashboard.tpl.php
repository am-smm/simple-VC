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
            <div class="card">
                <img src="<?= ASSETS_URL ?>imgs/prj.png" class="card-img-top" alt="projetos">
                <div class="card-body">
                    <h5 class="card-title">Projectos <span class="badge bg-secondary">34</span></h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col">
                                <a href="<?=url()->route('prj_list_em_curso')?>">Em curso</a>
                            </div>
                            <div class="col text-end"><span class="badge rounded-pill bg-success">23</span></div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col">
                                <a href="<?=url()->route('prj_list_concluidos')?>">Concluídos</a>
                            </div>
                            <div class="col text-end"><span class="badge rounded-pill bg-warning">11</span></div>
                        </div>
                    </li>
                </ul>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <a href="<?=url()->route('prj_list_all')?>" class="btn btn-info"><i class="fas fa-ellipsis-h"></i></a>
                        </div>
                        <div class="col text-end">
                            <a href="<?=url()->route('prj_get_new')?>" class="btn btn-success"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <img src="<?= ASSETS_URL ?>imgs/task.png" class="card-img-top" alt="tarefas">
                <div class="card-body">
                    <h5 class="card-title">Tarefas <span class="badge bg-secondary">34</span></h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col">Integrada em projetos</div>
                            <div class="col text-end"><span class="badge rounded-pill bg-success">12</span></div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col">Isoladas</div>
                            <div class="col text-end"><span class="badge rounded-pill bg-warning">22</span></div>
                        </div>
                    </li>
                </ul>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <a href="#" class="btn btn-info"><i class="fas fa-ellipsis-h"></i></a>
                        </div>
                        <div class="col text-end">
                            <a href="#" class="btn btn-success"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
tvars(get_defined_vars());

view()->load('base/footer');
?>
