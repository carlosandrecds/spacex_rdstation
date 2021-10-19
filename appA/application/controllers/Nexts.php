<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    include_once(APPPATH.'core/CTRL_PAI.php');

    class Nexts extends CTRL_PAI 
    {
        public function index() 
        {	
    
            $this->visualizar();
        }

        public function visualizar() 
        {
            $this->load->view('app/template', ['view' => 'ctrl_pai/nexts']);
        }
    }