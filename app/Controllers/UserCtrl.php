<?php

class UserCtrl
{
    public function perfil($rota) {
        if (auth()->user($user)) {

            view()->load('user/perfil', [
                'user' => $user,
            ]);
        } else
            view()->load('403');
    }

    public function list($rota) {

        $users = bd()->fetchAll(USER_TABLE);

        view()->load('user/list', ['users' => $users]);
    }

    public function show($rota, $id) {

        if (bd()->tryFetchById('utilizador', $id, $user))
            view()->load('user/perfil', [
                'user' => $user,
            ]);
        else view()->redirectWithFlashMsgTo('Utilizador inexistente!', url()->route('users-list'));
    }
}