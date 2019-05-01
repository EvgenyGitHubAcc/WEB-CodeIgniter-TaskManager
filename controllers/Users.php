<?php

class Users extends CI_Controller
{
    private $result = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('DBModel');
    }

    public function loginBtnPr()
    {
        if($this->input->post('SaveBtn'))
        {
            $this->login();
        }
        $this->load->view('login');
    }

    public function delBtnPr()
    {
        if ($this->input->post('DelProfBtn'))
        {
            $this->removeUser($this->session->Id);
        }
    }

    public function logout()
    {
        if($this->input->cookie('auth'))
        {
//            setcookie("auth",'0', time() - 1);
            delete_cookie('auth');
        }
        if ($this->session->Id)
        {
            $this->session->sess_destroy();
        }
        $this->load->view('login');
    }

    public function regUsBtnPr()
    {
        $this->load->view('register');
    }

    public function regAcc()
    {
        if($this->input->post('RegisterBtn'))
        {
            if($this->input->post('Login') && $this->input->post('Pass'))
            {
                $this->register();
            }
        }
    }

    public function index()
    {
//        $this->result = $this->DBModel->selectUsers();
//        foreach ($this->result as $row)
//        {
//            if($this->input->cookie('auth') == $row->Id)
//            {
//                header('location:/Tasks/updateTask');
//            }
//        }
        $this->load->view('login');
    }

    public function login()
    {
        $this->result = $this->DBModel->selectUsers();
        foreach ($this->result as $row)
        {
            if($this->input->post('Login') == $row->Login && $this->input->post('Pass') == $row->Password)
            {
                if (!$this->session->Id)
                {
                    $this->session->Id = $row->Id;
                }
                if($this->input->post('RmbChBox'))
                {
//                    setcookie("auth", $row->Id, time() + 60*60*24*7);
                    $this->input->set_cookie('auth', $row->Id);
                }
                header('location:/Tasks/updateTask');
                exit();
            }
        }
    }

    public function register()
    {
        $data = array(
            'Login' => $this->input->post('Login'),
            'Password' => $this->input->post('Pass')
        );
        $this->DBModel->registerUser($data);
        $this->load->view('login');
    }

    function removeUser($Id)
    {
        $this->DBModel->removeUser($Id);
        $this->session->sess_destroy();
        $this->load->view('login');
    }
}