<?php
    include "dbConnect.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';
    include './includes/constant.php';
    require_once './includes/toyyibpay.php';


    class Admin extends dbConnect{

        private $username;
        private $password;

        public function __construct($username, $password)
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
                $stmt->execute();
                if($stmt->rowCount() > 0)
                {
                    session_start();
                    $_SESSION['username'] = $this->username;
                    $_SESSION['password'] = $this->password;
                    return true;
                }
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
                    SELECT NAME, PLACEORDER.PK_ID AS PK_ID, PLACEORDER.LIST_ORDER AS LIST_ORDER, PLACEORDER.DATE_CREATED AS DATE_CREATED, PLACEORDER.REFERENCE_NO AS REFERENCE_NO
                    FROM CUSTOMER
                    INNER JOIN PLACEORDER ON CUSTOMER.PK_ID = PLACEORDER.FK_ID_CUSTOMER
                    WHERE PLACEORDER.STATUS = 0 OR PLACEORDER.STATUS = -1
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
                    SELECT NAME, CUSTOMER.PK_ID AS CUST_ID, PLACEORDER.PK_ID AS PK_ID, PLACEORDER.DATE_UPDATED AS DATE_UPDATED,  
                    PLACEORDER.REFERENCE_NO AS REFERENCE_NO, PLACEORDER.STATUS AS STATUS, PLACEORDER.DATE_CREATED AS DATE_CREATED,
                    PLACEORDER.LIST_ORDER AS LIST_ORDER, PLACEORDER.REQUEST AS REQUEST
                    FROM CUSTOMER
                    INNER JOIN PLACEORDER ON CUSTOMER.PK_ID = PLACEORDER.FK_ID_CUSTOMER
                    WHERE PLACEORDER.STATUS <> 2
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

        public function getPlaceOrderWithStatusNotDone()
        {
            try
            {
                $sql = "
                    SELECT NAME, CUSTOMER.PK_ID AS CUST_ID, PLACEORDER.PK_ID AS PK_ID, PLACEORDER.DATE_UPDATED AS DATE_UPDATED,  
                    PLACEORDER.REFERENCE_NO AS REFERENCE_NO, PLACEORDER.STATUS AS STATUS, PLACEORDER.DATE_CREATED AS DATE_CREATED,
                    PLACEORDER.LIST_ORDER AS LIST_ORDER
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

        public function getCustomer()
        {
            try
            {
                $sql = "
                    SELECT * FROM CUSTOMER
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

        public function getCustomerById($id)
        {
            try
            {
                $sql = "
                    SELECT * FROM CUSTOMER WHERE PK_ID = :id
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                return $result;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function getStatusOrderByCustomerId($id)
        {
            try
            {
                $sql = "
                    SELECT CUSTOMER.PK_ID, PLACEORDER.STATUS
                    FROM CUSTOMER
                    INNER JOIN PLACEORDER ON CUSTOMER.PK_ID = PLACEORDER.FK_ID_CUSTOMER
                    WHERE CUSTOMER.PK_ID = :id
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                return $result;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function setComposeEmail($email, $message, $file)
        {
            try
            {
                $mail = new PHPMailer(true);

                 //Server settings
                $mail->SMTPDebug = false;                               //Enable verbose debug output i.e true / false
                $mail->isSMTP();                                        //Send using SMTP
                $mail->Host       = HOST_SMTP_GMAIL;                    //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                               //Enable SMTP authentication
                $mail->Username   = USERNAME_GMAIL;                     //SMTP username
                $mail->Password   = PASSWORD_GMAIL;                     //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     //Enable implicit TLS encryption
                $mail->Port       = PORT_GMAIL;                         //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom(USERNAME_GMAIL);
                $mail->addAddress($email);     //Add a recipient
                // $mail->addReplyTo('info@example.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                //Attachments
                for($i=0; $i<count($file["tmp_name"]); $i++)
                {
                    if(is_uploaded_file($file["tmp_name"][$i]))
                        $mail->addAttachment($file["tmp_name"][$i], $file["name"][$i]);         //Add attachments
                }

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'SALONIKA SYSTEMS';
                $mail->Body    = nl2br($message);
                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                return true;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
                return false;
            }
        }

        public function getParameter()
        {
            try
            {
                $sql = "
                    SELECT * FROM PARAMETER
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

        public function saveParameter($groupname, $parametername, $tooltip, $status)
        {
            try
            {
                $sql = "
                    INSERT INTO PARAMETER(GROUP_NAME, PARAMETER_NAME, TOOLTIP, DATE_CREATED, STATUS)
                    VALUES (?, ?, ?, NOW(), ?)
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $isChecked = $stmt->execute([$groupname, $parametername, $tooltip, $status]);
                if($isChecked)
                    return true;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function updateParameter($groupname, $parametername, $tooltip, $status, $id)
        {
            try
            {
                $sql = "
                    UPDATE PARAMETER SET GROUP_NAME = :groupname, PARAMETER_NAME = :parametername, TOOLTIP = :tooltip, DATE_CREATED = NOW(), STATUS = :status
                    WHERE PK_ID = :id
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":groupname", $groupname);
                $stmt->bindParam(":parametername", $parametername);
                $stmt->bindParam(":tooltip", $tooltip);
                $stmt->bindParam(":status", $status);
                $stmt->bindParam(":id", $id);
                $isChecked = $stmt->execute();
                if($isChecked)
                    return true;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function removeParameter($id)
        {
            try
            {
                $sql = "
                    DELETE FROM PARAMETER WHERE PK_ID = :id
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":id", $id);
                $isChecked = $stmt->execute();
                if($isChecked)
                    return true;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function getPrice()
        {
            try
            {
                $sql = "
                    SELECT PRICE.PK_ID AS PK_ID_PRICE, PRICE, DISCOUNT, PARAMETER.PARAMETER_NAME, DATE_UPDATED FROM PRICE
                    INNER JOIN PARAMETER ON PRICE.FK_ID_PARAMETER = PARAMETER.PK_ID
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

        public function savePrice($parameterid, $price, $discount)
        {
            try
            {
                $sql = "
                    INSERT INTO PRICE(FK_ID_PARAMETER, PRICE, DISCOUNT, DATE_UPDATED)
                    VALUES (?, ?, ?, NOW())
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $isChecked = $stmt->execute([$parameterid, $price, $discount]);
                if($isChecked)
                    return true;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function updatePrice($price, $discount, $id)
        {
            try
            {
                $sql = "
                    UPDATE PRICE SET PRICE = :price, DISCOUNT = :discount, DATE_UPDATED = NOW()
                    WHERE PK_ID = :id
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":price", $price);
                $stmt->bindParam(":discount", $discount);
                $stmt->bindParam(":id", $id);
                $isChecked = $stmt->execute();
                if($isChecked)
                    return true;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function removePrice($id)
        {
            try
            {
                $sql = "
                    DELETE FROM PRICE WHERE PK_ID = :id
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":id", $id);
                $isChecked = $stmt->execute();
                if($isChecked)
                    return true;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function getParameterDoesNotExistInTablePrice()
        {
            try
            {
                $sql = "
                    SELECT * FROM PARAMETER
                    WHERE NOT EXISTS (
                        SELECT * FROM PRICE
                        WHERE PARAMETER.PK_ID = PRICE.FK_ID_PARAMETER
                    )
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

        public function getRequestOrderAndReferenceNoByCustomerId($id)
        {
            try
            {
                $sql = "
                    SELECT PLACEORDER.REQUEST AS REQUEST, PLACEORDER.REFERENCE_NO AS REFERENCE_NO
                    FROM CUSTOMER
                    INNER JOIN PLACEORDER ON CUSTOMER.PK_ID = PLACEORDER.FK_ID_CUSTOMER
                    WHERE CUSTOMER.PK_ID = :id
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                return $result;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function setBillCode($name, $email, $phonenumber, $referenceno, $price)
        {
            try
            {
                if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                    $link = "https";
                else
                    $link = "http";
                
                $link .= "://";
                $link .= $_SERVER['HTTP_HOST'];   
                $link .= chop(dirname($_SERVER['REQUEST_URI']), '\\');
                $data_string = array(
                    'userSecretKey'=> SECRET_KEY,
                    'categoryCode'=> CATEGORY_CODE,
                    'billName'=> BILL_NAME,
                    'billDescription'=> BILL_DESCRIPTION,
                    'billPriceSetting'=>1,
                    'billPayorInfo'=>1,
                    'billAmount'=>$price * 100,
                    'billReturnUrl'=>$link. '/receipt.php',
                    // 'billCallbackUrl'=>,
                    'billExternalReferenceNo'=> $referenceno,
                    'billTo'=>$name,
                    'billEmail'=>$email,
                    'billPhone'=>$phonenumber,
                    'billSplitPayment'=>0,
                    'billSplitPaymentArgs'=>'',
                    'billPaymentChannel'=>0,
                );
        
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_POST, 1);
                // Development ToyyibPay
                curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/createBill');  
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($curl);
                $info = curl_getinfo($curl);  
                curl_close($curl);
                $obj = json_decode($result, true);
        
                $billcode = $obj[0]['BillCode'];

                return $billcode;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function saveBill($userid, $billcode)
        {
            try
            {
                $sql = "
                    INSERT INTO BILL(FK_ID_CUSTOMER, BILL_CODE, DATE_UPDATED)
                    VALUES (?, ?, NOW())
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $isChecked = $stmt->execute([$userid, $billcode]);
                if($isChecked)
                    return true;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function updateBill($userid, $billcode)
        {
            try
            {
                $sql = "
                    UPDATE BILL SET BILL_CODE = :billcode, DATE_UPDATED = NOW()
                    WHERE FK_ID_CUSTOMER = :userid
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":billcode", $billcode);
                $stmt->bindParam(":userid", $userid);
                $isChecked = $stmt->execute();
                
                if($isChecked)
                    return true;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function updatePriceByRefereceNo($price, $referenceno)
        {
            try
            {
                $sql = "
                    UPDATE PLACEORDER SET PRICE = :price, DATE_UPDATED = NOW()
                    WHERE REFERENCE_NO = :referenceno
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":price", $price);
                $stmt->bindParam(":referenceno", $referenceno);
                $isChecked = $stmt->execute();
                if($isChecked)
                    return true;
                else
                    return false;
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function getExistBillByCustomerId($id)
        {
            try
            {
                $sql = "
                    SELECT *
                    FROM BILL
                    WHERE FK_ID_CUSTOMER = :id
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":id", $id);
                $isExist = $stmt->execute();
                if($isExist)
                    return true;
                else
                    return false;                
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }

        public function getBillCodeByCustomerId($id)
        {
            try
            {
                $sql = "
                    SELECT BILL_CODE
                    FROM BILL
                    WHERE FK_ID_CUSTOMER = :id
                ";

                $stmt = $this->connect()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                return $result;               
            }
            catch(PDOException $e)
            {
                echo "<script>alert('Error here:".$e."');</script>";
            }
        }
    }
?>