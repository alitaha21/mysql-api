<?php

require_once 'functions.php';
$database = new FUNCTIONS();

// JSON response
$response = array("error"=>FALSE);

if (isset($_POST['open'])) {

    $open = $_POST['open'];

    $order = $database->makeAnOrder($open);

    if($order) {
        $response["error"] = FALSE;
        $response["id"] = $order["id"];
        $response["order"]["user_id"] = $order["user_id"];
        $response["order"]["open"] = $order["open"];
        $response["order"]["created_at"] = $order["created_at"];
        $response["order"]["updated_at"] = $order["updated_at"];

        print(json_encode($response));
    } else {
        $response["error"] = TRUE;
        $response["error_msg"] = "You either have to login or something wrong happened.";
        echo json_encode($response);
    }

}

?>