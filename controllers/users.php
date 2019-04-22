<?php

//require_once '../connection.php';

class Users extends CI_Controller
{
    private $db = null;
    private $query = null;
    private $result = null;

    public function __construct()
    {
        parent::__construct();
        session_start();

        $this->load->connection('../connection.php');

        $this->db = mysqli_connect($host, $user, $password, $database);
        $this->load->view('login.php');
    }

    public function __destruct()
    {
        mysqli_close($this->db);
    }

    public function loginBtnPr()
    {
        if(isset($_POST['SaveBtn']))
        {
            $this->login();
        }
    }

    public function login()
    {
        $this->query ="SELECT * FROM users";
        $this->result = mysqli_query($this->db, $this->query);
        while($row = mysqli_fetch_assoc($this->result))
        {
            if($_POST['Login'] == $row['Login'] && $_POST['Pass'] == $row['Password'])
            {
                if (!isset($_SESSION['Id']))
                {
                    $_SESSION['Id'] = $row['Id'];
                }
                if(isset($_POST['RmbChBox']))
                {
                    setcookie("auth", $row['Id'], time() + 60*60*24*7);
                }
                header('location: index.php');
                exit();
            }
        }
    }

    public function delBtnPr()
    {
        if (isset($_POST['DelProfBtn']))
        {
            $this->removeUser($_SESSION['Id']);
        }
    }

    public function regUsBtnPr()
    {
        if(isset($_POST['RegisterBtn']))
        {
            if(isset($_POST['Login']) && isset($_POST['Pass']))
            {
                $this->register();
            }
        }
    }

    public function register()
    {
        $this->load->view('register.php');

        $this->db = mysqli_connect($host, $user, $password, $database);

        $this->query ="INSERT INTO `users` (`Login`, `Password`) VALUES  ('" . $_POST['Login'] . "', '" . $_POST['Pass'] ."')";
        $this->result = mysqli_query($this->db, $this->query);



//        if($this->$db->errno)
//        {
//            header('location: register.php');
//            echo 'Some error occured, try again';
//        }
//        else
//        {
//            header('location: index.php');
//        }
    }

    function removeUser($Id)
    {
        $this->query ="DELETE FROM `users` WHERE Id = " . $Id;
        mysqli_query($this->db, $this->query);

        $this->load->view('login.php');
    }
}