<?php 

function debug_pre($value, $exit = false){
    echo "<pre>";
    print_r($value);
    echo "</pre>";

    if($exit === true) exit;
}

function render_view($template, $layout, $params = []){
    $view = __DIR__ . '/templates/'. $template;
    $layout = __DIR__ . '/layout/'. $layout . '.php';
    require_once($layout);
}

function is_logged_in(){
    if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && intval($_SESSION['user_id']) > 0){
        return true;
    }

    return false;
}

function get_userdata(int $user_id, $db_conn) {
    if($user_id > 0){
        $sql = "SELECT * FROM `userdata` WHERE `user_id` = ?";
        $stmt = $db_conn->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $result = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $userData = [];

        foreach($result as $value){
            $datakey = $value['datakey'];
            $datavalue = $value['datavalue'];
            $userData[$datakey] = $datavalue;
        }

        return $userData;
    }

    return [];
   
}