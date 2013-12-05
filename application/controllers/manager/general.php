<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class General extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper("url");
			$this->load->model("manager/General_Model");
			$this->load->library('session');
		}
		
		public function index()
		{
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1")
			{
			
				$temp['managerlevel']=$managerlevel;
				$temp['managerlogin']=$manager;
				
				
				$temp['generallist']=$this->General_Model->getAll();
				
								
				$temp['index']="2";
				$temp['title']="Quản lý danh sách các trang tĩnh";
				$temp['template']='manager/general_view';
			
				$this->load->view("manager/manager_template",$temp); 
			}else
			{
				header('Location: '. base_url('index.php/manager/index/login'));
			}
		}
		
		public function edit()
		{
			
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1")
			{
				
				if(isset($_POST["txtIDPage"]) && isset($_POST["txtTitlePage"]) && isset($_POST["txtContentPage"]))
				{
					$this->General_Model->editPage($_POST["txtIDPage"],$_POST["txtTitlePage"],$_POST["txtContentPage"]);
					$temp['statusedit']="Lưu thành công";
					
				}
				$id="0";
				if(isset($_GET["ID"])) $id = $_GET["ID"];
				$temp['managerlevel']=$managerlevel;
				$temp['managerlogin']=$manager;
				
				$data=$this->General_Model->getPage($id);
				if($data!=false) $temp['pagecontent']=$data;
				//print_r($data);
								
				$temp['index']="2";
				$temp['title']="Quản lý danh sách các trang tĩnh";
				$temp['template']='manager/general_edit_view';
			
				$this->load->view("manager/manager_template",$temp); 
			}else
			{
				header('Location: '. base_url('index.php/manager/index/login'));
			}
		}
		
	}
	?>