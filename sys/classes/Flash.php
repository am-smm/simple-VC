<?php

class Flash
{
    private static $key = 'flash_messages';
    private static $old_values_key = 'old_values';

    private static $types = [
        'error',
        'warning',
        'info',
        'success',
    ];

    /**
     * @var Flash
     */
    private static $single_instance = null;

    /**
     * @return Flash
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

    public function put($msg = '', $type = 'info', $dismissable = true) {

        if (is_array($msg)) {
            foreach ($msg as $m) $this->addMsg($m, $type, ! !$dismissable);
        } else $this->addMsg($msg, $type, ! !$dismissable);

        return $this;
    }

    public function redirect($to, $withData = []) {
        if ( !empty($withData))
            $_SESSION[static::$old_values_key] = $withData;
        redirect($to);
    }

    public function old($clear = true) {
        $result = '';

        if (isset($_SESSION[static::$old_values_key]))
            $result = $_SESSION[static::$old_values_key];

        if ($clear) unset($_SESSION[static::$old_values_key]);

        return $result;
    }

    public function error($message, $dismissable = true) {
        return $this->put($message, 'error', ! !$dismissable);
    }

    public function warning($message, $dismissable = true) {
        return $this->put($message, 'warning', ! !$dismissable);
    }

    public function info($message, $dismissable = true) {
        return $this->put($message, 'info', ! !$dismissable);
    }

    public function success($message, $dismissable = true) {
        return $this->put($message, 'success', ! !$dismissable);
    }

    public function get($type = null, $clear = true) {
        $result = '';

        // $type = null => todas as mensagens registadas
        if ( !is_null($type) && !in_array($type, array_keys($_SESSION[self::$key]))) {
            return $result;
        }

        if (is_null($type)) {
            foreach (array_keys($_SESSION[self::$key]) as $type) {
                $result .= $this->generateByType($type);
            }
        } else $result .= $this->generateByType($type);

        if ($clear) $this->clear($type);

        return $result;
    }

    public function clear($type = null) {
        if (is_null($type))
            $_SESSION[self::$key] = [];
        else
            unset($_SESSION[self::$key][$type]);

        return $this;
    }

    protected function addMsg($msg = '', $type = 'info', $dismissable = true) {
        $msg = trim($msg);

        if (empty($msg) || !in_array($type, self::$types)) {
            return $this;
        }

        if ( !array_key_exists(static::$key, $_SESSION)) {
            $_SESSION[static::$key] = [];
        }

        $_SESSION[static::$key][$type][] = [$dismissable, $msg];

        return $this;
    }

    protected function generateByType($type) {
        $result = '';
        foreach ($_SESSION[self::$key][$type] as $msg_arr) {
            $result .= $this->generateAlert($msg_arr[1], $type, $msg_arr[0]);
        }
        return $result;
    }

    protected function generateAlert($msg = '', $type = 'info', $dismissable = true) {
        $msg = trim($msg);
        $dismissable = $dismissable ? 'alert-dismissible' : '';
        $button = $dismissable
            ? '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
            : '';
        $type = ($type == 'error' ? 'danger' : $type);
        return <<<ALERT
<div class="alert alert-{$type} {$dismissable} fade show" role="alert">
  {$msg}
  {$button}
</div>
ALERT;
    }
}

/**
 * @return Flash
 */
function flash() { return Flash::instance(); }