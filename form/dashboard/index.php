<?php
    session_start();

    require_once('../config.php');

    if(!is_logged_in()){
        header("Location: /sign-in");
    }
    
    // debug_pre($_SESSION['user_id']);

    $layout = 'dashboard';
    $template = 'dashboard.php';

    render_view($template, $layout);
?>