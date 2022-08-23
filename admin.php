<?php
    include "dbConnect.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';
    include './includes/constant.php';

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
                    SELECT NAME, CUSTOMER.PK_ID AS CUST_ID, PLACEORDER.PK_ID AS PK_ID, PLACEORDER.DATE_UPDATED AS DATE_UPDATED,  
                    PLACEORDER.REFERENCE_NO AS REFERENCE_NO, PLACEORDER.STATUS AS STATUS, PLACEORDER.DATE_CREATED AS DATE_CREATED
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
                $mail->Body    = $message;
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
    }
?>