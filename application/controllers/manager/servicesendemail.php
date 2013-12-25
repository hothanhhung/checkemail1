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
			$this->load->model("manager/Emailconfig_Model");
			$this->load->model("member/Newsletter_Model");
			$this->load->model("member/Contact_Model");
			
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1")
			{
				$ID = ''.date('YmdHis').rand(1000 , 9999 );
				$lastRun = ServiceConfigClass::getLastUpdateConfig();
				ServiceConfigClass::wantToRun();
				$oldUpdate = ServiceConfigClass::getLastUpdateConfig();
				
				if($lastRun == $oldUpdate) return; // double click
				
				$sleeptime = ServiceConfigClass::getTimeSleep();
				
				ServiceListClass::add($ID, $oldUpdate, $sleeptime, "Starting");
				ServiceConfigClass::writeLogRun('service starts ['.$ID.']['.$oldUpdate.']['.$sleeptime."]", 1);
				$n=0;
				while(true)
				{
					if($oldUpdate != ServiceConfigClass::getLastUpdateConfig()) break;
					
					// waiting for another service finish the action
					ServiceListClass::wait($ID);
					while(ServiceConfigClass::isTakingAction())
					{
						sleep(round($sleeptime / 2));
						if($oldUpdate != ServiceConfigClass::getLastUpdateConfig()) break;
					}
					if($oldUpdate != ServiceConfigClass::getLastUpdateConfig()) break;
					
					ServiceConfigClass::takeAction();// get action
					ServiceListClass::run($ID);
					$timeStart = date('YmdHis');
					/* ---------------Action service--------------------------------*/
					
					//get emails which is available to send newsletter
					$this->Emailconfig_Model->resetToday();
					$listEmails = $this->Emailconfig_Model->getAvailable();
					if(isset($listEmails) && count($listEmails) > 0)
					{
						// check newsletters which need to be sent
						$listNewsletters = $this->Newsletter_Model->getNewsletterNeedSent();
						if(isset($listNewsletters) && count($listNewsletters) > 0)
						{
							for($i=0; $i<count($listNewsletters); $i++)
							{
								// get information of each Newsletter to send
								$data = $listNewsletters[$i];
								$listEmailForNewsletter = $this->Contact_Model->getAllEmailsWithOutUser($data["SendTo"]);
								$user=$data["EmailUser"];
								$username=$data["UserFullName"];
								
								if(isset($listEmailForNewsletter))
								{	
									// run each email in inbox of the Newsletter
									foreach($listEmailForNewsletter as $email)
									{
										// select email to handle send email
										$j=0;
										for($j=0; $j<count($listEmails); $j++)
											if($listEmails[$j]['NumberSentEmailToday']<$listEmails[$j]['NumberSendPerDate']) break;
										// send email
										if($j<count($listEmails))
										{
											error_log(date('Y-m-d H:i:s').': '.$user.' sent to '.$email["StoredEmail"].' via '.$listEmails[$j]['Email']."\n", 3, 'log.log');
											$this->sendEmailToContact($listEmails[$j], $user, $username, $email["StoredEmail"], $data["Subject"], str_replace('[[Name]]',' '.$email["FullName"],$data["Greet"])."<br/>".$data["Content"]);
											// increase listEmails[$i]['NumberSentEmailToday']
											$listEmails[$j]['NumberSentEmailToday']=$listEmails[$j]['NumberSentEmailToday']+1;
											$listEmails[$j]['NumberSentEmail']=$listEmails[$j]['NumberSentEmail']+1;
										}else 
										{
											error_log(date('Y-m-d H:i:s').": No email handle for sending email\n", 3, 'log.log');
										}
									}
									 error_log(date('Y-m-d H:i:s').':'.$data["ID"]." sent to \n", 3, 'log.log');
								}
								$this->Newsletter_Model->updateSendDataWithOutUser($data["ID"],$data["Period"]);
								
							}
							// update email handle
							foreach($listEmails as $emailHandle)
								$this->Emailconfig_Model->updateNumberOfSentEmail($emailHandle['Email'],$emailHandle['NumberSentEmailToday'],$emailHandle['NumberSentEmail']);
						}
					}
					
					/*--------------------------------End Action service---------------------------*/
					
					$n++;
					ServiceConfigClass::writeLogRun('service is sleeping ['.$ID.']['.$oldUpdate.']['.$sleeptime.']['.$n."]", 2);
					
					$timeEnd = date('YmdHis');
					$timeForAction = $timeEnd - $timeStart;
					
					// go to sleep
					if($timeForAction < $sleeptime)
					{
						ServiceConfigClass::goToSleep();
						ServiceListClass::sleep($ID);
						sleep($sleeptime - $timeForAction);
						
					}
					//if($oldUpdate != $serviceConfig->getLastUpdateConfig()) break;
				}
				ServiceConfigClass::writeLogRun('service stopped ['.$ID.']['.$oldUpdate.']['.$sleeptime."]", 3);
				ServiceListClass::stop($ID);
			}
		}
		
		function sendEmailToContact($emailHandle, $from, $namefrom, $to, $sub, $cont)
		{ 
		
			$config = array(
					'protocol' => $emailHandle['Protocol'],
					'smtp_host' => $emailHandle['smtp_host'],
					'smtp_port' =>  $emailHandle['smtp_port'],
					'smtp_user' =>  $emailHandle['Email'],
					'smtp_pass' =>  $emailHandle['Password'],//Nhớ đánh đúng user và pass nhé
					'charset' => 'utf-8',
					'mailtype'  => 'html',
					'starttls'  => true,
					'newline'   => "\r\n"
			);
			$this->load->library('email',$config);
			

			$this->email->from($from, $namefrom);
			$this->email->to($to);

			$this->email->subject($sub);
			$this->email->message($cont);

			$this->email->send();

			//echo $this->email->print_debugger();
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
						$result["Infor"]="Đã cập nhật chu kỳ mới:".$secondstr;
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
		
		public function reset()
		{
			$manager = $this->session->userdata('managerlogin');
			$managerlevel = $this->session->userdata('managerloginlevel');
			$result = array();
			
			$result["ErrorCode"]="1";
			$result["Infor"]="Lỗi không xác định";
			
			if(isset($manager) && $manager != "" && isset($managerlevel) && $managerlevel=="1")
			{
				ServiceConfigClass::reset();
						
				$result["ErrorCode"]="0";
				$result["Infor"]="Đã reset service";
		
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