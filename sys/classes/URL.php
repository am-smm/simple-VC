<?php

class URL
{
    /**
     * @var URL
     */
    private static $si = null;

    /**
     * @return URL
     */
    public static function instance() { return static::$si ?? new static(); }

    private function __construct() { }

    function to($str, $tail = '') { return WEBROOT . trim($str, '/ ') . DIRECTORY_SEPARATOR . $tail; }

    /**
     * @throws Exception
     */
    function route(string $name, $params = []) {
        $res = WEBROOT;

        if (Dispatcher::instance()->tryGetRouteByName($name, $rota)) {
            $url = [];
            $arr = preg_split('/\//', $rota->getUrlPath(), -1, PREG_SPLIT_NO_EMPTY);
            $found = array_filter($arr, function ($item) {
                return $item == '(id)';
            });
            if (count($found) != count($params))
                throw new Exception(sprintf('Parâmetros incoerentes para a rota %s. Necessários: %s :: Fornecidos: %s',
                                            $name, count($found), count($params)));
            foreach ($arr as $item) {
                if ($item == '(id)') {
                    $val = array_shift($params);
                    if (empty($val))
                        throw new Exception(sprintf('Parâmetros em falta para a rota %s. Necessários: %s :: Fornecidos: %s',
                                                    $name, count($found), count($params)));
                    elseif ( !is_numeric($val))
                        throw new Exception(sprintf('Parâmetro não numérico fornecido para a rota %s. (%s)',
                                                    $name, $val));
                    else $url[] = $val;
                } else $url[] = $item;
            }

            return implode('/', $url);
        }
        flash()->error('Rota inexistente: ' . $name);
        return $res;
    }

    function isCurrent($str) { return Dispatcher::instance()->isCurrentUrlContaining($str); }

    function classeIf($str, $class = 'active') { return $this->isCurrent($str) ? $class : ''; }
}

function url(): URL { return URL::instance(); }
