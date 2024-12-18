<?php 
session_start();
require_once('./config.php');

if(is_logged_in()){
    header("Location: /dashboard");
}

$layout = 'auth';
$template = basename(__FILE__); 

if(isset($_POST['action']) && $_POST['action'] == 'signin'){
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $response = array(
        "success" => false,
        "message" => "No User Found!",
        "data" => []
    );

    $sql = "SELECT * FROM `users` WHERE `email` = ? AND `password` = ?";
    $select = $conn1->prepare($sql);
    $select->bind_param("ss", $email, $password);
    $select->execute();
    $res = $select->get_result();
    $result = $res->fetch_all(MYSQLI_ASSOC);
    $select->close();

    if(count($result)){

        // debug_pre($result);

        $user = $result[0];
        unset($user['password']);
        $userData = get_userdata($user['ID'], $conn1);
        $user = array_merge($user, $userData);

        $_SESSION["user"] = $user;
        $_SESSION["user_id"] = $user['ID'];

        $response = array(
            "success" => true,
            "message" => "hello user!",
            "data" => $user
        );
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit;
}

render_view($template, $layout);
?>