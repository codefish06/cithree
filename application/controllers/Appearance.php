<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appearance extends CI_Controller {

    public function index()
    {
        $this->load->view('appearance/index');
    }
}   