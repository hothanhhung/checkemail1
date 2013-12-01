<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Newsletter extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper("url");
			$this->load->model("member/Newsletter_Model");
			$this->load->library('session');
		}
		
		
		public function index()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				
			}
			else
			{
				header('Location: '. base_url('index.php/member/index/login'));
			}
		}
		
		public function create()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				$this->load->helper('file');
				$dirs = get_dir_file_info('./newsletters/', true);
				
				$temp['listTemplate']=$dirs;
				$temp['index']="3";
				$temp['title']="Tạo mới thư gửi";
				$temp['template']='member/newsletter_create_step1_view';			
				$this->load->view("member/member_template",$temp);
			}else header('Location: '. base_url('index.php/member/index/login'));
		}
		
		public function readfromws()
		{
			if(isset($_POST["url"]))
			{
				$templatenewsletter = file_get_contents ($_POST["url"]);
				if($templatenewsletter==false ) echo "1";
				else echo $templatenewsletter;
			} echo "0";
		}
		
		public function createstep2()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["txtNameNewsletter"]))
				{
					$namenewsletter = $_POST["txtNameNewsletter"];
					$templatenewsletter="";
					if(isset($_POST["slTemplate"]))
					{
						$this->load->helper('file');
						$templatenewsletter = read_file('./newsletters/'.$_POST["slTemplate"].'/html/newsletter.html');
					}
					
					
					$temp['namenewsletter']=$namenewsletter;
					$temp['templatenewsletter']=$templatenewsletter;
					$temp['index']="3";
					$temp['title']="Tạo mới thư gửi";
					$temp['template']='member/newsletter_create_step2_view';			
					$this->load->view("member/member_template",$temp);
				}else header('Location: '. base_url('index.php/member/newsletter/create'));
			}else header('Location: '. base_url('index.php/member/index/login'));
		}
		
		public function test()
		{
			$user = $this->session->userdata('userlogin');
			$temp['listcategories']=$this->Newsletter_Model->getCategoryOfUser($user);
			$temp['IDNewsletter']=1;
			$temp['index']="3";
			$temp['title']="Tạo mới thư gửi";
			$temp['template']='member/newsletter_create_step3_view';			
			$this->load->view("member/member_template",$temp);
		}
		
		public function createstep3()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["txtNameNewsletter"]) && isset($_POST["txtSubjectNewsletter"]))
				{
					$namenewsletter = $_POST["txtNameNewsletter"];
					$subjectnewsletter = $_POST["txtSubjectNewsletter"];
					$greetnewsletter="";
					if(isset($_POST["txtGreetNewsletter"]))
					{
						$greetnewsletter = $_POST["txtGreetNewsletter"];
					}
					
					$notenewsletter="";
					if(isset($_POST["txtNoteNewsletter"]))
					{
						$notenewsletter = $_POST["txtNoteNewsletter"];
					}
					$contentnewsletter="";
					if(isset($_POST["txtContentNewsletter"]))
					{
						$contentnewsletter = $_POST["txtContentNewsletter"];
					}
					
					$ID = $this->Newsletter_Model->add($user,$namenewsletter, $subjectnewsletter, $greetnewsletter, $contentnewsletter, $notenewsletter);
					
					header('Location: '. base_url('index.php/member/newsletter/resetupnewsletter/?ID='.$ID.''));
					exit();
					
				}else header('Location: '. base_url('index.php/member/newsletter/createstep3'));
			}else header('Location: '. base_url('index.php/member/index/login'));
		}
		
		public function setorderparameter()
		{
			if(isset($_POST['sort_by']))
			{
				$sort_by = $_POST['sort_by'];
				$list_sort_by = array("ID","Name","Subject","CreatedDate","CreatedDate","UpdatedDate","LastRun","NextRun","Note", "Status");
				if($sort_by<0 || $sort_by > count($list_sort_by) - 1) $sort_by=0;
				$this->session->set_userdata("sort_by_newsletters",$list_sort_by[$sort_by]);
				$sort_order=$this->session->userdata("sort_order_newsletters");
				if(isset($sort_order))
					if($sort_order=='desc')$this->session->set_userdata('sort_order_newsletters', 'asc');
					else $this->session->set_userdata('sort_order_newsletters', 'desc');
				else $this->session->set_userdata('sort_order_newsletters', 'desc');
			}
		}
		
		public function listnewsletter()
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
				
				$datafilter=$this->session->userdata("data-filter-contact");
				if(isset($datafilter)) $temp["data_filter"]=$datafilter;
				else $datafilter=null;
				// cấu hình phân trang
				$config['base_url'] = base_url('index.php/member/newsletter/listnewsletter'); // xác định trang phân trang
				$config['total_rows'] = $this->Newsletter_Model->countAll($user, $datafilter); // xác định tổng số record
				$config['per_page'] = $numperpage; // xác định số record ở mỗi trang
				$config['uri_segment'] = 4; // xác định segment chứa page number
				$this->pagination->initialize($config);

				// echo 'ssssssssssss';
				$sort_by=$this->session->userdata("sort_by_newsletters");
				$sort_order=$this->session->userdata("sort_order_newsletters");
				
				if(isset($sort_by) && isset($sort_order))
				{
					$temp['listnewsletters']=$this->Newsletter_Model->getAll($user,$this->uri->segment(4),$config['per_page'],$sort_by,$sort_order,$datafilter);
					$temp["sort_by"]=$sort_by;
					$temp["sort_order"]=$sort_order;
				}
				else
					$temp['listnewsletters']=$this->Newsletter_Model->getAll($user,$this->uri->segment(4),$config['per_page'],null,null,$datafilter);
				
				$temp['offset']= $this->uri->segment(4);
				$temp['numberperpage']= $numperpage;
				$temp['numbercontacts']=$config['total_rows'];
				
				$temp['index']="3";
				$temp['title']="Hiển thị danh sách thư gửi";
				$temp['template']='member/newsletter_list_view';			
				$this->load->view("member/member_template",$temp);
			}else header('Location: '. base_url('index.php/member/index/login'));
		}
		
	
		
		public function resetupnewsletter()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				$temp['statussetup'] = "";
				
				if(isset($_POST["ID"]) && isset($_POST["txtSentDate"]) && isset($_POST["slperiod"]))
				{
					$id=$_POST["ID"] ;
					$sentdate=$_POST["txtSentDate"] ;
					if($sentdate=="") $sentdate=null;
					$period=$_POST["slperiod"] ;
					$sentto=",";
					if(isset($_POST["slcatergories"]))
					{
						$catergories=$_POST["slcatergories"] ;
						foreach($catergories as $cat) $sentto = $sentto."".$cat.",";
					}
					$status=0;
					if(isset($_POST["cbActive"])) $status=1;
					$this->Newsletter_Model->setup($user, $id, $status, $sentdate, $sentto, $period);
					$temp['statussetup'] = "Lưu thành công";
					if($_POST["issendnow"]=="1")
					{
						//error_log(date('Y-m-d H:i:s').': '.'resetupnewsletter'.'\n', 3, 'log.log');
						//$this->load->helper("checkemail_helper");
						//$html = 
						//postPage(base_url('index.php/manager/sendemail/runnewsletter/'), array("ID"=>$id,"user"=>$user));
						$temp['sendemailnow']="1";
						$temp['idnewsletter']=$id;
						$temp['statussetup'] = "Đã lưu và gửi thư";
						//echo "html:".$html;
						//exec('nohup php '.base_url('index.php/manager/sendemail/runnewsletter/?ID=').$id.' >/dev/null 2>&1 &');
						// $ch = curl_init();
						
						// curl_setopt($ch, CURLOPT_URL, base_url('index.php/manager/sendemail/runnewsletter/?ID=').$id.'');
						// curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
						// curl_setopt($ch, CURLOPT_TIMEOUT, 60);

						// curl_exec($ch);
						// curl_close($ch);
					}
				}
				if(isset($_GET["ID"]))
				{
					$ID=$_GET["ID"];
					$temp['IDNewsletter']=$ID;
					$temp['listcategories'] = $this->Newsletter_Model->getCategoryOfUser($user);
					$temp['newsletter'] = $this->Newsletter_Model->getNewsletter($user, $ID);
					$temp['index']="3";
					$temp['title']="Cài đặt thư gửi";
					$temp['template']='member/newsletter_resetup_view';			
					$this->load->view("member/member_template",$temp);
				}
			}else header('Location: '. base_url('index.php/member/index/login'));
		}
		
		public function editnewsletter()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				$temp['statusedit'] = "";
				
				if(isset($_POST["txtIDNewsletter"]) && isset($_POST["txtNameNewsletter"]) && isset($_POST["txtSubjectNewsletter"]))
				{
					$ID=$_POST["txtIDNewsletter"];
					$namenewsletter = $_POST["txtNameNewsletter"];
					$subjectnewsletter = $_POST["txtSubjectNewsletter"];
					$greetnewsletter="";
					if(isset($_POST["txtGreetNewsletter"]))
					{
						$greetnewsletter = $_POST["txtGreetNewsletter"];
					}
					
					$notenewsletter="";
					if(isset($_POST["txtNoteNewsletter"]))
					{
						$notenewsletter = $_POST["txtNoteNewsletter"];
					}
					$contentnewsletter="";
					if(isset($_POST["txtContentNewsletter"]))
					{
						$contentnewsletter = $_POST["txtContentNewsletter"];
					}
					
					$this->Newsletter_Model->edit($user, $ID,$namenewsletter, $subjectnewsletter, $greetnewsletter, $contentnewsletter, $notenewsletter);
					
					$temp['statusedit'] = "Lưu thành công";
				}
				if(isset($_GET["ID"]))
				{
					$ID=$_GET["ID"];
					$temp['IDNewsletter']=$ID;
					$temp['newsletter'] = $this->Newsletter_Model->getNewsletter($user, $ID);
					$temp['index']="3";
					$temp['title']="Sửa đổi thư gửi";
					$temp['template']='member/newsletter_edit_view';			
					$this->load->view("member/member_template",$temp);
				}
			}else header('Location: '. base_url('index.php/member/index/login'));
		}
		
		public function deletemultinewsletter()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["ids"]))
				{
					$ids = $_POST["ids"];
					$this->Newsletter_Model->deleteMultiNewsletter($user, $ids);	
					echo "2";
				}
				else echo "1";
			}else echo "0";
		}
		
		public function deletenewsletter()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["id"]))
				{
					$id = $_POST["id"];
					$this->Newsletter_Model->deleteNewsletter($user, $id);	
					echo "2";
				}
				else echo "1";
			}else echo "0";
		}
	}
?>