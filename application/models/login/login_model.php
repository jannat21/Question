<?php

if (!defined('BASEPATH'))
    exit('دسترسي به اين آدرس وجود ندارد.');

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function login($codep, $password) {

        $this->db->where('user_id', $codep);
        $this->db->where('password', MD5($password));
        $this->db->where('activation', 1);
        $query = $this->db->get('users');
        
        if ($query->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //////////////////////////
    function change_password($data_array) {
        $codep = $data_array['codep'];
        $this->db->where('codep', $codep);
        $result = $this->db->get('group_t_login')->num_rows();
        if ($result !== 1) {
            return 'NotExist';
        }
        $old_password = $data_array['old_password'];
        $old_password = md5($old_password);
        $this->db->where('codep', $codep);
        $this->db->where('password', $old_password);
        $result = $this->db->get('group_t_login')->num_rows();
        if ($result !== 1) {
            return 'WrongPassword';
        }
        $new_password = $data_array['new_password'];
        $confirm_password = $data_array['confirm_password'];
        if ($new_password != $confirm_password) {
            return 'DuplicatePassword';
        }
        $this->db->where('codep', $codep);
        $update_array = array('password' => md5($new_password));
        $this->db->update('group_t_login', $update_array);
        return 'Success';
    }

}

//end of class