<?php

class HomeCtrl
{
    public function first($rota) {
        view()->load('home/first');
    }

    public function front($rota) {

        //dd(auth()->hashPassword('000'));

        /** @var Utilizador $user */
        $user = auth()->haveUserOrReditectTo();
        $dados_para_o_template = [
           'user_obj' => $user,
//            'users' => bd()->fetchAll(USER_TABLE),
        ];

        view()->load('home/dashboard', $dados_para_o_template);
    }
}