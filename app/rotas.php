<?php
require_once APP_CONTROLLERS . 'HomeCtrl.php';
require_once APP_CONTROLLERS . 'AuthCtrl.php';
require_once APP_CONTROLLERS . 'UserCtrl.php';
require_once APP_CONTROLLERS . 'ProjetoCtrl.php';

route('/', [new HomeCtrl(), 'first']);
route('home', [new HomeCtrl(), 'front']);

route('login', [new AuthCtrl(), 'get_login']);
route('auth', [new AuthCtrl(), 'post_login']);
route('logout', [new AuthCtrl(), 'get_logout']);
route('perfil', [new UserCtrl(), 'perfil']);
route('utilizadores', [new UserCtrl(), 'list'], 'users-list');
route('utilizadores/(id)', [new UserCtrl(), 'show'], 'user-show');

route('projetos', [new ProjetoCtrl(), 'list_all'])->setName('prj_list_all');
route('projetos/em-curso', [new ProjetoCtrl(), 'list_em_curso'])->setName('prj_list_em_curso');
route('projetos/concluidos', [new ProjetoCtrl(), 'list_concluidos'])->setName('prj_list_concluidos');
route('projetos/(id)', [new ProjetoCtrl(), 'show'])->setName('prj_show');

route('projetos/novo', [new ProjetoCtrl(), 'get_new'])->setName('prj_get_new');
route('projetos/registar', [new ProjetoCtrl(), 'post_new'])->setName('prj_post_new');

