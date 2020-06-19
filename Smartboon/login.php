<?php

require_once 'functions.php';

$database = new FUNCTIONS();

// JSON response
$response = array("error"=>FALSE);

if(isset($_POST['email']) && isset($_POST['password'])) {
    // Receiving
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $database->getUserByEmailAndPassword($email, $password);

    if($user) {
        $response["error"] = FALSE;
        $response["id"] = $user["id"];
        $response["user"]["id"] = $user["id"];
        $response["user"]["name"] = $user["name"];
        $response["user"]["email"] = $user["email"];
        $response["user"]["role"] = $user["role"];
        $response["user"]["boon_number"] = $user["boon_number"];
        $response["user"]["activated"] = $user["activated"];
        $response["user"]["room_number"] = $user["room_number"];
        $response["user"]["email_verified_at"] = $user["email_verified_at"];
        $response["user"]["remember_token"] = $user["remember_token"];
        $response["user"]["created_at"] = $user["created_at"];
        $response["user"]["updated_at"] = $user["updated_at"];

        session_start();
        $_SESSION['login'] = $user;

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