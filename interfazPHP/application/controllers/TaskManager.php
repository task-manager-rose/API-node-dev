<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TaskManager extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','session'));
		$this->load->helper(array('url', 'language'));
        if(!isset($_SESSION['token']) and strlen($this->session->userdata('token'))<8){
            $this->session->sess_destroy();
            $this->session->flashdata(array('message'=>'Session invalida'));
            redirect('inicio');  
        }
	}
	
	public function index(){
	
            $headData = array('titulo_pagina' => 'TaskManager');
            $headerData = array('op_dashboard'=> 'active');
            /* CONTENIDO ESTATICO */
            $head = array('head'=>$this->load->view('sistema/static/head',$headData,true),
                          'header'=>$this->load->view('sistema/static/header',$headerData,true));
            if(isset($_SESSION['message'])){$head['message'] = $_SESSION['message'];}
            $this->load->view('sistema/index2', $head);
	}
	
}