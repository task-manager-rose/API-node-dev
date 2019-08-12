<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_process extends CI_Controller
{
    public $api = "http://190.146.247.240:3000/";
	public function __construct()
	{
		parent::__construct();
		//$this->load->database();
		$this->load->library(array('form_validation','session'));
        $this->load->helper(array('url', 'language'));
		//$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
    }
    
    public function login(){
         // Method: POST, PUT, GET etc 
         // Data: array("param" => "value") ==> index.php?param=value 
         $data = array('email'=>$_POST['user'],'password'=>$_POST['pwr']);
         $login = $this->CallAPI('POST', $this->api.'users/login', json_encode($data));
         if($login['code']==200){
             $r = json_decode($login['result']);
             $userdata = array(
                'name'=>$r->user->name,
                'email'=>$r->user->email,
                '_id'=>$r->user->_id,
                'token'=>$r->token
            );
            $this->session->set_userdata($userdata);
            echo json_encode($login);
         }else{
            $login['message'] = $this->responseCodeT($login['code']);
            echo json_encode($login);
         } 
    }
    public function getTasks(){
        if(!isset($_SESSION['token']) and strlen($this->session->userdata('token'))<8){
            $this->session->sess_destroy();
            $this->session->flashdata(array('message'=>'Session invalida'));
            redirect('inicio');  
        }
        
        $tasks = $this->CallAPI('GET', $this->api.'task/', false,$_SESSION['token']);
        if($tasks['code']==200){
            $taskj = json_decode($tasks['result']);
            $html = "";
            foreach($taskj as $k => $v){
                $html.= "<tr><td>".$v->description."</td><td>".($v->completed==false?"<i class='fa fa-times-circle-o' style='color:red' aria-hidden='true'></i>":"<i class='fa fa-check-circle-o' style='color:green' aria-hidden='true'></i>")."</td>";
                $html.= "<td><a href='#' onclick=\"editTask('".$v->_id."')\"><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>";
                $html.= "</tr>";
            }
        }
        $tasks['result'] = $html;
        echo json_encode($tasks);
    }
    public function getTask(){

        if(!isset($_SESSION['token']) and strlen($this->session->userdata('token'))<8){
            $this->session->sess_destroy();
            $this->session->flashdata(array('message'=>'Session invalida'));
            redirect('inicio');  
        }
        
        $tasks = $this->CallAPI('GET', $this->api.'task/'.$_POST['idTask'], false,$_SESSION['token']);    
        echo json_encode($tasks);
    }

    public function updateTask(){
        if(!isset($_SESSION['token']) and strlen($this->session->userdata('token'))<8){
            $this->session->sess_destroy();
            $this->session->flashdata(array('message'=>'Session invalida'));
            redirect('inicio');  
        }
        $comp = ($_POST['completed']=='true'?true:false);
        $data = array('description'=>$_POST['description'],'completed'=>$comp);

        $tasks = $this->CallAPI('PATCH', $this->api.'task/'.$_POST['idTask'], $data,$_SESSION['token']);
        echo json_encode($tasks);
    }
    public function setNewTask(){
        if(!isset($_SESSION['token']) and strlen($this->session->userdata('token'))<8){
            $this->session->sess_destroy();
            $this->session->flashdata(array('message'=>'Session invalida'));
            redirect('inicio');  
        }

        $data = array('description'=>$_POST['description']);
        $data = json_encode($data);
        $tasks = $this->CallAPI('POST', $this->api.'task', $data , $_SESSION['token']);
        echo json_encode($tasks);
    }

    public function getUserInfo(){
        if(!isset($_SESSION['token']) and strlen($this->session->userdata('token'))<8){
            $this->session->sess_destroy();
            $this->session->flashdata(array('message'=>'Session invalida'));
            redirect('inicio');  
        }
        
        $tasks = $this->CallAPI('GET', $this->api.'users', false,$_SESSION['token']);    
        echo json_encode($tasks);
    }

    public function CallAPI($method, $url, $data = false, $authorization=false)
    {
        $curl = curl_init();
    
        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data){
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            case "PATCH":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
                if ($data){
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
    
        // Optional Authentication:
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($curl, CURLOPT_USERPWD, "username:password");
        $headers=array('Content-Type: application/json');
        if($authorization){
            array_push($headers, 'Authorization: Bearer '.$authorization);
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($curl, CURLOPT_HEADER  , true);
        $result = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return array('result'=>$result,'code'=>$httpcode);
    }

    public function responseCodeT($code){
        $http_status_codes = array(
            100 => 'Informational: Continue',101 => 'Informational: Switching Protocols',102 => 'Informational: Processing',200 => 'Successful: OK',201 => 'Successful: Created',202 => 'Successful: Accepted',
            203 => 'Successful: Non-Authoritative Information',204 => 'Successful: No Content',205 => 'Successful: Reset Content',206 => 'Successful: Partial Content',
            207 => 'Successful: Multi-Status',208 => 'Successful: Already Reported',226 => 'Successful: IM Used',300 => 'Redirection: Multiple Choices',
            301 => 'Redirection: Moved Permanently',302 => 'Redirection: Found',303 => 'Redirection: See Other',304 => 'Redirection: Not Modified',
            305 => 'Redirection: Use Proxy',306 => 'Redirection: Switch Proxy',307 => 'Redirection: Temporary Redirect',308 => 'Redirection: Permanent Redirect',
            400 => 'Client Error: Bad Request',401 => 'Client Error: Unauthorized',402 => 'Client Error: Payment Required',403 => 'Client Error: Forbidden',
            404 => 'Client Error: Not Found',405 => 'Client Error: Method Not Allowed',406 => 'Client Error: Not Acceptable',407 => 'Client Error: Proxy Authentication Required',
            408 => 'Client Error: Request Timeout',409 => 'Client Error: Conflict',410 => 'Client Error: Gone',411 => 'Client Error: Length Required',
            412 => 'Client Error: Precondition Failed',413 => 'Client Error: Request Entity Too Large',414 => 'Client Error: Request-URI Too Long',415 => 'Client Error: Unsupported Media Type',
            416 => 'Client Error: Requested Range Not Satisfiable',417 => 'Client Error: Expectation Failed',418 => 'Client Error: I\'m a teapot',419 => 'Client Error: Authentication Timeout',
            420 => 'Client Error: Enhance Your Calm',420 => 'Client Error: Method Failure',422 => 'Client Error: Unprocessable Entity',423 => 'Client Error: Locked',
            424 => 'Client Error: Failed Dependency',424 => 'Client Error: Method Failure',425 => 'Client Error: Unordered Collection',426 => 'Client Error: Upgrade Required',
            428 => 'Client Error: Precondition Required',429 => 'Client Error: Too Many Requests',431 => 'Client Error: Request Header Fields Too Large',444 => 'Client Error: No Response',
            449 => 'Client Error: Retry With',450 => 'Client Error: Blocked by Windows Parental Controls',451 => 'Client Error: Redirect',451 => 'Client Error: Unavailable For Legal Reasons',
            494 => 'Client Error: Request Header Too Large',495 => 'Client Error: Cert Error',496 => 'Client Error: No Cert',497 => 'Client Error: HTTP to HTTPS',
            499 => 'Client Error: Client Closed Request',500 => 'Server Error: Internal Server Error',501 => 'Server Error: Not Implemented',502 => 'Server Error: Bad Gateway',
            503 => 'Server Error: Service Unavailable',504 => 'Server Error: Gateway Timeout',505 => 'Server Error: HTTP Version Not Supported',506 => 'Server Error: Variant Also Negotiates',
            507 => 'Server Error: Insufficient Storage',508 => 'Server Error: Loop Detected',509 => 'Server Error: Bandwidth Limit Exceeded',510 => 'Server Error: Not Extended',
            511 => 'Server Error: Network Authentication Required',598 => 'Server Error: Network read timeout error',599 => 'Server Error: Network connect timeout error',);
        if(array_key_exists($code, $http_status_codes)){
            return $http_status_codes[$code];
        }else{
            return '';
        }
    }

}