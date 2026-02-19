<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

    public function index()
    {
        $this->load->view('vendor/index');
    }

    public function select2()
    {
        $this->load->view('vendor/select2');
    }

}