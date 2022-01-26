<?php

class AuthCtrl
{
    public function get_login($rota) {
        view()->load('base/login');
    }

    public function get_logout($rota) {
        auth()->logout();
        flash()->success('Bye!', 0);
        redirect();
    }

    public function post_login($rota) {
        $username = getInput('username', '');
        $redirect = 'login';
        $msg = 'Credenciais inválidas.';
        $type = 'error';

        if (auth()->login($username, getInput('password', ''))) {
            $msg = sprintf("Bemvindo %s!", $username);
            $type = 'success';
            $redirect = 'home';
        }

        flash()->put($msg, $type, 0);
        redirect($redirect);
    }
}