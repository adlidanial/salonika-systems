<?php
    require_once "dbConnect.php";

    class bigData extends dbConnect
    {
        private $name;
        private $email;
        private $phonenumber;
        private $listcategory = [];

        public function __construct($name, $email, $phonenumber, $listcategory)
        {
            $this->name = $name;
            $this->email = $email;
            $this->phonenumber = $phonenumber;
            $this->listcategory = $listcategory;
        }

        public function saveOrder()
        {
            $connect = new dbConnect();
            print_r($this->name . $this->email . $this->phonenumber . $this->listcategory);
        }
    }

?>