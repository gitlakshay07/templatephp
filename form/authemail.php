<?php 
require_once('./config.php');
$layout = 'auth';
$template = basename(__FILE__); 

if(isset($_POST['otp']) && $_POST['otp'] == 'submit'){

    $auth_code = $_POST['otp_val'];

    $sql = "SELECT code FROM authemail WHERE code = ?";
    $stmt = $conn1->prepare($sql);
    $stmt->bind_param("s", $auth_code);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows > 0){
        header("Location: /reset");
    }

    $stmt->close();
}

render_view($template, $layout);
?>