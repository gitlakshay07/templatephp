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
    if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && intval($_SESSION['user_id']) > 0 ){
        return true;
    }

    return false;
}

function get_userdata(int $user_id, $db_conn){
    if($user_id > 0){
        $sql = "SELECT * FROM `userdata` WHERE `user_id` = ?";
        $select = $db_conn->prepare($sql);
        $select->bind_param("s", $user_id);
        $select->execute();
        $res = $select->get_result();
        $result = $res->fetch_all(MYSQLI_ASSOC);
        $select->close();

        $userData = [];

        foreach ($result as $value) {
            $dataKey = $value['datakey'];
            $dataValue = $value['datavalue'];
            $userData[$dataKey] = $dataValue;
        }

        return $userData;
    }

    return [];
}

function get_current_route(){
    $url = strtok($_SERVER["REQUEST_URI"], '?');

    return $url;
}

function check_route($path){


    if(get_current_route() === $path)
    return true;

    return false;
}