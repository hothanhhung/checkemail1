<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Index extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model("member/Index_Model");
			$this->load->helper("url");
			$this->load->library('session');
		}

		public function index()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				$this->load->view("member/member_template"); 
			}else header('Location: '. base_url('index.php/member/index/login'));
		}
		
		public function signup()
		{
			
			if(isset($_POST["fullname"]) && isset($_POST["email"]) && isset($_POST["pass"]))
			{
				$fullname = $_POST["fullname"];
				$email = $_POST["email"];
				$pass = $_POST["pass"];
				$mobilephone = "";
				if(isset($_POST["mobilephone"])) $mobilephone = $_POST["mobilephone"];
				if($this->Index_Model->signUp($fullname,$email,$pass,$mobilephone))
				{
					$this->session->set_userdata('userlogin', $email);
					echo "2";
				}
				else echo "1";
				
			}else
			{
				echo "0";
			}
		}
		
		public function signinajax()
		{
			if(isset($_POST["email"]) && isset($_POST["pass"]))
			{
				$email = $_POST["email"];
				$pass = $_POST["pass"];
				
				$name = $this->Index_Model->signIn($email,$pass);
				if($name!="")
				{
					$this->session->set_userdata('userlogin', $email);
					$this->session->set_userdata('usernamelogin', $name);
					echo "2";
				}
				else echo "1";
				
			}else
			{
				echo "0";
			}
		}
		
		public function login()
		{
			if(isset($_POST["email-signin"]) && isset($_POST["password-signin"]))
			{
				$email = $_POST["email-signin"];
				$pass = $_POST["password-signin"];
				$name = $this->Index_Model->signIn($email,$pass);
				if($name!="")
				{
					$this->session->set_userdata('userlogin', $email);
					$this->session->set_userdata('usernamelogin', $name);
					header('Location: '. base_url('index.php/member/index'));
				}
				else {
					$data["errorlogin"]=1;
					$this->load->view("member/member_login_view", $data); 
				}
				
			}
			else $this->load->view("member/member_login_view"); 
		}
		
		public function logout()
		{
			$this->session->set_userdata('userlogin', '');
			echo "1";
		}
		
		public function logouttool()
		{
			$this->session->set_userdata('userlogin', '');
			header('Location: '. base_url('index.php/member/index/login'));
		}
		
		public function getprofile()
		{
			if(isset($_POST["email"]))
			{
				$email = $_POST["email"];
				$data = $this->Index_Model->getProfile($email);
				if(isset($data) && $data!=null)
				{
					echo json_encode( array( "email"=>$data["EmailAddress"],
											"mobilephone"=>$data["MobilePhone"],
											"name"=>$data["Name"], "level"=>$data["Level"] ) );
				}
				else echo "1";
				
			}else
			{
				echo "0";
			}
		}
				
		public function saveprofile()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["fullname"]) && isset($_POST["mobilephone"]) && isset($_POST["pass"]) 
					&& isset($_POST["newpass"]) && isset($_POST["changepass"]))
				{
					$fullname = $_POST["fullname"];
					$mobilephone = $_POST["mobilephone"];
					$pass = $_POST["pass"];
					$newpass = $_POST["newpass"];
					$changepass = $_POST["changepass"];
					
					if($changepass=='true')
					{
						if($this->Index_Model->checkPass($user,$pass))
						{
							$this->Index_Model->saveProfile($user, $fullname, $mobilephone, $newpass);
							echo "2";
						}
						else echo "1";
					}else
					{
						$this->Index_Model->saveProfile($user, $fullname, $mobilephone);
						echo "2";
					}
					
				}else
				{
					echo "0";
				}
			}else echo "0";
		}
	}
?>