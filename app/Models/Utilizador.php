<?php
require_once SYS_CLASSES . 'AbsUser.php';

class Utilizador extends AbsUser
{

    public static function fromDBarray($array): Utilizador {
        if ( !is_array($array)) return new Utilizador();

        return new Utilizador(array_get('id', $array, 0),
                              array_get('username', $array, ''),
                              '',
                              array_get('email', $array, ''),
                              array_get('grp', $array, 0),
                              array_get('is_logged', $array, 0),
                              array_get('dh_last_login', $array, ''),
                              array_get('dh_registo', $array, '')
        );
    }

    //-----------------------------------------------------
    //region ---- Var. de Instância
    /**
     * Herdado:
     * - $id
     * - $username
     * - $pass
     * - $tipo
     */

    /**
     * @var string
     */
    protected $email;
    /**
     * @var DateTime | false
     */
    protected $dh_last_login;
    /**
     * @var bool
     */
    protected $is_logged;
    /**
     * @var DateTime
     */
    protected $dh_registo;
    //endregion


    //-----------------------------------------------------
    //region ---- Construtor

    /**
     * @param int $id
     * @param string $username
     * @param string $pass
     * @param string $email
     * @param int $tipo
     * @param int $is_logged
     * @param string $dh_last_login
     * @param string $dh_registo
     */
    public function __construct(int    $id = 0,
                                string $username = '', string $pass = '',
                                string $email = '',
                                int    $tipo = 0, int $is_logged = 0,
                                string $dh_last_login = '', string $dh_registo = ''
    ) {
        parent::__construct($id, $username, $pass, $tipo);
        $this->setEmail($email);
        $this->setIsLogged($is_logged);
        $this->setDhLastLogin($dh_last_login);
        $this->setDhRegisto($dh_registo);
    }

    //endregion


    //-----------------------------------------------------
    //region ---- Modificadores e interrogadores

    public function getGrp(): int { return $this->getTipo(); }

    public function setGrp(int $grp): Utilizador { return $this->setTipo($grp); }

    public function getEmail(): string { return $this->email; }

    public function setEmail(string $email): Utilizador {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) $this->email = $email;
        return $this;
    }

    public function isLogged(): bool { return $this->is_logged; }

    public function setIsLogged($tf): Utilizador {
        $this->is_logged = ! !$tf;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDhLastLogin() { return $this->dh_last_login; }

    public function setDhLastLogin(string $dh_last_login): Utilizador {
        $this->dh_last_login = (trygetDatetimeFromStr($dh_last_login, $date) ? $date : null);
        return $this;
    }

    public function getDhRegisto(): DateTime { return $this->dh_registo; }

    public function setDhRegisto(string $dh_registo): Utilizador {
        trygetDatetimeFromStr($dh_registo, $date);
        $this->dh_registo = $date;
        return $this;
    }

    //endregion


    //-----------------------------------------------------
    //region Métodos auxiliares

    public function toArray() {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'grp' => $this->getGrp(),
            'email' => $this->getEmail(),
            'is_logged' => $this->isLogged(),
            'dh_last_login' => $this->getDhLastLogin(),
            'dh_registo' => $this->getDhRegisto(),
        ];
    }

    //endregion

}