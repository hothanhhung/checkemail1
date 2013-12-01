<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Category extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper("url");
			$this->load->model("member/Category_Model");
			$this->load->library('session');
		}
		
		
		public function index()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				$numperpage = $this->session->userdata('numberperpage_cat');
				if(!isset($numperpage) || $numperpage == "") $numperpage=10;
				if(isset($_POST["numberperpage"])) $numperpage=$_POST["numberperpage"];
				
				$this->session->set_userdata('numberperpage', $numperpage);
				$temp['userlogin']=$user;
				$this->load->library('pagination');
				
				// cấu hình phân trang
				$config['base_url'] = base_url('index.php/member/catelogy'); // xác định trang phân trang
				$config['total_rows'] = $this->Category_Model->count_all($user); // xác định tổng số record
				$config['per_page'] = $numperpage; // xác định số record ở mỗi trang
				$config['uri_segment'] = 3; // xác định segment chứa page number
				$this->pagination->initialize($config);

				// echo 'ssssssssssss';
				$sort_by=$this->session->userdata("sort_by_category_list");
				$sort_order=$this->session->userdata("sort_order_category_list");
				if(isset($sort_by) && isset($sort_order))
				{
					$temp['listcategories']=$this->Category_Model->getCategoryOfUser($user,$this->uri->segment(3),$config['per_page'],$sort_by,$sort_order);
					$temp["sort_by"]=$sort_by;
					$temp["sort_order"]=$sort_order;
				}
				else
					$temp['listcategories']=$this->Category_Model->getCategoryOfUser($user,$this->uri->segment(3),$config['per_page']);
				$temp['offset']= $this->uri->segment(3);
				$temp['numberperpage']= $numperpage;
				$temp['numbercategories']=$config['total_rows'];
			
				$temp['index']="1";
				$temp['title']="Quản lý danh mục";
				$temp['template']='member/category_view';
				$result_addcategory = $this->session->userdata('result_addcategory');
				if(isset($result_addcategory)) $temp['result_addcategory']= $result_addcategory;
				$this->session->set_userdata('result_addcategory', '');
					
				$this->load->view("member/member_template",$temp); 
				
			}
			else
			{
				header('Location: '. base_url('index.php/member/index/login'));
			}
		}
		
		public function deletecategory()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["id"]))
				{
					$id = $_POST["id"];
					$this->Category_Model->deletecategory($user, $id);	
					echo "2";
				}
				else echo "1";
			}else echo "0";
		}
		
		public function addcategory()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["txtCategory"]) && isset($_POST["txtNote"]))
				{
					$cate = $_POST["txtCategory"];
					$note = $_POST["txtNote"];
					
					$this->Category_Model->addcategory($user,$cate, $note);
					$this->session->set_userdata('result_addcategory', '1');
				}
				header('Location: '. base_url('index.php/member/category'));
				
			}
			else
			{
				header('Location: '. base_url('index.php/member/index/login'));
			}
		}
		
		public function setorderparameter()
		{
			if(isset($_POST['sort_by']))
			{
				$sort_by = $_POST['sort_by'];
				$list_sort_by = array("ID","Name","CreatedDate","UpdatedDate", "Note","NumContact");
				if($sort_by<0 || $sort_by > count($list_sort_by) - 1) $sort_by=0;
				$this->session->set_userdata("sort_by_category_list",$list_sort_by[$sort_by]);
				$sort_order=$this->session->userdata("sort_order_category_list");
				if(isset($sort_order))
					if($sort_order=='desc')$this->session->set_userdata('sort_order_category_list', 'asc');
					else $this->session->set_userdata('sort_order_category_list', 'desc');
				else $this->session->set_userdata('sort_order_category_list', 'desc');
			}
		}
		
		public function editcategory()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["name"]) && isset($_POST["id"]) && isset($_POST["note"]))
				{
					$name = $_POST["name"];
					$note = $_POST["note"];
					$id = $_POST["id"];
					$this->Category_Model->editcategory($user, $name, $id, $note);	
					echo "2";
				}
				else echo "1";
			}else echo "0";
		}
		
		
	}
?>