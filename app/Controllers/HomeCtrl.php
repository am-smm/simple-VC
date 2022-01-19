<?php

class HomeCtrl
{
    public function first($rota) {
        view()->load('home/first');
    }

    public function front($rota) {

        $user = auth()->force();
        $dados_para_o_template = [
            'user' => $user,
            'users' => bd()->fetchQuery("SELECT * FROM auth;"),
        ];

        view()->load('home/home', $dados_para_o_template);
    }
}