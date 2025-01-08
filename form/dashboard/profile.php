<?php
session_start();
require_once('../config.php');

if(!is_logged_in()){
    header("Location: /sign-in");
    exit;
}

$layout = 'dashboard';
$template = basename(__FILE__);

if(isset($_POST['action']) && $_POST['action'] == 'updateinfo'){

    update_userdata('name', $_POST['name']);
    update_userdata('mobile', $_POST['mobile']);
    update_userdata('location', $_POST['location']);
    if(!empty($_POST['facebook'])) update_userdata('facebook', $_POST['facebook']);
    if(!empty($_POST['twitter'])) update_userdata('twitter', $_POST['twitter']);
    if(!empty($_POST['instagram'])) update_userdata('instagram', $_POST['instagram']);

    $userData = get_userdata('', $_SESSION['user_id']);
    $user = array_merge($_SESSION['user'], $userData);
    $_SESSION['user'] = $user;

    $response = array(
        "success" => true,
        "message" => "Updated user info!",
        "data" => []
    );
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit;
}

render_view($template, $layout);
?>