<?php
    include "dbConnect.php";

    class Admin extends dbConnect{

        private $username;
        private $password;

        public function __constructor($username, $password)
        {
            $this->username = $username;
            $this->password = $password;
        }

        public function validateLogin()
        {
            try
            {
                $sql = "
                    SELECT * FROM ADMIN WHERE USERNAME = :username AND PASSWORD = :pass
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":username", $this->username);
                $stmt->bindParam(":pass", $this->password);
                if($stmt->execute())
                    return true;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function getNotificationPendingOrder()
        {
            try
            {
                $sql = "
                    SELECT NAME, PLACEORDER.PK_ID AS PK_ID, PLACEORDER.DATE_CREATED AS DATE_CREATED, PLACEORDER.REFERENCE_NO AS REFERENCE_NO
                    FROM CUSTOMER
                    INNER JOIN PLACEORDER ON CUSTOMER.PK_ID = PLACEORDER.FK_ID_CUSTOMER
                    WHERE PLACEORDER.STATUS = 0
                    ORDER BY DATE_CREATED DESC
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

        public function getPlaceOrder()
        {
            try
            {
                $sql = "
                    SELECT NAME, PLACEORDER.PK_ID AS PK_ID, PLACEORDER.DATE_UPDATED AS DATE_UPDATED, 
                    PLACEORDER.REFERENCE_NO AS REFERENCE_NO, PLACEORDER.STATUS AS STATUS
                    FROM CUSTOMER
                    INNER JOIN PLACEORDER ON CUSTOMER.PK_ID = PLACEORDER.FK_ID_CUSTOMER
                    ORDER BY DATE_CREATED DESC
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

        public function updateStatusOrder($status, $id)
        {
            try
            {
                $sql = "
                    UPDATE PLACEORDER SET STATUS = :status WHERE PK_ID = :id
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":status", $status);
                $stmt->bindParam(":id", $id);
                if($stmt->execute())
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