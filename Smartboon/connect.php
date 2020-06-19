<?php

class CONNECT {

    private $conn;

    public function connect() {
        require_once 'config.php';

        $this->conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
        return $this->conn;
    }

}

?>