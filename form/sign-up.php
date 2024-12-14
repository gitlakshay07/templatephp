<?php 
session_start();
require_once('./config.php');

$layout = 'auth';
$template = basename(__FILE__); 

if(isset($_POST['action']) && $_POST['action'] == 'signup'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $current_date = date('Y-m-d H:i:s', time());

    $sql = "SELECT * FROM `users` WHERE `email` = ?";
    $select = $conn1->prepare($sql);
    $select->bind_param("s", $email);
    $select->execute();
    $res = $select->get_result();
    $result = $res->fetch_all(MYSQLI_ASSOC);
    $select->close();

    if(count($result)){
        $response = array(
            "success" => false,
            "message" => "this user already exist!",
            "data" => []
        );
    }else{
        $insData = "INSERT INTO `users` (email, `password`, updated, created) VALUES (?,?,?,?)";
        $stmt = $conn1->prepare($insData);
        $stmt->bind_param("ssss",$email, $password, $current_date, $current_date);
        $stmt->execute();
        $stmt->close();

        $response = array(
            "success" => true,
            "message" => "hello user!",
            "data" => $result
        );
    };

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit;
}

render_view($template, $layout);
?>