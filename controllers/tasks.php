<?php

//require_once '../third_party/connection.php';

class Tasks extends CI_Controller
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
        $query = "SELECT * FROM `tasks` WHERE Id = " . $rowNumber;

        $result = mysqli_fetch_assoc(mysqli_query($db, $query));

        $this->load->view('modifyTask.php', $result, $rowNumber);
    }

    public function updateTask()
    {
        $query ="SELECT * FROM tasks WHERE UserId = ". $_SESSION['Id'];

        if(!$result = mysqli_query($this->$db, $query))
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
                $query ="SELECT COUNT(*) AS `COUNT` FROM tasks";
                mysqli_fetch_row(mysqli_query($this->$db, $query));

                $query ="INSERT INTO `tasks` (`UserId`, `DeadLine`, `Task`) 
                    VALUES  (
                    '" . $_SESSION['Id'] . "', 
                    '" . strtotime($_POST['Date']) . "',
                    '" . $_POST['Task'] . "')";

                mysqli_query($db, $query);
                $this->updateTask();
            }
        }
    }

    public function removeTask($rowNumber)
    {
        $query ="DELETE FROM `tasks` WHERE Id = " . $rowNumber . " AND UserId = " . $_SESSION['Id'];

        $result = mysqli_query($this->$db, $query);

        while($row = mysqli_fetch_assoc($result))
        {
            $arrayStr[] = $row;
        }

        $this->updateTask();
    }

    public  function modifyTask($rowNumber)
    {
        $query = "UPDATE `tasks`
            SET DeadLine = " .  strtotime($_POST['Date']) . ", 
                Task = '" .  $_POST['Task'] . "'
            WHERE Id = " . $rowNumber;
        mysqli_query($this->$db, $query);
        $this->updateTask();
    }
}
