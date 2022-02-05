<?php

class Projeto
{
    public static function fromDBarray($array = null): Projeto {
        if ( !is_array($array)) return new Projeto();

        return new Projeto(array_get('id', $array, 0),
                           array_get('nome', $array, ''),
                           array_get('descricao', $array, ''),
                           array_get('reg_utilizador_id', $array, 0),
                           array_get('dh_registo', $array, ''),
                           array_get('dh_terminado', $array, ''),
                           array_get('dh_desativado', $array, '')
        );
    }

    //-----------------------------------------------------
    //region ---- Var. de Instância
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $nome;
    /**
     * @var string
     */
    protected $descricao;
    /**
     * @var DateTime | false
     */
    protected $dh_registo;
    /**
     * @var DateTime | false
     */
    protected $dh_terminado;
    /**
     * @var DateTime | false
     */
    protected $dh_desativado;
    /**
     * @var int
     */
    protected $reg_utilizador_id;
    //endregion


    //-----------------------------------------------------
    //region ---- Construtor

    /**
     * @param int $id
     * @param string $nome
     * @param string $descricao
     * @param string $dh_registo
     * @param string $dh_terminado
     * @param string $dh_desativado
     * @param int $reg_utilizador_id
     */
    public function __construct(int    $id = 0,
                                string $nome = '', string $descricao = '',
                                string $dh_registo = '', string $dh_terminado = '', string $dh_desativado = '',
                                int    $reg_utilizador_id = 0
    ) {
        $this->setId($id);
        $this->setNome($nome);
        $this->setDescricao($descricao);
        $this->setDhRegisto($dh_registo);
        $this->setDhTerminado($dh_terminado);
        $this->setDhDesativado($dh_desativado);
        $this->setRegUtilizadorId($reg_utilizador_id);
    }

    //endregion


    //-----------------------------------------------------
    //region ---- Modificadores e interrogadores

    public function getId(): int { return $this->id; }

    /**
     * @param int $id
     * @return static
     */
    public function setId(int $id) {
        $this->id = $id;
        return $this;
    }

    public function getRegUtilizadorId(): int { return $this->reg_utilizador_id; }

    public function setRegUtilizadorId(int $val): Projeto {
        $this->reg_utilizador_id = $val;
        return $this;
    }

    public function getNome(): string { return $this->nome; }

    public function setNome(string $val): Projeto {
        $this->nome = removeEspacosDuplicados($val);
        return $this;
    }

    public function getDescricao(): string { return $this->descricao; }

    public function setDescricao(string $val): Projeto {
        $this->descricao = removeEspacosDuplicados($val);
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDhRegisto() { return $this->dh_registo; }

    public function setDhRegisto(string $dh): Projeto {
        trygetDatetimeFromStr($dh, $date);
        $this->dh_registo = $date;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDhTerminado() { return $this->dh_terminado; }

    public function setDhTerminado(string $dh): Projeto {

        $this->dh_registo = (trygetDatetimeFromStr($dh, $date)
            ? $date : null);
        return $this;
    }

    public function isTerminado(): bool { return ! !$this->dh_terminado; }

    /**
     * @return DateTime|null
     */
    public function getDhDesativado() { return $this->dh_desativado; }

    public function setDhDesativado(string $dh): Projeto {
        $this->dh_desativado = (trygetDatetimeFromStr($dh, $date)
            ? $date : null);
        return $this;
    }

    public function isDesativado(): bool { return ! !$this->dh_desativado; }

    //endregion


    //-----------------------------------------------------
    //region Métodos auxiliares

    public function toArray() {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'descricao' => $this->getDescricao(),
            'reg_utilizador_id' => $this->getRegUtilizadorId(),
            'dh_registo' => $this->getDhRegisto(),
            'dh_terminado' => $this->getDhTerminado(),
            'dh_desativado' => $this->getDhDesativado(),
        ];
    }

    //endregion

}