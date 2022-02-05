<?php

class Route
{
    /**
     * @param string $urlPath
     * @param mixed $callable
     * @param string $name
     * @return Route
     * @throws Exception
     */
    public static function instance(string $urlPath, $callable, string $name = ''): Route {
        $route = new static($urlPath, $callable, $name);
        Dispatcher::instance()->registerRoute($route);
        return $route;
    }

    // ----------------- Vars de Instância -----------------
    private $urlPath;
    private $name;
    private $requestParams;
    private $callable;
    private $beforeMiddleware;
    private $afterMiddleware;

    /**
     * @param string $urlPath
     * @param mixed $callable
     * @param string $name
     * @return Route
     * @throws Exception
     */
    private function __construct(string $urlPath, array $callable, string $name = '') {
        $this->urlPath = $urlPath;
        $this->callable = $callable;
        $this->beforeMiddleware = [];
        $this->afterMiddleware = [];
        $this->_checkCallable($callable, $urlPath);
        $this->name = $name;
        $this->requestParams = [];
    }

    /**
     * @param $callable
     * @param string $urlPath
     * @throws Exception
     */
    private function _checkCallable($callable, string $urlPath): void {
        if ( !($callable instanceof Closure) && ( !is_array($callable)
                || count($callable) != 2
                || !method_exists($callable[0], $callable[1])))
            throw new Exception(
                sprintf('Rota %s mal definida!' .
                        '<br>No ficheiro "rotas.php" indique ações (ação principal e/ou middlewares before() e after()):' .
                        '<br>— do tipo Closure (funções anónimas);' .
                        '<br>— ou um array com duas posições, na forma:  ["Instância_do_controlador", "nome_do_método"]',
                        $urlPath));
    }

    /**
     * @throws Exception
     */
    private function _callCallable($callable, $params, $flow, $tpl = '403', $tpl_vars = []) {
        if ($callable instanceof Closure)
            $res = $callable($params);
        else
            $res = call_user_func_array($callable, array_merge([$this], $params));

        if ($res === false) {
            $flow_text = 'before';
            if ($flow >= 0) $flow_text = $flow ? 'after' : 'action';
            $tpl_vars['flow'] = $flow_text;
            $tpl_vars['url'] = $this->getUrlPath();
            view()->load($tpl, $tpl_vars);
            exit();
        }
    }

    protected function getCallable() { return $this->callable; }

    protected function getRequestParams() { return $this->requestParams; }

    /**
     * @throws Exception
     */
    public function callAction() {
        $params = $this->getRequestParams();

        foreach ($this->beforeMiddleware as $callable) {
            $this->_callCallable($callable[0], $params, -1, $callable[1], $callable[2]);
        }

        $this->_callCallable($this->getCallable(), $params, 0);

        foreach ($this->afterMiddleware as $callable) {
            $this->_callCallable($callable[0], $params, 1, $callable[1], $callable[2]);
        }
    }

    public function setName($name = ''): Route {
        $this->name = $name;
        Dispatcher::instance()->registerRoute($this);
        return $this;
    }

    /**
     * @throws Exception
     */
    public function before($callable, $tpl = '403', $tpl_vars = []): Route {
        $this->_checkCallable($callable, $this->getUrlPath());
        $this->beforeMiddleware[] = [$callable, $tpl, $tpl_vars];
        return $this;
    }

    /**
     * @throws Exception
     */
    public function after($callable, $tpl = '403', $tpl_vars = []): Route {
        $this->_checkCallable($callable, $this->getUrlPath());
        $this->afterMiddleware[] = [$callable, $tpl, $tpl_vars];
        return $this;
    }

    public function getName() { return $this->name; }

    public function getUrlPath() { return $this->urlPath; }

    public function setRequestParams($val) {
        if (is_array($val)) $this->requestParams = $val;
        return $this;
    }
}

/**
 * @return Route
 * @throws Exception
 */
function route($urlPath, $callable, $name = '') {
    return Route::instance($urlPath, $callable, $name);
}

/**
 * @throws Exception
 */
function routeGrp($routeArr, $beforeArr = [], $afterArr = []) {
    foreach ($routeArr as $route) {
        if ($route instanceof Route) {
            // before
            foreach ($beforeArr as $before) {
                if (is_array($before)) {
                    if (count($before) == 3) {
                        $route->before($before[0], $before[1], $before[2]);
                    } elseif (count($before) == 1) {
                        $route->before($before[0]);
                    }
                }
            }
            // after
            foreach ($afterArr as $after) {
                if (is_array($after)) {
                    if (count($after) == 3) {
                        $route->after($after[0], $after[1], $after[2]);
                    } elseif (count($after) == 1) {
                        $route->after($after[0]);
                    }
                }
            }
        }
    }
}
