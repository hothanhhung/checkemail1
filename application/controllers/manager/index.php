<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Index extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model("manager/Manager_Model");
			$this->load->helper("url");
			$this->load->library('session');
		}

		public function index()
		{
			$manager = $this->session->userdata('managerlogin');
			if(isset($manager) && $manager!="")
			{
				$this->load->view("manager/manager_template"); 
			}else header('Location: '. base_url('index.php/manager/index/login'));
		}
		
		
		public function login()
		{
			if(isset($_POST["email-signin"]) && isset($_POST["password-signin"]))
			{
				$user = $_POST["email-signin"];
				$pass = $_POST["password-signin"];
				$data = $this->Manager_Model->signIn($user,$pass);
				if(isset($data))
				{
					if($data["Status"]==1){
						$this->session->set_userdata('managerlogin', $data["UserName"]);
						$this->session->set_userdata('managerloginlevel', $data["Level"]);
						header('Location: '. base_url('index.php/manager/index'));
					}else{
						$data["errorlogin"]="Tên đăng nhập tạm thời bị khóa.<br/>Vui lòng liên hệ người quản lý.";
						$this->load->view("manager/manager_login_view", $data); 
					}
				}
				else {
					$data["errorlogin"]="Tên đăng nhập và mật khẩu không khớp";
					$this->load->view("manager/manager_login_view", $data); 
				}
				
			}
			else $this->load->view("manager/manager_login_view"); 
		}
		
		public function logouttool()
		{
			$this->session->set_userdata('managerlogin', '');
			$this->session->set_userdata('managerloginlevel', '');
			header('Location: '. base_url('index.php/manager/index/login'));
		}
		
		
	}
?>