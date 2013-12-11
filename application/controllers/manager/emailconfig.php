<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class EmailConfig extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper("url");
			$this->load->model("manager/EmailConfig_Model");
			$this->load->library('session');
		}
		
		public function index()
		{
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1")
			{
				
				$result_addemailconfig = $this->session->userdata('result_addemailconfig');
				if(isset($result_addemailconfig)&& $result_addemailconfig!="")
				{
					$temp['result_addemailconfig']=$result_addemailconfig;
					$this->session->set_userdata('result_addemailconfig', '');
				}
				
				$temp['managerlevel']=$managerlevel;
				$numperpage = $this->session->userdata('numberperpage');
				if(!isset($numperpage) || $numperpage == "") $numperpage=10;
				if(isset($_POST["numberperpage"])) $numperpage=$_POST["numberperpage"];
				
				$this->session->set_userdata('numberperpage', $numperpage);
				$temp['managerlogin']=$manager;
				$this->load->library('pagination');
				
				// cấu hình phân trang
				$config['base_url'] = base_url('index.php/manager/emailconfig'); // xác định trang phân trang
				$config['total_rows'] = $this->EmailConfig_Model->countAll(); // xác định tổng số record
				$config['per_page'] = $numperpage; // xác định số record ở mỗi trang
				$config['uri_segment'] = 3; // xác định segment chứa page number
				$this->pagination->initialize($config);

				// echo 'ssssssssssss';
				$sort_by=$this->session->userdata("sort_by_mamager_emailconfig");
				$sort_order=$this->session->userdata("sort_order_mamager_emailconfig");
				
				
				if(isset($sort_by) && isset($sort_order))
				{
					$temp['emailconfiglist']=$this->EmailConfig_Model->getAll($this->uri->segment(3),$config['per_page'],$sort_by,$sort_order);
					$temp["sort_by"]=$sort_by;
					$temp["sort_order"]=$sort_order;
				}
				else
					$temp['emailconfiglist']=$this->EmailConfig_Model->getAll($this->uri->segment(3),$config['per_page']);
				
				$temp['offset']= $this->uri->segment(3);
				$temp['numberperpage']= $numperpage;
				$temp['numberemailconfig']=$config['total_rows'];
				
								
				$temp['index']="2";
				$temp['title']="Cấu hình gửi thư";
				$temp['template']='manager/emailconfig_view';
			
				$this->load->view("manager/manager_template",$temp); 
			}else
			{
				header('Location: '. base_url('index.php/manager/index/login'));
			}
		}
								   
		
		public function add()
		{
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1")
			{
				if(isset($_POST["txtAddressEmailConfigAdd"]) && $_POST["txtAddressEmailConfigAdd"]!="" && isset($_POST["txtProtocolEmailConfigAdd"]) && $_POST["txtProtocolEmailConfigAdd"]!="" &&
					isset($_POST["txtSMTPHostEmailConfigAdd"]) && $_POST["txtSMTPHostEmailConfigAdd"] !="" && isset($_POST["txtSMTPPortEmailConfigAdd"]) && $_POST["txtSMTPPortEmailConfigAdd"]!="")
				{
					if($this->EmailConfig_Model->getEmailConfig($_POST["txtAddressEmailConfigAdd"])==false)
						if(isset($_POST["txtPasswordEmailConfigAdd"]) && isset($_POST["txtPasswordAgainEmailConfigAdd"])&&$_POST["txtPasswordEmailConfigAdd"]==$_POST["txtPasswordAgainEmailConfigAdd"])
						{
							$this->EmailConfig_Model->add($_POST["txtAddressEmailConfigAdd"],$_POST["txtProtocolEmailConfigAdd"],$_POST["txtSMTPHostEmailConfigAdd"],$_POST["txtSMTPPortEmailConfigAdd"],$_POST["txtNumberSendPerDateEmailConfigAdd"],$_POST["txtPasswordEmailConfigAdd"],$_POST["txtNoteEmailConfigAdd"],$_POST["sbStatusEmailConfigAdd"]);
							$this->session->set_userdata('result_addemailconfig', 'Thêm thành công');
						}
						else $this->session->set_userdata('result_addemailconfig', 'Mật khẩu xác nhận không đúng');
					else $this->session->set_userdata('result_addemailconfig', 'Email này đã tồn tại');
				}
				else $this->session->set_userdata('result_addemailconfig', 'Thông tin không đủ');
				header('Location: '. base_url('index.php/manager/emailconfig'));
			}else
			{
				header('Location: '. base_url('index.php/manager/index/login'));
			}
		}
		
		public function getinforemailconfig()
		{
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			$result = array();
			
			$result["ErrorCode"]="1";
			$result["Infor"]="Lỗi không xác định";
			
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1")
			{
				if(isset($_POST["email"]))
				{
					$data = $this->EmailConfig_Model->getEmailConfig($_POST["email"]);
					if($data==false)
					{
						$result["ErrorCode"]="1";
						$result["Infor"]="Email không tồn tại";
					}
					else
					{
						$result["ErrorCode"]="0";
						$result["Infor"]="Lấy thông tin thành công";
						$result["Email"]=$data["Email"];
						$result["Protocol"]=$data["Protocol"];
						$result["smtp_host"]=$data["smtp_host"];
						$result["smtp_port"]=$data["smtp_port"];
						$result["NumberSendPerDate"]=$data["NumberSendPerDate"];
						$result["Password"]=$data["Password"];
						$result["Note"]=$data["Note"]==null?"":$data["Note"];
						$result["Status"]=$data["Status"];
					}
				} 
				else {
					$result["ErrorCode"]="1";
					$result["Infor"]="Không gửi thông tin email";
				}
			}else {
				$result["ErrorCode"]="1";
				$result["Infor"]="Không có quyền";
			}
			echo json_encode($result);
		}
		
		public function addemailconfig()
		{
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			$result = array();
			
			$result["ErrorCode"]="1";
			$result["Infor"]="Lỗi không xác định";
			
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1")
			{
				if(isset($_POST["Email"]))
				{
					$email = $_POST["Email"];
					if($this->EmailConfig_Model->getEmailConfig($email)==false){
						$protocol =$_POST["Protocol"];
						$SMTPHost = $_POST["smtp_host"];
						$SMTPPort = $_POST["smtp_port"];
						$NumberSendPerDate = $_POST["NumberSendPerDate"];
						$Password = $_POST["Password"];
						$note = $_POST["note"];
						$status = $_POST["status"];
						$data = $this->EmailConfig_Model->add($email,$protocol,$SMTPHost,$SMTPPort,$NumberSendPerDate,$Password,$note,$status);
						$result["ErrorCode"]="0";
						$result["Infor"]="Lưu thành công";
					}else{
					$result["ErrorCode"]="1";
					$result["Infor"]="Địa chỉ email đã tồn tại";
				}
			
				} 
				else {
					$result["ErrorCode"]="1";
					$result["Infor"]="Không gửi thông tin email";
				}
			}else {
				$result["ErrorCode"]="1";
				$result["Infor"]="Không có quyền";
			}
			echo json_encode($result);
		}
		
		public function editemailconfig()
		{
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			$result = array();
			
			$result["ErrorCode"]="1";
			$result["Infor"]="Lỗi không xác định";
			
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1")
			{
				if(isset($_POST["Email"]))
				{
					$email = $_POST["Email"];
					$protocol =$_POST["Protocol"];
					$SMTPHost = $_POST["smtp_host"];
					$SMTPPort = $_POST["smtp_port"];
					$NumberSendPerDate = $_POST["NumberSendPerDate"];
					$Password = $_POST["Password"];
					$note = $_POST["note"];
					$status = $_POST["status"];
					$data = $this->EmailConfig_Model->editEmailConfig($email,$protocol,$SMTPHost,$SMTPPort,$NumberSendPerDate,$Password,$status,$note);
					$result["ErrorCode"]="0";
					$result["Infor"]="Lưu thành công";
			
				} 
				else {
					$result["ErrorCode"]="1";
					$result["Infor"]="Không gửi thông tin email";
				}
			}else {
				$result["ErrorCode"]="1";
				$result["Infor"]="Không có quyền";
			}
			echo json_encode($result);
		}
		
		public function checkemailconfig()
		{
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			$result = array();
			
			$result["ErrorCode"]="1";
			$result["Infor"]="Lỗi không xác định";
			
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1")
			{
				if(isset($_POST["Email"]))
				{
					$email = $_POST["Email"];
					$protocol =$_POST["Protocol"];
					$SMTPHost = $_POST["smtp_host"];
					$SMTPPort = $_POST["smtp_port"];
					$Password = $_POST["Password"];
					$To = isset($_POST["To"])?$_POST["To"]:"hfwtest01@gmail.com";
					$this->_smtp_connect = @fsockopen($SMTPHost,
										$SMTPPort,
										$errnosave,
										$errstrsave,
										5);
					if($errnosave!=0 || $this->_smtp_connect==false){
						$result["ErrorCode"]="1";
						$result["Infor"]="Không thể mở kết nối. Kiểm tra host và cổng SMTP";
						echo json_encode($result);
						return;
					}
					
					
					$config = array(
								'protocol' => $protocol,
								'smtp_host' => $SMTPHost,
								'smtp_port' => $SMTPPort,
								'smtp_user' => $email,
								'smtp_pass' => $Password,//Nhớ đánh đúng user và pass nhé
								'charset' => 'utf-8',
								'mailtype'  => 'html',
								'starttls'  => true,
								'newline'   => "\r\n"
						);
						$this->load->library('email',$config);
						

						$this->email->from($email, $email);
						$this->email->to($To);

						$this->email->subject("test config");
						$this->email->message('test config');
					
					
						$data =	$this->email->send();
						$result["ErrorCode"]="1";
						if($data==true)
							$result["Infor"]='Kiểm tra hộp thư đến. Nếu không thấy vui lòng kiểm tra protocol';
						else $result["Infor"]='Có thể password hoặc địa chỉ hộp thư đến không đúng';
					
				} 
				else {
					$result["ErrorCode"]="1";
					$result["Infor"]="Không gửi thông tin email";
				}
			}else {
				$result["ErrorCode"]="1";
				$result["Infor"]="Không có quyền";
			}
			echo json_encode($result);
		}
		
		public function setorderparameter()
		{
			if(isset($_POST['sort_by']))
			{
				$sort_by = $_POST['sort_by'];
				$list_sort_by = array("ID","Email","Protocol","smtp_host", "smtp_port","CreatedDate","LastUsedDate","NumberSentEmail", "NumberSendPerDate", "NumberSentEmailToday","Note", "Status");
				if($sort_by<0 || $sort_by > count($list_sort_by) - 1) $sort_by=0;
				$this->session->set_userdata("sort_by_mamager_employee",$list_sort_by[$sort_by]);
				$sort_order=$this->session->userdata("sort_order_mamager_employee");
				if(isset($sort_order))
					if($sort_order=='desc')$this->session->set_userdata('sort_order_mamager_emailconfig', 'asc');
					else $this->session->set_userdata('sort_order_mamager_emailconfig', 'desc');
				else $this->session->set_userdata('sort_order_mamager_emailconfig', 'desc');
			}
		}
	}
	?>