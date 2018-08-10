<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Views extends MY_Controller {

    function loadView($viewName, $ViewFolder = "") {
        if ($ViewFolder == "") {
            $this->load->view($viewName);
        } else {
            $this->load->view("$ViewFolder/$viewName");
        }
    }

}

// End of Home class

