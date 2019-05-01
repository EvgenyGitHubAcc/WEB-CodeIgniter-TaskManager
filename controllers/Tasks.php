<?php

class Tasks extends CI_Controller
{
    private $result = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('DBModel');
    }


    public function index()
    {
        $this->load->view('index');
    }

    public function addBtnPr()
    {
        if ($this->input->post('AddBtn')) {
            $this->addTask();
        }
    }

    public function saveBtnPr()
    {
        if ($this->input->post('SaveBtn')) {
            $this->modifyTask($this->input->post('RowNumber'));
        }
    }

    public function modLnkPr()
    {
        if ($this->input->get('ModLnk')) {
            $this->fillFields($_GET['ModLnk']);
        }
    }

    public function delLnkPr()
    {
        if ($this->input->get('DelLnk')) {
            $this->removeTask($this->input->get('DelLnk'));
        }
    }


    public function fillFields($rowNumber)
    {
        $this->result = $this->DBModel->selectTaskByTaskId($rowNumber);
        print_r($this->result[0]);
        $data['dataArr'] = $this->result[0];
        $this->load->view('modifyTask', $data);
    }

    public function updateTask()
    {
        $data['arrayStr'] = $this->DBModel->selectTasksByUser($this->session->Id);
        $this->load->view('index', $data);
    }

    public function addTask()
    {
        if ($this->input->post('Date') && $this->input->post('Task')) {
            if (strtotime($this->input->post('Date'))) {
                $data = array(
                    'UserId' => $this->session->Id,
                    'DeadLine' => strtotime($this->input->post('Date')),
                    'Task' => $this->input->post('Task')
                );
                $this->DBModel->addTask($data);
                $this->updateTask();
            }
        }
    }

    public function removeTask($rowNumber)
    {
        $this->DBModel->deleteTask($rowNumber);
        $this->updateTask();
    }

    public function modifyTask($rowNumber)
    {
        $data = array(
            'UserId' => $this->session->Id,
            'DeadLine' => strtotime($this->input->post('Date')),
            'Task' => $this->input->post('Task')
        );
        $this->DBModel->modifyTask($rowNumber, $data);
        $this->updateTask();
    }
}