<?php

class View
{
    /**
     * @var View
     */
    private static $single_instance = null;

    /**
     * @return View
     */
    public static function instance() {
        return static::$single_instance ?? new static();
    }

    private function __construct() { }

    /**
     * @param string $page
     */
    public function v404($page) {
        $this->load('404', ['page' => $page]);
    }

    public function nodata(string $msg_erro, string $link = '/', string $msg_link = 'home') {
        $this->load('nodata', [
            'msg_erro' => $msg_erro,
            'link' => $link,
            'msg_link' => $msg_link,
        ]);
    }

    public function redirectWithFlashMsgTo(string $flash_msg, string $redirect_to = '/') {
        flash()->error($flash_msg, false);
        redirect($redirect_to);
    }


    /**
     * @param string $tpl_filename
     * @param array $tpl_vars
     * @param bool $print_tpl
     * @return false|string|void
     */
    public function load($tpl_filename, $tpl_vars = [], $print_tpl = true) {
        $fullFilePath = APP_TPLS . $tpl_filename . '.tpl.php';
        $output = null;
        if (file_exists($fullFilePath)) {
            // Extract the variables to a local namespace
            extract($tpl_vars);
            unset($tpl_vars);
            // Start output buffering
            ob_start();

            // Include the template file
            include($fullFilePath);

            // End buffering and return its contents
            $output = ob_get_clean();

        } else {
            die('TPL inexistente: ' . $fullFilePath);
        }
        if ($print_tpl) {
            print $output;
        }
        return $output;
    }
}

/**
 * @return View
 */
function view() {
    return View::instance();
}
