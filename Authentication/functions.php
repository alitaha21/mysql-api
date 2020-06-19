<?php

class FUNCTIONS {


    // Constractor
    function __construct() {
        require_once 'connect.php';
        $database = new CONNECT();
        $this->conn = $database->connect();
    }

    // Destructor
    function __destruct() {}

    // Store new user
    // Return user details
    public function storeUser($name, $email, $password) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // Encrypted password
        $salt = $hash["salt"];

        $stmt = $this->conn->prepare("INSERT INTO users(unique_id,name,email,encrypted_password,salt,created_at) values (?,?,?,?,?,NOW())");
        $stmt->bind_param("sssss", $uuid, $name, $email, $encrypted_password, $salt);
        $result =  $stmt->execute();
        $stmt->close();
        
        // Check for successful storage
        if($result) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            
            return $user;
        } else {
            return false;
        }

    }

    // Get user by email and password
    public function getUserByEmailAndPassword($email, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);

        if($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // Verifying user password
            $salt = $user['salt'];
            $encrypted_password = $user['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);

            // Check for password equality
            if($encrypted_password == $hash) {
                return $user;
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }

    }

    // Check whether the user exists or not
    public function userExists($email) {
        $stmt = $this->conn->prepare("SELECT email FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    // Encrypting password
    public function hashSSHA($password) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password.$salt, true).$salt);
        $hash = array("salt"=>$salt, "encrypted"=>$encrypted);

        return $hash;
    }

    // Decrypting password
    public function checkhashSSHA($salt, $password) {
        $hash = base64_encode(sha1($password.$salt, true).$salt);
        return $hash;
    }
}

?>