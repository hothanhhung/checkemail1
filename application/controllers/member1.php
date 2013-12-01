<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Member extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper("url");
			$this->load->model("Member_Model");
			$this->load->library('session');
		}

		public function index()
		{
			
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				$numperpage = $this->session->userdata('numberperpage');
				if(!isset($numperpage) || $numperpage == "") $numperpage=10;
				if(isset($_POST["numberperpage"])) $numperpage=$_POST["numberperpage"];
				
				$this->session->set_userdata('numberperpage', $numperpage);
				$temp['userlogin']=$user;
				$this->load->library('pagination');
				
				// cấu hình phân trang
				$config['base_url'] = base_url('index.php/member'); // xác định trang phân trang
				$config['total_rows'] = $this->Member_Model->count_all($user); // xác định tổng số record
				$config['per_page'] = $numperpage; // xác định số record ở mỗi trang
				$config['uri_segment'] = 2; // xác định segment chứa page number
				$this->pagination->initialize($config);

				// echo 'ssssssssssss';
				$sort_by=$this->session->userdata("sort_by_member_storedemail");
				$sort_order=$this->session->userdata("sort_order_member_storedemail");
				if(isset($sort_by) && isset($sort_order))
				{
					$temp['listemails']=$this->Member_Model->getEmailOfUser($user,$this->uri->segment(2),$config['per_page'],$sort_by,$sort_order);
					$temp["sort_by"]=$sort_by;
					$temp["sort_order"]=$sort_order;
				}
				else
					$temp['listemails']=$this->Member_Model->getEmailOfUser($user,$this->uri->segment(2),$config['per_page']);
				$temp['offset']= $this->uri->segment(2);
				$temp['numberperpage']= $numperpage;
			}
			$temp['index']="3";
			$temp['title']="Quản lý tài nguyên";
			$temp['template']='member_view';
			
			$this->load->view("mylayout",$temp); 
		}
		
		public function setorderparameter()
		{
			if(isset($_POST['sort_by']))
			{
				$sort_by = $_POST['sort_by'];
				$list_sort_by = array("ID","StoredEmail","CreatedDate","UpdatedDate", "Status", "Domain","Note");
				if($sort_by<0 || $sort_by > count($list_sort_by) - 1) $sort_by=0;
				$this->session->set_userdata("sort_by_member_storedemail",$list_sort_by[$sort_by]);
				$sort_order=$this->session->userdata("sort_order_member_storedemail");
				if(isset($sort_order))
					if($sort_order=='desc')$this->session->set_userdata('sort_order_member_storedemail', 'asc');
					else $this->session->set_userdata('sort_order_member_storedemail', 'desc');
				else $this->session->set_userdata('sort_order_member_storedemail', 'desc');
			}
		}
		
		public function addemails()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				$data;
				if(isset($_FILES["flEmail"])) 
				{
					
					$this->load->helper('checkemail_helper');
					$data = getListEmails($_FILES["flEmail"]);
				}
				if(isset($data))
				{
					foreach($data as $row)
					{ 
						$emailParts = explode("@", trim($row));
						if(isset($emailParts[1])&& $emailParts[1]!="")
						{
							$domain = $emailParts[1];
							$this->Member_Model->addEmail($user,$row,"",$domain);						
						}
					}
				}
				// $temp['userlogin']=$user;
				// $temp['listemails']=$this->Member_Model->getEmailOfUser($user,0,10);
			}
			// $temp['index']="3";
			// $temp['title']="Quản lý tài nguyên";
			// $temp['template']='member_view';
			
			// $this->load->view("mylayout",$temp); 
			header('Location: '. base_url('index.php/member'));
		}
		
		
		public function addemail()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["txtEmailAdd"]) && isset($_POST["txtEmailNote"]))
				{
					$email = $_POST["txtEmailAdd"];
					$note = $_POST["txtEmailNote"];
					$emailParts = explode("@", trim($email));
					if(isset($emailParts[1])&& $emailParts[1]!="")
					{
						$domain = $emailParts[1];
						$this->Member_Model->addEmail($user,$email,$note,$domain);						
					}
				}
				//$temp['userlogin']=$user;
				//$temp['listemails']=$this->Member_Model->getEmailOfUser($user,0,10);
			}
			// $temp['index']="3";
			// $temp['title']="Quản lý tài nguyên";
			// $temp['template']='member_view';
			
			// $this->load->view("mylayout",$temp); 
			header('Location: '. base_url('index.php/member'));
		}
		
		public function deletemultistoredemail()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["ids"]))
				{
					$ids = $_POST["ids"];
					$this->Member_Model->deletemultistoredemail($user, $ids);	
					echo "2";
				}
				else echo "1";
			}else echo "0";
		}
		
		public function deletestoredemail()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["id"]))
				{
					$id = $_POST["id"];
					$this->Member_Model->deletestoredemail($user, $id, $note);	
					echo "2";
				}
				else echo "1";
			}else echo "0";
		}
		
		public function editnote()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["note"]) && isset($_POST["id"]))
				{
					$note = $_POST["note"];
					$id = $_POST["id"];
					$this->Member_Model->editnote($user, $id, $note);	
					echo "2";
				}
				else echo "1";
			}else echo "0";
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
				if($this->Member_Model->signUp($fullname,$email,$pass,$mobilephone))
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
		
		public function signout()
		{
			$this->session->set_userdata('userlogin', '');
			echo "1";
		}
		
		public function getprofile()
		{
			if(isset($_POST["email"]))
			{
				$email = $_POST["email"];
				$data = $this->Member_Model->getProfile($email);
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
		
		public function signin()
		{
			if(isset($_POST["email"]) && isset($_POST["pass"]))
			{
				$email = $_POST["email"];
				$pass = $_POST["pass"];
				
				if($this->Member_Model->signIn($email,$pass))
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
	}
	?>