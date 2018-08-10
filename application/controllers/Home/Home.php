<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MY_Controller {

    function index($userType) {
        if ($userType == md5('teacher')) {
            $this->load->view('home/homeView');
        }
        if ($userType == md5('student')) {
            $this->load->view('home/studentHomeView');
        }
    }

    function getPayeandCources() {
        $data["payeList"] = $this->getPayeList();
        $data["courceList"] = $this->getCourceList();
        echo json_encode($data);
    }

    function saveNewPayeandCources() {
        $obj = json_decode(file_get_contents('php://input'));

        $data_array = array(
            'payeID' => $obj->selectedPaye->payeID,
            'userID' => $this->getUserID(),
            'title' => $obj->newDars,
            'ip' => $this->input->ip_address()
        );
        $this->db->insert('cources', $data_array);
        $data["payeList"] = $this->getPayeList();
        $data["courceList"] = $this->getCourceList();
        echo json_encode($data);
    }

    private function getPayeList() {
        $sql = "SELECT * FROM paye p WHERE p.active=1";
        return $this->db->query($sql)->result();
    }

    private function getCourceList() {
        $userID = $this->getUserID();
        $sql = "SELECT c.*,md5(c.courceID) md5CourceID,p.payeName FROM `cources` c 
        INNER JOIN paye p on p.payeID=c.payeID WHERE `userID`=$userID";
        return $this->db->query($sql)->result();
    }

}

// End of Home class

