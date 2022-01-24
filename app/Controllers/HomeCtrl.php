<?php

class HomeCtrl
{
    public function first($rota) {
        view()->load('home/first');
    }

    public function front($rota) {

        //dd(auth()->hashPassword('000'));

        $user = auth()->haveUserOrReditectTo();
        $dados_para_o_template = [
            'user' => $user,
            'users' => bd()->fetchAll(USER_TABLE),
        ];

        view()->load('home/home', $dados_para_o_template);
    }
}