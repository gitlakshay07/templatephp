<?php
session_start();
require_once('./config.php');

$postData = $_POST;

if (isset($_POST['submit']) && $_POST['submit'] == 'signup') {


    $error = [];

    $requiredFields = array('firstname', 'lastname', 'dob', 'gender', 'fatherfirstname', 'fatherlastname', 'motherfirstname', 'motherlastname', 'streetaddress', 'city', 'state', 'country', 'zipcode', 'email', 'phonenumber', 'password', 'courses', 'comment');

    // debug_pre($postData);
    if (count($error) == 0) {
        $insert = "INSERT INTO form 
        (`firstname`, `lastname`, `dob`, `gender`, `fatherfirstname`, `fatherlastname`, `motherfirstname`, `motherlastname`, `streetaddress`, `city`, `state`, `country`, `zipcode`, `email`, `phonenumber`, `password`, `courses`, `comment`) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conn1->prepare($insert);
        $stmt->bind_param("sssssssssssssdssss",$postData['firstname'],$postData['lastname'],$postData['dob'],$postData['gender'],$postData['fatherfirstname'],$postData['fatherlastname'],$postData['motherfirstname'],$postData['motherlastname'],$postData['streetaddress'],$postData['city'],$postData['state'],$postData['country'],$postData['zipcode'],$postData['email'],$postData['phonenumber'],$postData['password'],$postData['courses'],$postData['comment']); 
        $stmt->execute(); 
        echo $conn1->insert_id;
    }
    foreach ($requiredFields as $requiredField) {
        if (!isset($postData[$requiredField])) {
            $error[$requiredField] = 'Please enter your ' . $requiredField;
        } else if (is_array($postData[$requiredField]) && count($postData[$requiredField]) == 0) {
            $error[$requiredField] = 'Please enter your ' . $requiredField;
        } else if (empty($postData[$requiredField])) {
            $error[$requiredField] = 'Please enter your ' . $requiredField;
        } else {
            $value = $postData[$requiredField];

            if (isset($postData['dob'])) {
                $birthDate = new DateTime($postData['dob']);
                $today = new DateTime();
                $age = $today->diff($birthDate)->y;
            }

            switch ($requiredField) {
                case 'firstname':
                case 'lastname':
                case 'fatherfirstname':
                case 'fatherlastname':
                case 'motherfirstname':
                case 'motherlastname':
                    if (!preg_match("/^[a-zA-Z]+$/", $value)) {
                        $error[$requiredField] = $requiredField . ' should only contain letters and must not include spaces or numbers';
                    }
                    break;
                case 'age':
                    if ($age < 18 || $age > 40) {
                        $error[$requiredField] = $requiredField . '  must be between 18 and 40 years';
                    }
                    break;

                case 'zipcode':
                    if (!preg_match("/^\d{6}$/", $value)) {
                        $error[$requiredField] = $requiredField . ' Zip code must be exactly 6 numeric digits';
                    }
                    break;
                case 'email':
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $error[$requiredField] = $requiredField . " * Invalid Email format.";
                    }
                    break;

                case 'phonenumber':
                    if (!preg_match("/^\d{10}$/", $value)) {
                        $error[$requiredField] = $requiredField .  " Phone number must be numeric and 10 digits long.";
                    }
                    break;
                case 'default-courses': {
                        $error[$requiredField] = $requiredField . " please select course";
                    }
                    break;
                case 'password':
                    if (!preg_match('/^.{8}$/', $value)) {
                        $error[$requiredField] = $requiredField . " Password is required";
                    }
                    break;
            }
        }
    }
}

?>