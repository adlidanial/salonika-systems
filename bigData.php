<?php
    include "dbConnect.php";
    require_once './includes/toyyibpay.php';

    session_start();

    class bigData extends dbConnect
    {
        private $name;
        private $email;
        private $phonenumber;
        private $totalprice;
        private $listcategory = [];
        private $requestorder;

        public function __construct($name, $email, $phonenumber, $totalprice, $listcategory, $requestorder)
        {
            $this->name = $name;
            $this->email = $email;
            $this->phonenumber = $phonenumber;
            $this->totalprice = $totalprice;
            $this->listcategory = $listcategory;
            $this->requestorder = $requestorder;
        }

        public function saveCustomer()
        {
            $last_id = 0;
            try
            {
                $sql = "
                    INSERT INTO CUSTOMER(NAME, EMAIL, PHONE_NUMBER)
                    VALUES (?, ?, ?)
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $isChecked = $stmt->execute([$this->name, $this->email, $this->phonenumber]);
                $last_id = $this->lastInsertId();
                if($isChecked)
                    return [true, $last_id];
                else
                    return [false, $last_id];
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function saveOrder($lastid, $referenceno, $transid, $statusid)
        {
            try
            {
                $sql = "
                    INSERT INTO PLACEORDER(FK_ID_CUSTOMER, LIST_ORDER, REFERENCE_NO, TOYYIBPAY_TRANSACTIONID, TOYYIBPAY_STATUSID, PRICE, STATUS, DATE_CREATED, DATE_UPDATED)
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
                ";

                
                if(is_array($this->listcategory))
                    $list = implode(", ", $this->listcategory);
                else
                    $list = $this->listcategory;
                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $result = $stmt->execute([$lastid, $list, $referenceno, $transid, $statusid, $this->totalprice, 0]);
                if($result)
                    return true;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function getCustomerById($id)
        {
            try
            {
                $sql = "
                    SELECT * FROM CUSTOMER WHERE PK_ID = :id LIMIT 1
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $name = $result['NAME'];
                $email = $result['EMAIL'];
                $phonenumber = $result['PHONE_NUMBER'];

                return [$name, $email, $phonenumber];

            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function getOrderByCustomerId($id)
        {
            try
            {
                $sql = "
                    SELECT * FROM PLACEORDER WHERE FK_ID_CUSTOMER = :id
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $listorder = $result['LIST_ORDER'];
                $request = $result['REQUEST'];
                $referenceno = $result['REFERENCE_NO'];
                $transid = $result['TOYYIBPAY_TRANSACTIONID'];
                $statusid = $result['TOYYIBPAY_STATUSID'];
                $price = $result['PRICE'];
                $date = $result['DATE_CREATED'];

                return [$listorder, $request, $referenceno, $transid, $statusid, $price, $date];

            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function getListPriceByCategory()
        {
            try
            {
                $sql = "
                    SELECT * FROM PARAMETER
                    INNER JOIN PRICE ON PARAMETER.PK_ID = PRICE.FK_ID_PARAMETER
                    WHERE PARAMETER.GROUP_NAME LIKE 'CATEGORY'
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;

            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function saveRequestOrder($lastid, $referenceno, $transid, $statusid)
        {
            try
            {
                $sql = "
                    INSERT INTO PLACEORDER(FK_ID_CUSTOMER, LIST_ORDER, REQUEST, REFERENCE_NO, TOYYIBPAY_TRANSACTIONID, TOYYIBPAY_STATUSID, PRICE, STATUS, DATE_CREATED, DATE_UPDATED)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $result = $stmt->execute([$lastid, "-", $this->requestorder, $referenceno, $transid, $statusid, $this->totalprice, -1]);
                if($result)
                    return true;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function getExistReferenceNo($referenceno)
        {
            try
            {
                $sql = "
                    SELECT * FROM PLACEORDER
                    WHERE REFERENCE_NO = :referenceno
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":referenceno", $referenceno);
                $result = $stmt->execute();
                if($result->rowCount() > 0)
                    return [true, $result];
                else
                    return [false, ""];
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function updateOrder($transactionid, $toyyibpaystatus, $status, $referenceno)
        {
            try
            {
                $sql = "
                    UPDATE PLACEORDER SET TOYYIBPAY_TRANSACTIONID = :transactionid, TOYYIBPAY_STATUSID = :toyyibpaystatusid,
                    STATUS = :status, DATE_UPDATED = NOW()
                    WHERE REFERENCE_NO = :referenceno
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":transactionid", $transactionid);
                $stmt->bindParam(":toyyibpaystatusid", $toyyibpaystatusid);
                $stmt->bindParam(":status", $status);
                $stmt->bindParam(":referenceno", $referenceno);
                $result = $stmt->execute();
                
                if($result)
                    return true;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }
    }

?>