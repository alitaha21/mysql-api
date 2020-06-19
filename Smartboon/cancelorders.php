<?php

require_once "functions.php";
$database = new functions();

// JSON response
$response = array("error"=>FALSE);

if(isset($_POST['open'])) {

    $open = $_POST['open'];

    $user = $database->cancelOrder();

    if($user != false) {
        $response["error"] = FALSE;
        $response["user"]["user_id"] = $user["user_id"];
        $response["user"]["open"] = $user["open"];
        $response["user"]["created_at"] = $user["created_at"];
        $response["user"]["updated_at"] = $user["updated_at"];

        $_SESSION['login'] = $user;

        echo json_encode($response);
    } else {
        $response["error"] = TRUE;
        $response["error_msg"] = "You either have to login or something wrong happened.";
        echo json_encode($response);
    }

}
?>