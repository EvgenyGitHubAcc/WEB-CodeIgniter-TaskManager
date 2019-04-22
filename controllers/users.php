<?php

//require_once '../third_party/connection.php';

class Users extends CI_Controller
{
    private $db = null;
    private $query = null;

    public function __construct()
    {
        parent::__construct();
        session_start();

        $this->load->connection('../third_party/connection.php');

        $this->$db = mysqli_connect($host, $user, $password, $database);
        $this->load->view('login.php');
    }

    public function __destruct()
    {
        mysqli_close($this->$db);
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

        $this->$db = mysqli_connect($host, $user, $password, $database);

        $query ="INSERT INTO `users` (`Login`, `Password`) VALUES  ('" . $_POST['Login'] . "', '" . $_POST['Pass'] ."')";
        $result = mysqli_query($this->$db, $query);



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
        $query ="DELETE FROM `users` WHERE Id = " . $Id;
        mysqli_query($this->$db, $query);

        $this->load->view('login.php');
    }
}