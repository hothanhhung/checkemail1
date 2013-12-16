<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class ServiceSendEmail extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper("url");
			$this->load->helper("serviceconfig");
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
				
				$temp['IsRunning']=ServiceConfigClass::IsRunning();
				$temp['TimeSleep']=ServiceConfigClass::getTimeSleep();
				$temp['LastConfig']=ServiceConfigClass::getLastUpdateConfig();
				
				$temp['listServices'] = ServiceListClass::getList();
				$temp['index']="2";
				$temp['title']="Cấu hình gửi thư";
				$temp['template']='manager/servicesendemail_view';
			
				$this->load->view("manager/manager_template",$temp); 
			}else
			{
				header('Location: '. base_url('index.php/manager/index/login'));
			}
		}
								   
		public function runservice()
		{
			$result["ErrorCode"]="0";
			$result["Infor"]="Service đã đc gọi";
			
			 // create curl resource
			$ch = curl_init();

			// set url
			curl_setopt($ch, CURLOPT_URL, base_url('index.php/manager/servicesendemail/run'));

			//return the transfer as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);

			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	
			// $output contains the output string
			curl_exec($ch);

			// close curl resource to free up system resources
			curl_close($ch);      	
			
			echo json_encode($result);
		}
		
		public function run()
		{			
			$this->load->model("Manager/EmailConfig_Model");
			$this->load->model("member/Newsletter_Model");
			$this->load->model("member/Contact_Model");
			
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1")
			{
				$ID = ''.date('YmdHis').rand(1000 , 9999 );
				ServiceConfigClass::wantToRun();
				$oldUpdate = ServiceConfigClass::getLastUpdateConfig();
				$sleeptime = ServiceConfigClass::getTimeSleep();
				
				ServiceListClass::add($ID, $oldUpdate, $sleeptime, "Started");
				ServiceConfigClass::writeLogRun('service starts ['.$ID.']['.$oldUpdate.']['.$sleeptime."]", 1);
				$n=0;
				while(true)
				{
					if($oldUpdate != ServiceConfigClass::getLastUpdateConfig()) break;
					/* ---------------Action service--------------------------------*/
					//get emails which is available to send newsletter
					$this->EmailConfig_Model->resetToday();
					$listEmails = $this->EmailConfig_Model->getAvailable();
					if(isset($listEmails))
					{
						// check newsletters which need to be sent
						$listNewsletters = $this->Newsletter_Model->getNewsletterNeedSent();
						if(isset($listNewsletters))
						{
							for($i=0; $i<count($listNewsletters); $i++)
							{
								$listEmailForNewsletter = $this->Contact_Model->getAllEmailsWithOutUser($listNewsletters[$i]["SendTo"]);
								if(isset($listEmailForNewsletter))
								{
									//sendNewsletter($listNewsletters[$i],$listEmailForNewsletter, $listEmails );
									 error_log(date('Y-m-d H:i:s').':'.$listNewsletters[$i]["ID"]." sent to \n", 3, 'log.log');
								}
								$this->Newsletter_Model->updateSendDataWithOutUser($listNewsletters[$i]["ID"],$listNewsletters[$i]["Period"]);
							}
						}
					}
					// error_log(date('Y-m-d H:i:s').'listEmails:  '.var_export($listEmails, true)."\n", 3, 'log.log');
					// error_log(date('Y-m-d H:i:s').'listNewsletters:  '.var_export($listNewsletters, true)."\n", 3, 'log.log');
				// do something
					/* ----------------End Action service---------------------------*/
					$n++;
					ServiceConfigClass::writeLogRun('service is sleeping ['.$ID.']['.$oldUpdate.']['.$sleeptime.']['.$n."]", 2);
					sleep($sleeptime);
					//if($oldUpdate != $serviceConfig->getLastUpdateConfig()) break;
				}
				ServiceConfigClass::writeLogRun('service stopped ['.$ID.']['.$oldUpdate.']['.$sleeptime."]", 3);
				ServiceListClass::stop($ID);
			}
		}
		
		public function stop()
		{			
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1")
			{
				ServiceConfigClass::wantToStop();				
			}
		}
		
		public function ServiceIsRunning()
		{
			$result["ErrorCode"]="0";
			$result["Infor"]=ServiceConfigClass::IsRunning();
			echo json_encode($result);
		}
		
		public function settimesleep()
		{
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			$result = array();
			
			$result["ErrorCode"]="1";
			$result["Infor"]="Lỗi không xác định";
			
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1")
			{
				if(isset($_POST["second"]))
				{
					$secondstr = $_POST["second"];
					$second = (int)$secondstr;
					if("".$second  == $secondstr)
					{
						ServiceConfigClass::setTimeSleep($second);
						
						$result["ErrorCode"]="0";
						$result["Infor"]="Đã cập nhật chu ky mới:".$secondstr;
					}else 
					{
						$result["ErrorCode"]="1";
						$result["Infor"]=$secondstr." không phải là số";
					}	
				}else 
				{
					$result["ErrorCode"]="1";
					$result["Infor"]="Không đủ quyền để thực hiện";
				}
			}
			else 
			{
				$result["ErrorCode"]="1";
				$result["Infor"]="Không đủ quyền để thực hiện";
			}
			echo json_encode($result);
		}
		
	}
	?>