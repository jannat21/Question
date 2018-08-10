<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    private $userID=0;

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged_in') == NULL) {
            redirect('login', 'refresh');
        }else{
            $sessionArray=$this->session->userdata('logged_in');
            $this->userID=$sessionArray["userID"];
        }
    }
    
    public function getUserID(){
        return $this->userID;
    }

}

// End of Home class

