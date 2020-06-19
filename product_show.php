<?php

class Constraints {
    
    static $DB_SERVER = "localhost";
    static $DB_NAME = "product";
    static $USERNAME = "root";
    static $PASSWORD = "";

    static $SQL_SELECT_ALL = "select * from product_info";

}

class quotes {

    public function connect() {

        $connect = new mysqli(Constraints::$DB_SERVER, Constraints::$USERNAME, Constraints::$PASSWORD, Constraints::$DB_NAME);

        if($connect->connect_error) {
            echo "Unable to Connect";
            return null;
        } else {
            return $connect;
        }
    }

    public function select() {

        $connect = $this->connect();
        if($connect != null) {

            $result = $connect->query(Constraints::$SQL_SELECT_ALL);
            if($result->num_rows > 0) {
                $quotes = array();
                while($row = $result->fetch_array()) {
                    array_push($quotes, array("name"=>$row['name'], "email"=>$row['email'], "mobile"=>$row['mobile']));
                }
                print(json_encode(array_reverse($quotes)));
            } else {
                print(json_encode(array("PHP Exception : Can't retrieve from MYSQL.")));
            }
            $connect->close();
        } else {
            print(json_encode(array("PHP Exception : Can't retrieve from MYSQL. NULL Connection.")));
        }
    }
}
$quotes = new quotes();
$quotes->select();
