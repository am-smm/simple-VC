<?php
require_once SYS_CLASSES . 'Route.php';

class Dispatcher
{
    /**
     * @var Dispatcher
     */
    private static $single_instance = null;

    /**
     * @return Dispatcher
     */
    public static function instance() {
        Dispatcher::$single_instance = Dispatcher::$single_instance ?: new Dispatcher();
        if ( !Dispatcher::$single_instance->is_booted) Dispatcher::$single_instance->boot();
        return Dispatcher::$single_instance;
    }

    // ----------------- Vars de Instância -----------------
    private $urlPath = '';
    /**
     * @var Route[]
     */
    private $rotas;
    private $is_booted;

    protected function __construct() { $this->is_booted = false; }

    public function boot() {
        if (isset($_SERVER['PATH_INFO']))
            $this->urlPath = $_SERVER['PATH_INFO'];
        else
            $this->urlPath = '';

        // limpa a barra inicial para que '/home' e 'home' tenham a mesma chave do array de rotas
        $this->urlPath = $this->cleanUrlPath($this->urlPath);

        // ler todas as rotas definidas
        $this->rotas = [];
        $this->is_booted = true;

        try {
            // deixar como última instrução!
            include APP . 'rotas.php';
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    /**
     * @return bool
     */
    public function isCurrentUrlContaining($urlPath) {
        return stripos($this->getUrlPath(), $urlPath) !== false;
    }

    /**
     * @return string
     */
    public function cleanUrlPath($urlPath) { return trim($urlPath, '/'); }

    /**
     * @return string
     */
    public function getUrlPath() { return $this->urlPath; }

    /**
     * @return Route[]
     */
    public function getRoutes() { return $this->rotas; }

    /**
     * @param Route $route
     * @return $this
     */
    public function registerRoute($route) {
        // limpa a barra inicial para que '/home' e 'home' tenham a mesma chave do array de rotas
        $urlPath = $this->cleanUrlPath($route->getUrlPath());
        $this->rotas[$urlPath] = $route;
        return $this;
    }

    public function tryGetRouteByUrl($url, &$rota) {
        $rota = false;
        // limpa a barra inicial para que '/home' e 'home' tenham a mesma chave do array de rotas
        $urlPath = $this->cleanUrlPath($url);
        // trata as rotas dinâmicas (com '(id)')
        $urlPathParam = preg_replace('/[0-9]+/', '(id)', $urlPath);
        if (isset($this->rotas[$urlPath])) $rota = $this->rotas[$urlPath];
        elseif (isset($this->rotas[$urlPathParam])) $rota = $this->rotas[$urlPathParam];
        if ($rota) {
            $params = preg_replace('/[^0-9\/]+/', '', $urlPath);
            $rota->setRequestParams(preg_split('/\//', $params, -1, PREG_SPLIT_NO_EMPTY));
        }
        return ! !$rota;
    }

    public function execute() {
        $url = $this->getUrlPath();
        if ($this->tryGetRouteByUrl($url, $rota)) {

            /** @var Route $rota */
            $rota->getCallable()($rota);

        } else  view()->v404($url);
    }
}
