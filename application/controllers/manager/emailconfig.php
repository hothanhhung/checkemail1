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
					if(isset($_POST["txtPasswordEmailConfigAdd"]) && isset($_POST["txtPasswordAgainEmailConfigAdd"])&&$_POST["txtPasswordEmailConfigAdd"]==$_POST["txtPasswordAgainEmailConfigAdd"])
					{
						$this->EmailConfig_Model->add($_POST["txtAddressEmailConfigAdd"],$_POST["txtProtocolEmailConfigAdd"],$_POST["txtSMTPHostEmailConfigAdd"],$_POST["txtSMTPPortEmailConfigAdd"],$_POST["txtNumberSendPerDateEmailConfigAdd"],$_POST["txtPasswordEmailConfigAdd"],$_POST["txtNoteEmailConfigAdd"],$_POST["sbStatusEmailConfigAdd"]);
						$this->session->set_userdata('result_addemailconfig', 'Thêm thành công');
					}
					else $this->session->set_userdata('result_addemailconfig', 'Mật khẩu xác nhận không đúng');
					
				}
				else $this->session->set_userdata('result_addemailconfig', 'Thông tin không đủ');
				header('Location: '. base_url('index.php/manager/emailconfig'));
			}else
			{
				header('Location: '. base_url('index.php/manager/index/login'));
			}
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