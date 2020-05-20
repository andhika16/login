<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{


    public function insertData()
    {
        $email = $this->input->post('email', true);

        $data = [
            'name' => htmlspecialchars($this->input->post('name', true)),
            'email' => htmlspecialchars($email),
            'image' => 'default.jpg',
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'role_id' => 1,
            'is_active' => 1,
            'date_created' => time()

        ];

        $this->db->insert('user', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulations ! Your acount has been created, Please activate your account !
          </div>');
        redirect('auth');
    }

    public function Login()
    {

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();



        if ($user) {

            if (password_verify($password, $user['password'])) {

                $this->session->set_userdata($email);
                redirect('home');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Wrong Password!
                 </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          Email not registered!
            </div>');
            redirect('auth');
        }
    }
}
