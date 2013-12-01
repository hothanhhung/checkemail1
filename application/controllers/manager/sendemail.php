<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class SendEmail extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model("member/Newsletter_Model");
			$this->load->model("member/Contact_Model");
			$this->load->helper("url");
			$this->load->library('session');
		}

		public function index()
		{
			
		}
		
		public function runnewsletter()
		{
			//error_log(date('Y-m-d H:i:s').': '.'runnewsletter'.'\n', 3, 'log.log');
			$user = $this->session->userdata('userlogin');
			$username = $this->session->userdata('usernamelogin');
			if(isset($user) && isset($username) && isset($_POST["ID"]))
			{
				//$user=$_POST["user"];
				$id=$_POST["ID"];
			//error_log(date('Y-m-d H:i:s').': '.$user."\n", 3, 'log.log');
				$data = $this->Newsletter_Model->getNewsletter($user, $id);
				$emails = $this->Contact_Model->getAllEmails($user, $data["SendTo"]);
				//print_r($emails);
				foreach($emails as $email)
				{
				error_log(date('Y-m-d H:i:s').': sent to '.$email["StoredEmail"]."\n", 3, 'log.log');
					$this->sendEmailToContact($user, $username, $email["StoredEmail"], $data["Subject"], str_replace('[[Name]]',' '.$email["FullName"],$data["Greet"])."<br/>".$data["Content"]);
				}
				$this->Newsletter_Model->updateSendData($user, $id);
			}
		}
		
		
		function sendEmailToContact($from, $namefrom, $to, $sub, $cont)
		{ 
		
			$config = array(
					'protocol' => 'smtp',
					'smtp_host' => 'ssl://smtp.googlemail.com',
					'smtp_port' => '465',
					'smtp_user' => 'hfwtest01@gmail.com',
					'smtp_pass' => 'qazwsxcd',//Nhớ đánh đúng user và pass nhé
					'charset' => 'utf-8',
					'mailtype'  => 'html',
					'starttls'  => true,
					'newline'   => "\r\n"
			);
			$this->load->library('email',$config);
			

			$this->email->from($from, $namefrom);
			$this->email->to($to);

			$this->email->subject($sub);
			$this->email->message($cont);

			$this->email->send();

			echo $this->email->print_debugger();
		}
		
		
	}
?>