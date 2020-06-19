<?php

class FUNCTIONS {

    // Constractor
    function __construct() {
        require_once 'connect.php';
        $database = new CONNECT();
        $this->conn = $database->connect();
    }

    // Get user by email and password
    public function getUserByEmailAndPassword($email, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);

        if($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // Verifying user password
            $hash = $user['password'];

            // Checking for password equality
            if(password_verify($password, $hash)) {
                $logged = TRUE;
                return $user;
            }
        } else {
            return NULL;
        }
    }

    public function makeAnOrder($open) {

        if ($open) {
            $open = 1;
        } else {
            $open = 0;
        }

        $user_id = 3;
        
        $statement = $this->conn->prepare("INSERT INTO orders(user_id, open, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
        $statement->bind_param("ii", $user_id, $open);
        $result = $statement->execute();
        $statement->close();

        if($result) {
            $statement = $this->conn->prepare("SELECT * FROM orders WHERE user_id=?");
            $statement->bind_param("i", $user_id);
            $statement->execute();
            $user = $statement->get_result()->fetch_assoc();
            $statement->close();
            
            return $user;
        } else {
            return false;
        }
    }
// The original api for making an order
    // public function makeAnOrder($user_id, $open) {

    //     if ($open) {
    //         $open = 1;
    //     } else {
    //         $open = 0;
    //     }
        
    //     $statement = $this->conn->prepare("INSERT INTO orders(user_id, open, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
    //     $statement->bind_param("ii", $user_id, $open);
    //     $result = $statement->execute();
    //     $statement->close();

    //     if($result) {
    //         $statement = $this->conn->prepare("SELECT * FROM orders WHERE user_id=?");
    //         $statement->bind_param("i", $user_id);
    //         $statement->execute();
    //         $user = $statement->get_result()->fetch_assoc();
    //         $statement->close();
            
    //         return $user;
    //     } else {
    //         return false;
    //     }
    // }

    // public function cancelOrder() {

    //     session_start();
    //     if($_SESSION['login']) {

    //         $user = $_SESSION['login'];
    //         $open = 0;

    //         $statement = $this->conn->prepare("DELETE FROM orders WHERE user_id=?");
    //         $statement->bind_param("s", $user['id']);
    //         $result = $statement->execute();
    //         $statement->close();
    //         echo strval($result['user_id']);
                
    //         return $user;
    //     } else {
    //         return NULL;
    //     }

    // }
}

?>