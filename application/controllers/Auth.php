<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{



    public function index()
    {

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {

            $data['title'] = 'Login';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('templates/footer');
        } else {

            $this->load->model('User_model', 'user');
            $this->user->Login();
        }
    }


    public function register()
    {
        $this->load->model('User_model', 'user');
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [

            'is_unique' => 'This email has already registered!'


        ]);

        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[4]|matches[password2]', [

            'matches' => 'Passworrd not match!',
            'min_length' => 'Your Password too short!'

        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');


        if ($this->form_validation->run() == false) {

            $data['title'] = 'Register';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/register', $data);
            $this->load->view('templates/footer');
        } else {

            $this->user->insertData();
        }
    }
}
