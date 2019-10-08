<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asa_Admin extends CI_Controller{

   function __construct() {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');

        if(! isset($this->session->userdata['logged_in']))
        {   redirect(''); }

    }


}