<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {
        $this->load->view('login/login_view');
    }

    public function registerNewUser() {

        $newUserName = $this->input->post('newUserName');
        $newUserFamily = $this->input->post('newUserFamily');
        $newUserCode = $this->input->post('newUserCode');
        $newUserPassword = $this->input->post('newUserPassword');
        $newUserPassword2 = $this->input->post('newUserPassword2');

        if ($newUserName == '' || $newUserName == NULL)
            redirect('login', 'refresh');
        if ($newUserFamily == '' || $newUserFamily == NULL)
            redirect('login', 'refresh');
        if ($newUserCode == '' || $newUserCode == NULL) {
            redirect('login', 'refresh');
        }
        if ($newUserPassword == '' || $newUserPassword == NULL) {
            redirect('login', 'refresh');
        }
        if ($newUserPassword2 == '' || $newUserPassword2 == NULL) {
            redirect('login', 'refresh');
        }

        $sql = "SELECT * FROM `users` WHERE `userName`='$newUserCode' AND `userType` ='student'";
        $res = $this->db->query($sql)->result();
        if (count($res) > 0) {
            redirect('login', 'refresh');
        } else {
            $data_array = array(
                'userName' => $newUserCode,
                'password' => md5($newUserPassword),
                'name' => $newUserName,
                'family' => $newUserFamily);
            $res = $this->db->insert('users', $data_array);
            if ($res) {
                $newID = $this->db->insert_id();
                $sess_array = array('userID' => $newID, 'userType' => 'student');
                $this->session->set_userdata('logged_in', $sess_array);
                $this->db->insert('studentLog', array('studentID' => $newID, 'eventName' => 'register'));
                $this->db->insert('studentLog', array('studentID' => $newID, 'eventName' => 'login'));
                redirect('Home/Home/index/' . md5('student'), 'refresh');
            }
        }
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

        $sql = "SELECT `userID`,`userType` FROM `users` WHERE `userName`='$userName' AND `password`=md5('$password') AND `active`=1";
        $result = $this->db->query($sql);

        if ($result->num_rows() == 1) {
            $userType = $result->result()[0]->userType;
            $sess_array = array('userID' => $result->result()[0]->userID, 'userType' => $userType);
            $this->session->set_userdata('logged_in', $sess_array);
            if ($userType == 'teacher') {
                redirect('Home/Home/index/' . md5('teacher'), 'refresh');
            } else if ($userType == 'student') {
                $this->db->insert('studentLog', array('studentID' => $userName, 'eventName' => 'login'));
                redirect('Home/Home/index/' . md5('student'), 'refresh');
            }
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

