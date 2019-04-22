<?php

//require_once '../connection.php';

class Tasks extends CI_Controller
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

    public function addBtnPr()
    {
        if (isset($_POST['AddBtn']))
        {
            if($_POST)
            {
                $this->addTask();
            }
        }
    }

    public function saveBtnPr()
    {
        if (isset($_POST['SaveBtn']))
        {
            $this->modifyTask($_POST['RowNumber']);
        }
    }

    public function modLnkPr()
    {
        if (isset($_GET['ModLnk']))
        {
            $this->fillFields($_GET['ModLnk']);
        }
    }

    public function delLnkPr()
    {
        if (isset($_GET['DelLnk']))
        {
            $this->removeTask($_GET['DelLnk']);
        }
    }


    public function fillFields($rowNumber)
    {
        $this->query = "SELECT * FROM `tasks` WHERE Id = " . $rowNumber;

        $this->result = mysqli_fetch_assoc(mysqli_query($db, $query));

        $this->load->view('modifyTask.php', $this->result, $rowNumber);
    }

    public function updateTask()
    {
        $this->query ="SELECT * FROM tasks WHERE UserId = ". $_SESSION['Id'];

        if(!$this->result = mysqli_query($this->db, $this->query))
        {
            exit();
        }

        while($row = mysqli_fetch_assoc($result))
        {
            $arrayStr[] = $row;
        }

        $this->load->view('index.php', $data['arrayStr'] = $arrayStr);
    }

    public function addTask()
    {
        if(isset($_POST['Date']) && isset($_POST['Task']))
        {
            if(strtotime($_POST['Date']))
            {
                $this->query ="SELECT COUNT(*) AS `COUNT` FROM tasks";
                mysqli_fetch_row(mysqli_query($this->db, $this->query));

                $query ="INSERT INTO `tasks` (`UserId`, `DeadLine`, `Task`) 
                    VALUES  (
                    '" . $_SESSION['Id'] . "', 
                    '" . strtotime($_POST['Date']) . "',
                    '" . $_POST['Task'] . "')";

                mysqli_query($this->db, $this->query);
                $this->updateTask();
            }
        }
    }

    public function removeTask($rowNumber)
    {
        $query ="DELETE FROM `tasks` WHERE Id = " . $rowNumber . " AND UserId = " . $_SESSION['Id'];

        $result = mysqli_query($this->db, $this->query);

        while($row = mysqli_fetch_assoc($result))
        {
            $arrayStr[] = $row;
        }

        $this->updateTask();
    }

    public  function modifyTask($rowNumber)
    {
        $this->query = "UPDATE `tasks`
            SET DeadLine = " .  strtotime($_POST['Date']) . ", 
                Task = '" .  $_POST['Task'] . "'
            WHERE Id = " . $rowNumber;
        mysqli_query($this->$db, $query);
        $this->updateTask();
    }
}
