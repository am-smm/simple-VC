<?php

abstract class AbsUser
{
    protected static $tipos = [
        '0' => 'Registado (sem privilégios)',
        '1' => 'Superuser',
    ];

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
    //endregion


    //-----------------------------------------------------
    //region ---- Construtor

    /**
     * @param int $id
     * @param string $username
     * @param string $pass
     * @param int $tipo
     */
    protected function __construct(int    $id = 0,
                                   string $username = '', string $pass = '',
                                   int    $tipo = 0) {
        $this->id = $id;
        $this->username = $username;
        $this->pass = $pass;
        $this->tipo = $tipo;
    }

    /**
     * @return string[]
     */
    public function getTipos(): array { return self::$tipos; }

    /**
     * @return static
     */
    public static function fromDBarray($array) {
        if ( !is_array($array)) return new static();

        return new static(array_get('id', $array, 0),
                          array_get('username', $array, ''),
                          '',
                          array_get('tipo', $array, 0)
        );
    }

    /**
     * @return static
     */
    public static function fromJson($json) {
        return self::fromDBarray(json_decode($json, true));
    }
    //endregion


    //-----------------------------------------------------
    //region ---- Modificadores e interrogadores


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
     * @return static
     */
    public function setId(int $id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string { return $this->username; }

    /**
     * @param string $username
     * @return static
     */
    public function setUsername(string $username) {
        $this->username = strtolower(removeEspacos($username));
        return $this;
    }

    /**
     * @return int
     */
    public function getTipo(): int { return $this->tipo; }

    /**
     * @param int $tipo
     * @return static
     */
    public function setTipo(int $tipo) {
        if (in_array($tipo, $this->getTiposCodigos())) $this->tipo = $tipo;
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
        ];
    }

    public function toJson() {
        return json_encode($this->toArray(), JSON_ERROR_NONE);
    }

    public function isAdmin(): bool { return $this->getTipo() == 1; }

    public function getPasswordField() { return 'psw'; }

    public function getUsernameFieldName() { return 'username'; }

    public function getEmailFieldName() { return 'email'; }

    //endregion
}