<?php 
    require_once("config/db.class.php");
    class User{
        public $userID;
        public $userName;
        public $password;
        public $address;
        public $phoneNumber;
        public function __construct($u_name, $u_pass, $u_address, $u_phone){
            $this->userName =$u_name;
            $this->password =$u_pass;
            $this->address =$u_address;
            $this->phoneNumber =$u_phone;
        }
        public function save(){
            $db =new Db();
            $sql = "INSERT INTO customer (CustomerName, CustomerPassword, CAddress, Phone) VALUES (
            '".mysqli_real_escape_string($db->connect(),$this->userName)."',
            '".mysqli_real_escape_string($db->connect(),$this->password)."',
            '".mysqli_real_escape_string($db->connect(),$this->address)."',
            '".mysqli_real_escape_string($db->connect(),$this->phoneNumber)."'
            )";
            $result = $db->query_execute($sql);
            return $result;
        }
        public static function get_customer($CustomerName){
            $db = new Db();
            $sql = "SELECT * FROM customer WHERE CustomerName='$CustomerName'";
            $result = $db->select_to_array($sql);
            return $result;
        }
        public static function list_customer(){
            $db = new Db();
            $sql = "SELECT * FROM customer ";
            $result = $db->select_to_array($sql);
            return $result;
        }
    }
?>