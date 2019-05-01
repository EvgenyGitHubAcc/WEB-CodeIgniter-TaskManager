<?php

class DBModel extends CI_Model
{
    private $query = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectUsers()
    {
        $this->query = $this->db->get('users');
        return $this->query->result();
    }

    public function removeUser($Id)
    {
        $this->db->delete('users', array('id' => $Id));
    }

    public function registerUser($dataArr)
    {
//        $data = array(
//            'Login' => $dataArr['Login'],
//            'Pass' => $dataArr['Pass']
//        );
        $this->db->insert('users', $dataArr);
    }


    public function selectTaskByTaskId($Id)
    {
        $this->db->select('*')->from('tasks')->where('Id', $Id);
        $this->query = $this->db->get();
        return $this->query->result();
    }

    public function selectTasksByUser($Id)
    {
        $this->db->select('*')->from('tasks')->where('UserId', $Id);
        $this->query = $this->db->get();
        return $this->query->result();
    }

    public function addTask($dataArr)
    {
//        $data = array(
//            'UserId' => $dataArr['UserId'],
//            'DeadLine' => $dataArr['DeadLine']
//            'Task' => $dataArr['Task']
//        );
        $this->db->insert('tasks', $dataArr);
    }

    public function deleteTask($Id)
    {
        $this->db->delete('tasks', array('id' => $Id));
    }

    public function modifyTask($Id, $dataArr)
    {
//        $data = array(
//            'DeadLine' => $dataArr['DeadLine']
//            'Task' => $dataArr['Task']
//        );
        $this->db->where('Id', $Id)->update('tasks', $dataArr);
    }
}