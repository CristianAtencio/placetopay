<?php
require('../conection/config.php');

Class payment
{
    private $db;

    public function __construct()
    {
        $this->db = Conectar::conexion();
    }

    public function User($firstname,$lastname,$email)
    {
        $IdUser = $this->GetUser($firstname,$lastname,$email);
        if($IdUser < 1)
        {
            $IdUser = $this->SaveUser($firstname,$lastname,$email);
            return $IdUser;
        }
        return $IdUser;
    }

    public function SaveUser($firstname,$lastname,$email)
    {
        $sqluser = "insert into users (FirstName,LastName,Email) values('".$firstname."','".$lastname."','".$email."')";
        mysqli_query($this->db,$sqluser);
        return $this->GetUser($firstname,$lastname,$email);;

    }

    public function GetUser($firstname,$lastname,$email)
    {
        $query = mysqli_query($this->db,"select * from users where FirstName = '".$firstname."' and LastName = '".$lastname."' and Email = '".$email."' ");

        if ($users = mysqli_fetch_assoc($query)) {
            return $users['Id'];
        }
        return 0;
    }

    public function Payment($amount,$currency,$IdUser)
    {
        $IdPayment = $this->GetPayment($amount,$currency,$IdUser);
        if($IdPayment < 1)
        {
            $IdPayment = $this->SavePayment($amount,$currency,$IdUser);
            return $IdPayment;
        }
        return $IdPayment;
    }

    public function SavePayment($amount,$currency,$IdUser)
    {
        $sqlpayment = "insert into payment (Amount,Currency,State,UserId) values('".$amount."','".$currency."','PENDIENTE PAGAR','".$IdUser."')";
        mysqli_query($this->db,$sqlpayment);
        return $this->GetPayment($amount,$currency,$IdUser);;

    }

    public function GetPayment($amount,$currency,$IdUser)
    {
        $query = mysqli_query($this->db,"select * from payment where Amount = '".$amount."' and Currency = '".$currency."' and UserId = '".$IdUser."' ");

        if ($payment = mysqli_fetch_assoc($query)) {
            return $payment['Id'];
        }
        return 0;
    }

    public function AddIdPayment($IdPayment,$requestId)
    {
        $query = mysqli_query($this->db,"UPDATE payment SET IdPayment='$requestId' where Id ='$IdPayment'");
    }

    public function GetPaymentId($Id)
    {
        $query = mysqli_query($this->db,"select * from payment where Id = '".$Id."' ");

        if ($payment = mysqli_fetch_assoc($query)) {
            return $payment['IdPayment'];
        }
        return 0;
    }

}

?>