<?php
require_once APP_MODELS . 'Projeto.php';
require_once APP_MODELS . 'Utilizador.php';

class ProjetoCtrl
{
    public function list_all($rota) {
        view()->load('projetos/list',[
            'title' => 'Lista de todos os projetos'
        ]);
    }
    public function list_em_curso($rota) {
        view()->load('projetos/list',[
            'title' => 'Lista dos projetos em curso'
        ]);
    }
    public function list_concluidos($rota) {
        view()->load('projetos/list',[
            'title' => 'Lista dos projetos concluídos'
        ]);
    }
    public function show($rota) {
        view()->load('projetos/show');
    }

    public function get_new($rota) {
        view()->load('projetos/get_new', ['elem'=>Projeto::fromDBarray()->toArray()]);
    }
    public function post_new($rota) {

        $this->validaOperacao($id, $operacao);
        dd($_POST, $id, $operacao);

    }

    const OP_NEW = 1;
    const OP_UPDATE = 2;
    const OP_DELETE = 3;
    const OP_DEACTIVATE = 4;

    protected function validaOperacao(&$id, &$operacao) {

        $id = getInput('id', 0);

//        Cliente::instance()->tryGetClienteByID($cli_id, $cliente_arr_data)) {
//            flash()->error(sprintf("Cliente <small>%s</small> inexistente!", $cli_id))
//                   ->redirect('clientes');

        if (hasInputKey('guardar')) {
            $operacao = $id?self::OP_UPDATE : self::OP_NEW;
        } elseif (hasInputKey('delete') && $id)
            $operacao = self::OP_DELETE;
        elseif (hasInputKey('desativar') && $id)
            $operacao = self::OP_DEACTIVATE;
        else {
            // operação não definida no <form> ou
            // foi feito um acesso direto pelo browser
            // => redirect
            flash()
                ->error("Operação desconhecida ou não válida.")
                ->redirect(url()->route('prj_list_em_curso'));
        }
    }
}