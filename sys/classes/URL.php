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

    function to($str) { return WEBROOT . trim($str, '/ '); }

    function isCurrent($str) { return Dispatcher::instance()->isCurrentUrlContaining($str); }

    function classeIf($str, $class='active') { return $this->isCurrent($str) ? $class : ''; }
}

function url(): URL { return URL::instance(); }
