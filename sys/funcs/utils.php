<?php

function getInput($key, $default = false) {
    return isset($_REQUEST[$key])
        ? trim(filter_var($_REQUEST[$key], FILTER_SANITIZE_STRING))
        : $default;
}

function removeEspacos(string $str): string {
    return trim(preg_replace('/\s+/', '', $str));
}

function removeEspacosDuplicados(string $str): string {
    return trim(preg_replace('/\s+/', ' ', $str));
}

function removeNaoDigitos(string $str): string {
    return preg_replace('/[^0-9]/', ' ', removeEspacos($str));
}

function hasInputKey($key) { return isset($_REQUEST[$key]); }

function isMoney($number, &$formatado, $asString = false) {
    $resultado = true;
    if (is_string($number)) $number = str_replace(',', '.', $number);
    $formatado = @number_format($number, 2, '.', '');
    if ($formatado === null) {
        $formatado = '0';
        $resultado = false;
    }
    $formatado = ($asString ? $formatado : floatval($formatado));
    return $resultado;
}

function array_get($key, $array, $default = false) {

    if ( !is_string($key) || !is_array($array)) return false;

    return ($array[$key] ?? $default);
}

function trygetDatetimeFromStr($str, &$datetime, $format = 'Y-m-d H:i:s'): bool {

    $datetime = DateTime::createFromFormat($format, $str);
    if ($datetime === false) {
        $datetime = new DateTime();
        return false;
    }

    return true;
}

function slugify($text, string $divider = '-') {
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function redirect($to = '') {
    header("Location: " . WEBROOT . $to);
    exit();
}
