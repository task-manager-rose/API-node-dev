<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->database();
		$this->load->library(array('form_validation','session'));
		$this->load->helper(array('url', 'language'));
		//$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
	}
	
	public function index(){
		/* TITULO DE PAGINA */
		$h_data = array('titulo_pagina' => 'Login - FASSD');
		/* CONTENIDO ESTATICO */
		$head = array('head'=>$this->load->view('static/head',$h_data,true));
		if(isset($_SESSION['message'])){$head['message'] = $_SESSION['message'];}		
		$this->load->view('login', $head);
	}
	
	public function logout(){
		$this->session->sess_destroy('userdata');
		$this->session->flashdata(array('message'=>'Session invalida'));
		redirect('inicio');  
	}

	public function ping(){
		if(isset($_GET["ip"])){
			$ip = (strlen($_GET["ip"])>6?$_GET["ip"]:'172.217.28.99');
			if(strlen($_GET["ip"])<6){ echo "La direccion ip no es correcta... usando ip google.com.co <br><br>";}
			echo "Haciendo ping a: <b>".$ip."</b><br><br>";
		}else{
			echo "No enviaste ip para hacer ping";
		return 0;
		}

		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $ip);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		// Petición HEAD
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		$content = curl_exec($ch);
		if (!curl_errno($ch)) {
		$info = curl_getinfo($ch);
			print_r("\nSe recibió respuesta " . $info['http_code'] . ' en ' . $info['total_time'] . " segundos \n");
		} else {
			print_r("\nError en petición: " . curl_error($ch) . "\n");
		}
		curl_close($ch);
		} else {
			print_r("\nDirección IP no válida: " . $ip . "\n");
		}
	}
}