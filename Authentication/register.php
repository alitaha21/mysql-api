<?php

require_once 'functions.php';

$database = new functions();

// JSON response
$response = array("error"=>FALSE);

if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
    // Receiving
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if($database->userExists($email)) {
        $response["error"] = TRUE;
        $response["error_msg"] = "User already exists with ".$email;
        echo json_encode($response);
    } else {
        // Create new user
        $user = $database->storeUser($name, $email, $password);
        if($user) {
            $response["error"] = FALSE;
            $response["uid"] = $user["unique_id"];
            $response["user"]["name"] = $user["name"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["created_at"] = $user["created_at"];
            $response["user"]["updated_at"] = $user["updated_at"];

            echo json_encode($response);

        } else {
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error prevents registration!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email, password) is missing.";
    echo json_encode($response);
}

?>