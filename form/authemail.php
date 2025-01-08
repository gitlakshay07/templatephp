<?php
require_once('./config.php');
$layout = 'auth';
$template = basename(__FILE__);

if (isset($_POST['action']) && $_POST['action'] == 'forget') {

    $email = $_POST['email'];

    $sql = "SELECT `ID` FROM `users` WHERE `email` = ?";
    $stmt = $conn1->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

    if ($row && $user_id = $row['ID']) {
        update_userdata('otp', rand(100000, 999999), $user_id);
    }
}
if (isset($_POST['otp'])) {
    $auth_code = $_POST['otp'];
    $email = $_POST['email'];

    $userId = get_user_id($email);
    $db_code = get_userdata('otp', $userId);

    if (!empty($db_code) && $auth_code == $db_code) {
        $response = array(
            "success" => true,
            "message" => "OTP verified!"
        );
    } else {
        $response = array(
            "success" => false,
            "message" => "Incorrect OTP"
        );
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'reset') {
    $email = $_POST['email'];
    $userId = get_user_id($email);
    $cl_pwd = md5($_POST['password']);

    $sql =  "UPDATE `users` SET password=? WHERE email=?";
    $stmt = $conn1->prepare($sql);
    $stmt->bind_param("ss", $cl_pwd, $email);
    $stmt->execute();
    $affectedRows = $stmt->affected_rows;
    $stmt->close();

    if($affectedRows > 0) {
        $dataKey = "otp";
        $sql = "DELETE FROM `userdata` WHERE `user_id` = ? AND `datakey` = ?";
        $stmt = $conn1->prepare($sql);
        $stmt->bind_param("ss",$userId, $dataKey);
        $stmt->execute();
        $stmt->close();

        $response = array(
            "success" => true,
            "message" => "Password reset successfull!"
        );
    }else{
        $response = array(
            "success" => false,
            "message" => "Password reset failed!"
        );
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit;
}

render_view($template, $layout);
