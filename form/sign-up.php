<?php 
session_start();
require_once('./config.php');

if(is_logged_in()){
    header("Location: /dashboard");
    exit;
}

$layout = 'auth';
$template = basename(__FILE__); 

if(isset($_POST['action']) && $_POST['action'] == 'signup'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
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
        $insData = "INSERT INTO `users` (`email`, `password`, `updated`, `created`) VALUES (?,?,?,?,?)";
        $stmt = $conn1->prepare($insData);
        $stmt->bind_param("ssss", $email, $password, $current_date, $current_date);
        $stmt->execute();
        $user_id = mysqli_insert_id($conn1);
        $stmt->close();

        $_SESSION['user_id'] = $user_id;

        if(!empty($user_id)){
            $userData = array(
                "name" => $name,
                "dob" => date('d-m-y H:i:s')
            );

            $insUserData = "INSERT INTO userdata (`user_id`, `datakey`, `datavalue`) VALUES (?,?,?)";
            $stmt = $conn1->prepare($insUserData);

            forEach($userData as $key => $value){
                $stmt->bind_param("iss", $user_id, $key, $value);
                $stmt->execute();
            }

            $stmt->close();
        }

        $response = array(
            "success" => true,
            "message" => "hello user!",
            "data" => [
                'redirect_url' => '/dashboard'
            ]
        );
    };

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit;
}

render_view($template, $layout);
?>