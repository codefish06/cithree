<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content_block extends CI_Controller {

    public function index()
    {
        $this->load->view('appearance/content_block/index');
    }

    public function create()
    {
        $this->load->view('appearance/content_block/create');  
    }

}