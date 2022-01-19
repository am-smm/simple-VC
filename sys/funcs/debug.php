<?php

function tvars(...$args) {
    echo '<div style="width: 100%; display: flex;">'
        . '<div style="background: #000; color: #fff; margin:1em 0 1em 1em; font-size: 14px; /*min-width: 33%*/">'
        . '<div style="margin:0; padding:5px 0 0 5px;"></div>'
        . '<pre style="padding:5px; margin:0; background: #c1ddff; color: #333;">';
    foreach ($args as $val) {
        if (is_array($val)) print_r($val);
        else vd($val);
    }
    echo '</pre></div></div>';
}

function vd(...$args) {
    echo '<div style="width: 100%; display: flex;">'
        . '<div style="background: #000; color: #fff; margin:1em 0 1em 1em; font-size: 14px; /*min-width: 33%*/">'
        . '<div style="margin:0; padding:5px 0 0 5px;"></div>'
        . '<pre style="padding:5px; margin:0; background: #FC0; color: #333;">';
    var_dump(...$args);
    echo '</pre></div></div>';
}

function d(...$args) { tvars(...$args); }

function dd(...$args) {
    tvars(...$args);
    die;
}
