<?php
require_once APP_MODELS . 'User.php';

class Auth
{
    private static $key = 'auth';
    private static $hash = '@gb-am-2022';

    /**
     * @var Auth
     */
    private static $single_instance = null;

    /**
     * @return Auth
     */
    public static function instance() {
        static::$single_instance = static::$single_instance ?? new static();
        return static::$single_instance;
    }

    private function __construct() {
        if ( !array_key_exists(static::$key, $_SESSION)) {
            $_SESSION[static::$key] = [];
        }
    }

    /**
     * @param User|null $user
     * @return int $user_id | 0
     */
    public function user(&$user) {
        $result = 0;
        $user = null;

        if (array_key_exists(static::$key, $_SESSION) && $_SESSION[static::$key]) {
            /** @var User $user */
            $user = User::fromJson($_SESSION[static::$key]);
            $result = $user->getId();
        }

        return $result;
    }

    public function login(string $username, string $pass) {

        $sql = "SELECT * FROM auth WHERE username=:un AND pass=:psw ;";
        $users = bd()->fetchQuery($sql, [
            'un' => $username,
            'psw' => hash('sha256', self::$hash . $pass),
        ]);

        if (count($users)) {

            $auth_user = User::fromDBarray($users[0]);
            $_SESSION[static::$key] = $auth_user->toJson();

            return $auth_user;
        }
        return false;
    }

    public function force() {
        if ( $this->user($user) ) return $user;

        header("Location: " . WEBROOT . 'login');
        die();
    }

    public function logout() {
        $_SESSION[self::$key] = false;
        return $this;
    }
}

/**
 * @return Auth
 */
function auth() { return Auth::instance(); }