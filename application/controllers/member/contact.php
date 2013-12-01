<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Contact extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper("url");
			$this->load->model("member/Contact_Model");
			$this->load->library('session');
		}

		public function toindex()
		{
			$this->session->set_userdata('isindex1', '');
			header('Location: '. base_url('index.php/member/contact/'));
		}
		
		public function toindex1()
		{
			$this->session->set_userdata('isindex1', '1');
			header('Location: '. base_url('index.php/member/contact/index1'));
		}
		
		public function index()
		{
			$isindex1 = $this->session->userdata('isindex1');
			if(isset($isindex1) && $isindex1 == 1)
			{
				header('Location: '. base_url('index.php/member/contact/index1'));
				exit();
			}
			
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
				$config['base_url'] = base_url('index.php/member/contact'); // xác định trang phân trang
				$config['total_rows'] = $this->Contact_Model->count_all($user); // xác định tổng số record
				$config['per_page'] = $numperpage; // xác định số record ở mỗi trang
				$config['uri_segment'] = 3; // xác định segment chứa page number
				$this->pagination->initialize($config);

				// echo 'ssssssssssss';
				$sort_by=$this->session->userdata("sort_by_member_storedemail");
				$sort_order=$this->session->userdata("sort_order_member_storedemail");
				if(isset($sort_by) && isset($sort_order))
				{
					$temp['listemails']=$this->Contact_Model->getEmailOfUser($user,$this->uri->segment(3),$config['per_page'],$sort_by,$sort_order);
					$temp["sort_by"]=$sort_by;
					$temp["sort_order"]=$sort_order;
				}
				else
					$temp['listemails']=$this->Contact_Model->getEmailOfUser($user,$this->uri->segment(3),$config['per_page']);
				
				$temp['listcategories']=$this->Contact_Model->getCategoryOfUser($user);
				$temp['offset']= $this->uri->segment(3);
				$temp['numberperpage']= $numperpage;
				$temp['numbercontacts']=$config['total_rows'];
				
				$result_addcontact = $this->session->userdata('result_addcontact');
				if(isset($result_addcontact)) $temp['result_addcontact']= $result_addcontact;
				$this->session->set_userdata('result_addcontact', '');
				
				$result_addcontacts = $this->session->userdata('result_addcontacts');
				if(isset($result_addcontacts))$temp['result_addcontacts']= $result_addcontacts;
				$this->session->set_userdata('result_addcontacts', '');
				
				$temp['index']="2";
				$temp['title']="Quản lý danh sách liên lạc";
				$temp['template']='member/contact_view';
			
				$this->load->view("member/member_template",$temp); 
			}else
			{
				header('Location: '. base_url('index.php/member/index/login'));
			}
		}
		
		public function filtercontact()
		{
			$fullname="";
			$email="";
			$sbCateID=null;
			$sbDomain=null;
			$sbDisconnected=null;
			$sbStatus=null;
			
			if(isset($_POST["fullname-filter"])) $fullname=$_POST["fullname-filter"];
			if(isset($_POST["email-filter"])) $email=$_POST["email-filter"];
			if(isset($_POST["sbCateID-filter"])) $sbCateID=$_POST["sbCateID-filter"];
			if(isset($_POST["sbDomain-filter"])) $sbDomain=$_POST["sbDomain-filter"];
			if(isset($_POST["sbDisconnected-filter"])) $sbDisconnected=$_POST["sbDisconnected-filter"];
			if(isset($_POST["sbStatus-filter"])) $sbStatus=$_POST["sbStatus-filter"];
			
			$data=array("fullname"=>trim($fullname),
						"email"=>trim($email),
						"sbCateID"=>$sbCateID,
						"sbDomain"=>$sbDomain,
						"sbDisconnected"=>$sbDisconnected==-1? null: $sbDisconnected,
						"sbStatus"=>$sbStatus);
						
			$this->session->set_userdata('data-filter-contact', $data);
			header('Location: '. base_url('index.php/member/contact/index1'));
		}
		
		public function deletecontactinfilter()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				$datafilter=$this->session->userdata("data-filter-contact");
				if(isset($datafilter))
				{
					$this->Contact_Model->deleteContactInFilter($user, $datafilter);
					echo "2";
				}
				else echo "1";
			}else echo "0";
		}
		
		public function getcontactinfilter()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				$datafilter=$this->session->userdata("data-filter-contact");
				if(isset($datafilter))
				{
					$emails = $this->Contact_Model->getEmailOfUserInFilter($user, $datafilter);
					if(isset($emails) && $emails!=null)
					{
						$arr = array();
						foreach($emails as $email)
							$arr[] = $email["StoredEmail"];
						 echo json_encode($arr);
					}
					else echo "1";
				}
				else echo "1";
			}else echo "0";
		}
		
		public function index1()
		{
			// $isindex1 = $this->session->userdata('isindex1');
			// if(isset($isindex1) && $isindex1 == 1)
			// {
				// header('Location: '. base_url('index.php/member/contact/index1'));
				// exit();
			// }
			
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
				$config['base_url'] = base_url('index.php/member/contact/index1'); // xác định trang phân trang
				$config['total_rows'] = $this->Contact_Model->count_all($user, $datafilter); // xác định tổng số record
				$config['per_page'] = $numperpage; // xác định số record ở mỗi trang
				$config['uri_segment'] = 4; // xác định segment chứa page number
				$this->pagination->initialize($config);

				// echo 'ssssssssssss';
				$sort_by=$this->session->userdata("sort_by_member_storedemail");
				$sort_order=$this->session->userdata("sort_order_member_storedemail");
				
				if(isset($sort_by) && isset($sort_order))
				{
					$temp['listemails']=$this->Contact_Model->getEmailOfUser($user,$this->uri->segment(4),$config['per_page'],$sort_by,$sort_order,$datafilter);
					$temp["sort_by"]=$sort_by;
					$temp["sort_order"]=$sort_order;
				}
				else
					$temp['listemails']=$this->Contact_Model->getEmailOfUser($user,$this->uri->segment(4),$config['per_page'],null,null,$datafilter);
				
				$temp['listcategories']=$this->Contact_Model->getCategoryOfUser($user);
				$temp['listdomain']=$this->Contact_Model->getDomainOfUser($user);
				$temp['offset']= $this->uri->segment(4);
				$temp['numberperpage']= $numperpage;
				$temp['numbercontacts']=$config['total_rows'];
				
				$result_addcontact = $this->session->userdata('result_addcontact');
				if(isset($result_addcontact)) $temp['result_addcontact']= $result_addcontact;
				$this->session->set_userdata('result_addcontact', '');
				
				$result_addcontacts = $this->session->userdata('result_addcontacts');
				if(isset($result_addcontacts))$temp['result_addcontacts']= $result_addcontacts;
				$this->session->set_userdata('result_addcontacts', '');
				
				$temp['index']="2";
				$temp['title']="Quản lý danh sách liên lạc";
				$temp['template']='member/contact_view1';
			
				$this->load->view("member/member_template",$temp); 
			}else
			{
				header('Location: '. base_url('index.php/member/index/login'));
			}
		}
		
		public function listincat()
		{
			if(isset($_GET['catid']))
			{
				$data=array("fullname"=>'',
						"email"=>'',
						"sbCateID"=>array($_GET['catid']),
						"sbDomain"=>null,
						"sbDisconnected"=>null,
						"sbStatus"=>null);
						
				$this->session->set_userdata('data-filter-contact', $data);
				header('Location: '. base_url('index.php/member/contact/index1'));
			}else echo "Lỗi";
		}
		
		
		public function setorderparameter()
		{
			if(isset($_POST['sort_by']))
			{
				$sort_by = $_POST['sort_by'];
				$list_sort_by = array("ID","FullName","StoredEmail","NameCategory", "Domain","CreatedDate","UpdatedDate","Note","Disconected", "Status");
				if($sort_by<0 || $sort_by > count($list_sort_by) - 1) $sort_by=0;
				$this->session->set_userdata("sort_by_member_storedemail",$list_sort_by[$sort_by]);
				$sort_order=$this->session->userdata("sort_order_member_storedemail");
				if(isset($sort_order))
					if($sort_order=='desc')$this->session->set_userdata('sort_order_member_storedemail', 'asc');
					else $this->session->set_userdata('sort_order_member_storedemail', 'desc');
				else $this->session->set_userdata('sort_order_member_storedemail', 'desc');
			}
		}
		
		public function addcontacts()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				$data;
				if(isset($_FILES["flEmail"])) 
				{
					
					$this->load->helper('checkemail_helper');
					$data = getListEmails($_FILES["flEmail"]);
				} else $this->session->set_userdata('result_addcontacts', '1');
				
				if(isset($data))
				{
					$catID = -1;
					if(isset($_POST["sbCateID"])) $catID = $_POST["sbCateID"];
					
					foreach($data as $row)
					{ 
						$emailParts = explode("@", trim($row));
						if(isset($emailParts[1])&& $emailParts[1]!="")
						{
							$domain = $emailParts[1];
							if($catID == -1)
								$this->Contact_Model->addContact($user,'',$row,'',$domain);	
							else 
								$this->Contact_Model->addContact($user,'',$row,'',$domain,$catID);								
						}
					}
					$this->session->set_userdata('result_addcontacts', '2');
				}
			}
			header('Location: '. base_url('index.php/member/contact'));
		}
		
		
		public function addcontact()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["txtEmailAdd"]) && isset($_POST["txtEmailNote"]) && isset($_POST["sbCateID"]))
				{
					$email = $_POST["txtEmailAdd"];
					$note = $_POST["txtEmailNote"];
					$catID = $_POST["sbCateID"];
					$fullName = $_POST["txtFullName"];
					
					$emailParts = explode("@", trim($email));
					if(isset($emailParts[1])&& $emailParts[1]!="")
					{
						$domain = $emailParts[1];
						if($catID == -1) 
							$this->Contact_Model->addContact($user,$fullName,$email,$note,$domain);
						else
							$this->Contact_Model->addContact($user,$fullName,$email,$note,$domain, $catID);		
						$this->session->set_userdata('result_addcontact', '2');				
					}
					else $this->session->set_userdata('result_addcontact', '1');	
				}
			}
			header('Location: '. base_url('index.php/member/contact'));
		}
		
		public function deletemultistoredemail()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["ids"]))
				{
					$ids = $_POST["ids"];
					$this->Contact_Model->deletemultistoredemail($user, $ids);	
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
					$this->Contact_Model->deletestoredemail($user, $id, $note);	
					echo "2";
				}
				else echo "1";
			}else echo "0";
		}
		
		public function test()
		{
			$user = $this->session->userdata('userlogin');
			$data = $this->Contact_Model->getContact($user, 4);
			print_r($data);
		}
		
		public function getcontact()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["id"]))
				{
					$id = $_POST["id"];
					$data = $this->Contact_Model->getContact($user, $id);
					if(isset($data) && $data!=null)
					{
						 echo json_encode( array("IDContact"=>$data["ID"],"FullName"=>$data["FullName"],"StoredEmail"=>$data["StoredEmail"],
												 "CategoryID"=>$data["CategoryID"],"Note"=>$data["Note"],
												 "Disconnected"=>$data["Disconnected"],"Status"=>$data["Status"] ) );
					}
					else echo "1";
					
				}else echo "1";
			}else echo "0";
		}
		
		public function editcontact()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				if(isset($_POST["catID"]) && isset($_POST["note"]) && isset($_POST["id"]) && isset($_POST["fullname"]))
				{
					$note = $_POST["note"];
					$id = $_POST["id"];
					$catID = $_POST["catID"];
					$name = $_POST["fullname"];
					if($catID==-1) $catID=null;
					$this->Contact_Model->editcontact($user, $name, $id, $note, $catID);	
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
					$this->Contact_Model->editnote($user, $id, $note);	
					echo "2";
				}
				else echo "1";
			}else echo "0";
		}
		
		public function excelfile()
		{
			$user = $this->session->userdata('userlogin');
			if(isset($user)&&$user!="")
			{
				$datafilter=$this->session->userdata("data-filter-contact");
				if(isset($datafilter)) $temp["data_filter"]=$datafilter;
				else $datafilter=null;
					
				$sort_by=$this->session->userdata("sort_by_member_storedemail");
				$sort_order=$this->session->userdata("sort_order_member_storedemail");
				
				if(!isset($sort_by)) $sort_by=null;
				if(!isset($sort_order)) $sort_order=null;
				
				$listemails = $this->Contact_Model->getEmailOfUser($user,0,-1,$sort_by,$sort_order,$datafilter);
					
					
				$this->load->library('phpexcel');
			//	$this->load->library('PHPExcel/iofactory');

				$excel = new PHPExcel();
				$excel->getProperties()->setTitle("Emails")
										->setDescription("Result for checking emails");

				$excel->setActiveSheetIndex(0);
				$worksheet = $excel->getActiveSheet();

				$worksheet->setCellValueByColumnAndRow(0,1,"STT");
				$worksheet->setCellValueByColumnAndRow(1,1,'Họ Và Tên');
				$worksheet->setCellValueByColumnAndRow(2,1,'Địa Chỉ Email');
				$worksheet->setCellValueByColumnAndRow(3,1,'Danh Muc');
				$worksheet->setCellValueByColumnAndRow(4,1,'Tên Miền');
				$worksheet->setCellValueByColumnAndRow(5,1,'Ngày Tạo');
				$worksheet->setCellValueByColumnAndRow(6,1,'Ngày Cập Nhật');
				$worksheet->setCellValueByColumnAndRow(7,1,'Ghi Chú');
				$worksheet->setCellValueByColumnAndRow(8,1,'Kết nối từ địa chỉ email');
				$worksheet->setCellValueByColumnAndRow(9,1,'Trạng thái');
			
				if(isset($listemails))
				{
					$n=0;
					foreach($listemails as $row)
					{
						$n++;
						$worksheet->setCellValueByColumnAndRow(0,$n+1,$n);
						$worksheet->setCellValueByColumnAndRow(1,$n+1,$row['FullName']);
						$worksheet->setCellValueByColumnAndRow(2,$n+1,$row['StoredEmail']);
						$worksheet->setCellValueByColumnAndRow(3,$n+1,$row['NameCategory']==null?"#":$row['NameCategory']);
						$worksheet->setCellValueByColumnAndRow(4,$n+1,$row['Domain']);
						$worksheet->setCellValueByColumnAndRow(5,$n+1,$row['CreatedDate']);
						$worksheet->setCellValueByColumnAndRow(6,$n+1,$row['UpdatedDate']);
						$worksheet->setCellValueByColumnAndRow(7,$n+1,$row['Note']);
						$worksheet->setCellValueByColumnAndRow(8,$n+1,$row['Disconnected'] == null?"Có":"Không");
						$worksheet->setCellValueByColumnAndRow(9,$n+1,$row['Status']==0?"Không tồn tại":$row['Status']==1?"Tồn tại":"Chưa kiểm tra");
					}
				}

				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="danhsach.xls"');
				header('Cache-Control: max-age=0');

				// Do your stuff here

				$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

				// This line will force the file to download

				$writer->save('php://output');
				$excel->disconnectWorksheets();
				unset($excel);
			}
		}
	}
	?>