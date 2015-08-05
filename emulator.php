<?php

/**
 *
 *  Emulates requests to site forms that depend on post/get, simply cause i broke my webserver
 *
 */

array_shift($argv);
$array = [];
foreach ($argv as $arg) {
    $ar = explode('=',$arg);
    if (isset($ar[1])) {
        $array[$ar[0]] = $ar[1];
    }
}

if(isset($array['emulate'])) {
    if ($array['emulate'] == 'get') {
        $_GET = $array;
    }
    if ($array['emulate'] == 'post') {
        $_POST = $array;
    }
}

