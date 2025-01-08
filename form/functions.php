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

function get_userdata($datakey = '', int $user_id = null) {
    global $conn1;

    if(!$user_id){

        if(!isset($_SESSION['user_id'])){
            return false;
        }

        $user_id = $_SESSION['user_id'];
    }

    if($user_id > 0){
        $sql = "SELECT * FROM `userdata` WHERE `user_id` = ?";

        if(!empty($datakey)){
            $sql .= ' AND `datakey` = ?';
        }

        $stmt = $conn1->prepare($sql);

        if(!empty($datakey)){
            $stmt->bind_param("ss", $user_id, $datakey);
        }else{
            $stmt->bind_param("s", $user_id);
        }
        
        $stmt->execute();
        $res = $stmt->get_result();
        $result = $res->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $userData = [];

        if(!empty($datakey)){
            if(count($result) > 1){
                foreach($result as $value){
                    $userData[] = $value['datavalue'];
                }
            }else{
                $userData = $result[0]['datavalue'];
            }
        }else{
            foreach($result as $value){
                $datakey = $value['datakey'];
                $datavalue = $value['datavalue'];
                $userData[$datakey] = $datavalue;
            }
        }

        return $userData;
    }

    return [];
   
}

function update_userdata(string $datakey, $datavalue, $user_id = '', $insert = false){
    global $conn1;

    if(empty($user_id)){

        if(!isset($_SESSION['user_id'])){
            return false;
        }

        $user_id = $_SESSION['user_id'];
    }
    if(false === $insert){ 
        // Query for already having data key and value 
        $sql = "SELECT `ID` FROM `userdata` WHERE `user_id` = ? AND `datakey` = ?";
        $stmt = $conn1->prepare($sql);
        $stmt->bind_param("is", $user_id, $datakey);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        // Return the ID where the datakey is present
        if(isset($row['ID']) && $dataID = $row['ID']){
            $sql = "UPDATE `userdata` SET `datavalue` = ? WHERE `ID` = ?";
            $stmt = $conn1->prepare($sql);
            $stmt->bind_param("si", $datavalue, $dataID);
            $stmt->execute();
            $stmt->close();

            return true;
        }
    }

    $sql = "INSERT INTO `userdata` (`user_id`, `datakey`, `datavalue`) VALUES (?, ?, ?)";
    $stmt = $conn1->prepare($sql);
    $stmt->bind_param("iss", $user_id, $datakey, $datavalue);
    $stmt->execute();
    $stmt->close();

    return true;
}

function get_user_id($email){
    global $conn1;
    
    $sql = "SELECT `ID` FROM `users` WHERE `email` = ?";
    $stmt = $conn1->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $result = $row['ID'];
    $stmt->close();

    return $result;

}

function get_current_route(){
    $url = strtok($_SERVER["REQUEST_URI"], '?');
    return $url;
}

function check_route($path){
    if(get_current_route() === $path){
        return true;
    }

    return false;
}