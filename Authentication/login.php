<?php

require_once 'functions.php';

$database = new functions();

// JSON response
$response = array("error"=>FALSE);

if(isset($_POST['email']) && isset($_POST['password'])) {
    // Receiving
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $database->getUserByEmailAndPassword($email, $password);

    if($user != false) {
        $response["error"] = FALSE;
        $response["uid"] = $user["unique_id"];
        $response["user"]["name"] = $user["name"];
        $response["user"]["email"] = $user["email"];
        $response["user"]["created_at"] = $user["created_at"];
        $response["user"]["updated_at"] = $user["updated_at"];

        echo json_encode($response);
    } else {
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again.";
        echo json_encode($response);
    }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (email, password) is missing.";
    echo json_encode($response);
}

?>