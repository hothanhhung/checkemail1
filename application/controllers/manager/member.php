<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Member extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper("url");
			$this->load->model("manager/Member_Model");
			$this->load->library('session');
		}
		
		public function index()
		{
			
			$manager = $this->session->userdata('managerlogin');
			if(isset($manager)&&$manager!="")
			{
				$managerlevel = $this->session->userdata('managerloginlevel');
				$temp['managerlevel']=$managerlevel;
				$numperpage = $this->session->userdata('numberperpage');
				if(!isset($numperpage) || $numperpage == "") $numperpage=10;
				if(isset($_POST["numberperpage"])) $numperpage=$_POST["numberperpage"];
				
				$this->session->set_userdata('numberperpage', $numperpage);
				$temp['managerlogin']=$manager;
				$this->load->library('pagination');
				
				// cấu hình phân trang
				$config['base_url'] = base_url('index.php/manager/member'); // xác định trang phân trang
				$config['total_rows'] = $this->Member_Model->countAll($manager, $managerlevel); // xác định tổng số record
				$config['per_page'] = $numperpage; // xác định số record ở mỗi trang
				$config['uri_segment'] = 3; // xác định segment chứa page number
				$this->pagination->initialize($config);

				// echo 'ssssssssssss';
				$sort_by=$this->session->userdata("sort_by_mamager_member");
				$sort_order=$this->session->userdata("sort_order_mamager_member");
				
				
				if(isset($sort_by) && isset($sort_order))
				{
					$temp['listmembers']=$this->Member_Model->getAll($manager, $managerlevel, $this->uri->segment(3),$config['per_page'],$sort_by,$sort_order);
					$temp["sort_by"]=$sort_by;
					$temp["sort_order"]=$sort_order;
				}
				else
					$temp['listmembers']=$this->Member_Model->getAll($manager,$managerlevel, $this->uri->segment(3),$config['per_page']);
				
				$temp['offset']= $this->uri->segment(3);
				$temp['numberperpage']= $numperpage;
				$temp['numbermembers']=$config['total_rows'];
								
				
				$this->load->model("manager/Manager_Model");
				$temp['listmanagers']=$this->Manager_Model->getAll();
				$temp['index']="1";
				$temp['title']="Quản lý danh sách các thành viên";
				$temp['template']='manager/member_view';
			
				$this->load->view("manager/manager_template",$temp); 
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
				$list_sort_by = array(" ","Name","EmailAddress","MobilePhone", "Manager","DateRegistry","UpdatedDate","LastDateLogin","Level", "Status");
				if($sort_by<0 || $sort_by > count($list_sort_by) - 1) $sort_by=0;
				$this->session->set_userdata("sort_by_mamager_member",$list_sort_by[$sort_by]);
				$sort_order=$this->session->userdata("sort_order_mamager_member");
				if(isset($sort_order))
					if($sort_order=='desc')$this->session->set_userdata('sort_order_mamager_member', 'asc');
					else $this->session->set_userdata('sort_order_mamager_member', 'desc');
				else $this->session->set_userdata('sort_order_mamager_member', 'desc');
			}
		}
		
		public function getinformember()
		{
			$manager = $this->session->userdata('managerlogin');
			if(isset($manager) && $manager !="" && isset($_POST['email']))
			{
				$email = $_POST['email'];
				$managerlevel = $this->session->userdata('managerloginlevel');
				$data = $this->Member_Model->getMember($manager, $managerlevel, $email);
				if(isset($data) && $data!=null)
				{
					 echo json_encode( array("EmailAddress"=>$data["EmailAddress"],"Name"=>$data["Name"],"DateRegistry"=>$data["DateRegistry"],
											 "Level"=>$data["Level"],"MobilePhone"=>$data["MobilePhone"],
											 "Manager"=>$data["Manager"],"Status"=>$data["Status"] ) );
				}
				else echo "1";
			}else echo "0";
		}
		
		public function editmember()
		{
			$manager = $this->session->userdata('managerlogin');
			if(isset($manager) && $manager !="" && isset($_POST['email']))
			{
				$email = $_POST['email'];
				$name = $_POST['name'];
				$phone = $_POST['phone'];
				$level = $_POST['level'];
				$status = $_POST['status'];
				$managerlevel = $this->session->userdata('managerloginlevel');
				$setmanager = null;
				if(isset($managerlevel) && $managerlevel == "1") $setmanager = $_POST['manager'];
				if($setmanager=="0") $setmanager=null;
				$this->Member_Model->editMember($manager, $managerlevel, $email, $name, $setmanager, $phone, $level, $status);
				echo "2";
			} else echo "0";		
		}
	}
	?>