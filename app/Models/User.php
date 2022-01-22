<?php

class User
{
    private static $tipos = [
        '0' => 'Registado (sem privilégios)',
        '1' => 'Superuser',
        '10' => 'Cliente',
        '100' => 'Colaborador',
    ];

    public static function fromDBarray($array): User {
        if ( !is_array($array)) return new User();

        return new User(array_get('id', $array, 0),
                        array_get('username', $array, ''),
                        '',
                        array_get('tipo', $array, 0),
                        array_get('member_id', $array, null)
        );
    }

    public static function fromJson($json): User {
        return self::fromDBarray(json_decode($json, true));
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
    protected $username;
    /**
     * @var string
     */
    protected $pass;
    /**
     * @var int
     */
    protected $tipo;
    /**
     * @var int
     */
    protected $member_id;
    //endregion


    //-----------------------------------------------------
    //region ---- Construtor

    /**
     * @param int $id
     * @param string $username
     * @param string $pass
     * @param int $tipo
     * @param ?int $member_id
     */
    public function __construct(int    $id = 0,
                                string $username = '', string $pass = '',
                                int    $tipo = 0, ?int $member_id = null) {
        $this->id = $id;
        $this->username = $username;
        $this->pass = $pass;
        $this->tipo = $tipo;
        $this->member_id = $member_id;
    }

    //endregion


    //-----------------------------------------------------
    //region ---- Modificadores e interrogadores

    /**
     * @return string[]
     */
    public function getTipos(): array { return self::$tipos; }

    /**
     * @return int[]
     */
    public function getTiposCodigos(): array { return array_keys(self::$tipos); }


    /**
     * @return int
     */
    public function getId(): int { return $this->id; }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string { return $this->username; }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User {
        $this->username = strtolower(removeEspacos($username));
        return $this;
    }

    /**
     * @return int
     */
    public function getTipo(): int { return $this->tipo; }

    /**
     * @param int $tipo
     * @return User
     */
    public function setTipo(int $tipo): User {
        if (in_array($tipo, $this->getTiposCodigos())) $this->tipo = $tipo;
        return $this;
    }

    /**
     * @return int
     */
    public function getMemberId(): ?int { return $this->member_id; }

    /**
     * @param ?int $member_id
     * @return User
     */
    public function setMemberId(?int $member_id): User {
        $this->member_id = $member_id;
        return $this;
    }

    //endregion


    //-----------------------------------------------------
    //region Métodos auxiliares

    public function toArray() {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'tipo' => $this->getTipo(),
            'member_id' => $this->getMemberId(),
        ];
    }

    public function toJson() {
        return json_encode($this->toArray(), JSON_ERROR_NONE);
    }

    public function isAdmin(): bool { return $this->getTipo() == 1; }

    public function isCliente(): bool { return $this->getTipo() == 10; }

    public function isColaborador(): bool { return $this->getTipo() == 100; }

    //endregion

}