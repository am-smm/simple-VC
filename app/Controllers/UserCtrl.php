<?php

class UserCtrl
{
    public function perfil($rota) {
        if (auth()->user($user)) {

            $cliente = false;
            $colab = false;
            /** @var User $user */
            if ($user->isCliente()) {
                $cliente = bd()->fetchById("cliente", $user->getMemberId());
            } elseif ($user->isColaborador())
                $colab = bd()->fetchById("colaborador", $user->getMemberId());

            view()->load('user/perfil', [
                'user' => $user,
                'cliente' => $cliente,
                'colab' => $colab,
            ]);
        } else
            view()->load('403');
    }
}