<?php 
session_start();
require_once('./config.php');

$layout = 'auth';
$template = basename(__FILE__); 

if(isset($_POST['forget']) && $_POST['forget'] == 'submit'){

    $email = $_POST['email'];

    $sql = "SELECT `email` FROM `users` WHERE `email` = ?";
    $stmt = $conn1->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();

    if($res->num_rows > 0){

        $code = rand(100000, 999999);

        $sql = "INSERT INTO `authemail` (email, code) VALUES (?,?)";
        $stmt = $conn1->prepare($sql);
        $stmt->bind_param("si", $email, $code);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            header("Location: /authemail");
        }
        $stmt->close();
    };
}
render_view($template, $layout);
?>