<?php 
session_start();
require_once('./config.php');

if(is_logged_in()){
    header("Location: /dashboard");
}

$layout = 'auth';
$template = basename(__FILE__); 

render_view($template, $layout);
?>