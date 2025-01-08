<?php 
session_start();
require_once('./config.php');

if(is_logged_in()){
    header("Location: /dashboard");
    exit;
}

$layout = 'auth';
$template = basename(__FILE__); 

if(isset($_POST['action']) && $_POST['action'] == 'signin'){

    $email = $_POST['email'];
    $cl_pwd = md5($_POST['password']);

    $sql = "SELECT * FROM `users` WHERE `email` = ? AND `password` = ?";
    $stmt = $conn1->prepare($sql);
    $stmt->bind_param("ss", $email, $cl_pwd);
    $stmt->execute();
    $res = $stmt->get_result();
    $result = $res->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    if(count($result)){

        debug_pre($result);

        $user = $result[0];
        unset($user['password']);
        $userData = get_userdata('',$user['ID']);
        $user = array_merge($user, $userData);

        $_SESSION['user'] = $user;
        $_SESSION['user_id'] = $user['ID'];

        $response = array(
            "success" => true,
            "message" => "Logged In",
            "data" => $user
        );
    }else{
        $response = array(
            "success" => false,
            "message" => "No user found",
            "data" => []
        );
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit;
}

render_view($template, $layout);
?>