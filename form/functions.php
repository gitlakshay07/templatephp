<?php 

function debug_pre($value, $exit = false){
    echo "<pre>";
    print_r($value);
    echo "</pre>";

    if($exit === true) exit;
}

function render_view($template, $layout, $params = []){
    $view = __DIR__ . '/templates/'. $template;
    $layout = __DIR__ . '/layout/'. $layout . '.php';
    require_once($layout);
}