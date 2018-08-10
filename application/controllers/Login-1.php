<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {
        $this->load->view('login/login_view');
    }

    function verify_login() {

        $userName = $this->input->post('codep');
        $password = $this->input->post('password');

        if ($userName == '' || $userName == NULL) {
            redirect('login', 'refresh');
        }
        if ($password == '' || $password == NULL) {
            redirect('login', 'refresh');
        }

        $sql = "SELECT `userID` FROM `users` WHERE `userName`='$userName' AND `password`=md5('$password') AND `active`=1";
        $result = $this->db->query($sql);

        if ($result->num_rows() == 1) {
            $sess_array = array('userID' => $result->result()[0]->userID);
            $this->session->set_userdata('logged_in', $sess_array);
            redirect('Home/Home', 'refresh');
        } else {
            redirect('login', 'refresh');
        }
    }

    function check_login() {
        $codep = $this->input->post('codep');
        $password = $this->input->post('password');
        print_r($this->input);
        $result = $this->login->login($codep, $password);

        if ($result == TRUE) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array('codep' => $row->codep, 'group' => $row->group);
                $this->session->set_userdata('logged_in', $sess_array);
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('check_login', 'کد پرسنلي و کلمه عبور معتبر نمي باشد!');
            return FALSE;
        }
    }

    function logout() {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('Login', 'refresh');
    }

}

// End of Login class

