<?php

require_once SYS_CLASSES . 'AbsUser.php';

function isUserClassDefined(): bool {
    return defined('USER_CLASS') && USER_CLASS && file_exists(APP_MODELS . USER_CLASS . '.php');
}

if (isUserClassDefined())
    require_once APP_MODELS . USER_CLASS . '.php';

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
     * @param AbsUser|null $user
     * @return int $user_id | 0
     */
    public function user(&$user) {
        $result = 0;
        $user = null;

        if (array_key_exists(static::$key, $_SESSION) && $_SESSION[static::$key]) {

            $user = call_user_func_array([USER_CLASS, 'fromJson'], [$_SESSION[static::$key]]);
            if ($user instanceof AbsUser) $result = $user->getId();
        }

        return $result;
    }

    public function login(string $username, string $pass) {

        $useClassName = USER_CLASS;
        /** @var AbsUser $user */
        $user = new $useClassName;

        $sql = sprintf("SELECT * FROM %s WHERE (%s=:un OR %s=:em) AND %s=:psw ;",
                       $useClassName,
                       $user->getUsernameFieldName(),
                       $user->getEmailFieldName(),
                       $user->getPasswordField()
        );
        $users = bd()->fetchQuery($sql, [
            'un' => $username,
            'em' => $username,
            'psw' => $this->hashPassword($pass),
        ]);

        if (count($users)) {
            $auth_user = call_user_func_array([USER_CLASS, 'fromDBarray'], [$users[0]]);
            if ($auth_user instanceof AbsUser) $_SESSION[static::$key] = $auth_user->toJson();
            return $auth_user;
        }
        return false;
    }

    public function haveUserOrReditectTo($to = 'login') {

        if ( !isUserClassDefined()) return false;
        if ($this->user($user)) return $user;
        redirect($to);
    }

    public function logout() {
        $_SESSION[self::$key] = false;
        return $this;
    }

    public function hashPassword($str) { return hash('sha256', self::$hash . $str); }
}

/**
 * @return Auth
 */
function auth() { return Auth::instance(); }