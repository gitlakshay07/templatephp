<?php
    session_start();
    require_once('../config.php');

    if(!is_logged_in()){
        header("Location: /sign-in");
    }
    
    $layout = 'dashboard';
    $template = 'dashboard.php';

    render_view($template, $layout);
?>