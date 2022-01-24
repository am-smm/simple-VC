<?php
require_once APP_CONTROLLERS . 'HomeCtrl.php';
require_once APP_CONTROLLERS . 'AuthCtrl.php';
require_once APP_CONTROLLERS . 'UserCtrl.php';

route('/', [new HomeCtrl(), 'first']);
route('home', [new HomeCtrl(), 'front']);

route('login', [new AuthCtrl(), 'get_login']);
route('auth', [new AuthCtrl(), 'post_login']);
route('logout', [new AuthCtrl(), 'get_logout']);
route('perfil', [new UserCtrl(), 'perfil']);
route('utilizadores', [new UserCtrl(), 'list'], 'users-list');
route('utilizadores/(id)', [new UserCtrl(), 'show'], 'user-show');