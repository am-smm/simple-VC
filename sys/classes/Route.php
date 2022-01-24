<?php

class Route
{
    /**
     * @return Route
     */
    public static function instance(string $urlPath, array $callable, $name = '') {
        $route = new static($urlPath, $callable, $name);
        Dispatcher::instance()->registerRoute($route);
        return $route;
    }

    // ----------------- Vars de Instância -----------------
    private $urlPath;
    private $callable;
    private $name;
    private $requestParams;

    /**
     * @throws Exception
     */
    private function __construct(string $urlPath, array $callable, $name = '') {
        $this->urlPath = $urlPath;
        $this->callable = $callable;
        if ( !is_array($callable)
            || count($callable) != 2
            || !method_exists($callable[0], $callable[1]))
            throw new Exception(sprintf('Rota %s mal definida!', $urlPath));
        $this->name = $name;
        $this->requestParams = [];
    }

    public function setName($name = '') {
        $this->name = $name;
        Dispatcher::instance()->registerRoute($this);
    }

    public function getName() { return $this->name; }

    public function getCallable() { return $this->callable; }

    public function getUrlPath() { return $this->urlPath; }

    public function getRequestParams() { return $this->requestParams; }

    public function setRequestParams($val) {
        if (is_array($val)) $this->requestParams = $val;
        return $this;
    }
}

/**
 * @return Route
 */
function route($urlPath, $callable, $name = '') {
    return Route::instance($urlPath, $callable, $name);
}
