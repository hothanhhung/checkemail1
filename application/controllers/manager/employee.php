<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Employee extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper("url");
			$this->load->model("manager/Employee_Model");
			$this->load->library('session');
		}
		
		public function index()
		{
			
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1")
			{
				$temp['managerlevel']=$managerlevel;
				$numperpage = $this->session->userdata('numberperpage');
				if(!isset($numperpage) || $numperpage == "") $numperpage=10;
				if(isset($_POST["numberperpage"])) $numperpage=$_POST["numberperpage"];
				
				$this->session->set_userdata('numberperpage', $numperpage);
				$temp['managerlogin']=$manager;
				$this->load->library('pagination');
				
				// cấu hình phân trang
				$config['base_url'] = base_url('index.php/manager/employee'); // xác định trang phân trang
				$config['total_rows'] = $this->Employee_Model->countAll(); // xác định tổng số record
				$config['per_page'] = $numperpage; // xác định số record ở mỗi trang
				$config['uri_segment'] = 3; // xác định segment chứa page number
				$this->pagination->initialize($config);

				// echo 'ssssssssssss';
				$sort_by=$this->session->userdata("sort_by_mamager_employee");
				$sort_order=$this->session->userdata("sort_order_mamager_employee");
				
				
				if(isset($sort_by) && isset($sort_order))
				{
					$temp['listemployees']=$this->Employee_Model->getAll($this->uri->segment(3),$config['per_page'],$sort_by,$sort_order);
					$temp["sort_by"]=$sort_by;
					$temp["sort_order"]=$sort_order;
				}
				else
					$temp['listemployees']=$this->Employee_Model->getAll($this->uri->segment(3),$config['per_page']);
				
				$temp['offset']= $this->uri->segment(3);
				$temp['numberperpage']= $numperpage;
				$temp['numberemployees']=$config['total_rows'];
								
				$temp['index']="1";
				$temp['title']="Quản lý danh sách các thành viên";
				$temp['template']='manager/employee_view';
			
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
				$list_sort_by = array(" ","UserName","FullName","MobilePhone", "CreatedDate","UpdatedDate","LastLogin","Level", "Status");
				if($sort_by<0 || $sort_by > count($list_sort_by) - 1) $sort_by=0;
				$this->session->set_userdata("sort_by_mamager_employee",$list_sort_by[$sort_by]);
				$sort_order=$this->session->userdata("sort_order_mamager_employee");
				if(isset($sort_order))
					if($sort_order=='desc')$this->session->set_userdata('sort_order_mamager_employee', 'asc');
					else $this->session->set_userdata('sort_order_mamager_employee', 'desc');
				else $this->session->set_userdata('sort_order_mamager_employee', 'desc');
			}
		}
		public function getinformember()
		{
			
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1" && isset($_POST['username']))
			{
				$username = $_POST['username'];
				$data = $this->Employee_Model->getEmployee($username);
				if(isset($data) && $data!=null)
				{
					 echo json_encode( array("UserName"=>$data["UserName"],"FullName"=>$data["FullName"],"CreatedDate"=>$data["CreatedDate"],
											 "Level"=>$data["Level"],"MobilePhone"=>$data["MobilePhone"]==null?"":$data["MobilePhone"],
											 "Note"=>$data["Note"]==null?"":$data["Note"],"Status"=>$data["Status"] ) );
				}
				else echo "1";
			}else echo "0";
		}
		
		
		public function editemployee()
		{
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1" && isset($_POST['username']))
			{
				$username = $_POST['username'];
				$name = $_POST['name'];
				$phone = $_POST['phone'];
				$level = $_POST['level'];
				$status = $_POST['status'];
				$note = $_POST['note'];
				
				$this->Employee_Model->editEmployee($username, $name, $note, $phone, $level, $status);
				echo "2";
			} else echo "0";		
		}
		
	}
	?>