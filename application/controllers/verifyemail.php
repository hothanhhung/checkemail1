<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Verifyemail extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper("url");
			$this->load->model("Checkemail_Model");
			$this->load->library('session');
		}

		public function index()
		{
			$temp['index']="2";
			$temp['title']="Kiểm tra địa chỉ Email";
			$temp['template']='verifyemail_view';
			$temp['userlogin']=$this->session->userdata('userlogin');
			$this->load->view("mylayout",$temp); 
		}

				
		public function ajaxcheckemail()
		{
			$email = $_POST["txtEmail"];
			$ss = $_POST["ss"];
			if(isset($ss) && isset($email))
			{
				$emailParts = explode("@", trim($email));
				if(isset($emailParts[1])&& $emailParts[1]!="")
				{
					$this->load->helper('checkemail_helper');
					$result = jValidateEmailUsingSMTP($email);
					$fromip = getRemoteIPAddress();
					$username=$this->session->userdata('userlogin');
					if(!isset($username)) $username = "";
					$this->Checkemail_Model->saveCheckedEmailToData($fromip,$username,$email,$emailParts[1],$result,$ss);
					if ($result) echo "is exist";
					else echo "is not exist";
				}else echo 'error';
			}
			else echo 'error';
		}

		public function checkemail()
		{
			if(isset($_POST["txtEmail"]))
			{
				$email = $_POST["txtEmail"];
				$data = array("email"=>$email,"ss"=>$this->Checkemail_Model->getSessionCheckEmail());
				$temp['data']=$data;				
			}
			$temp['index']="2";
			$temp['title']="Kiểm tra địa chỉ Email";
			$temp['template']='verifyemail_view';
			$temp['userlogin']=$this->session->userdata('userlogin');
			$this->load->view("mylayout",$temp); 
			
		}

		public function checkmultiemail()
		{
			$us = $this->session->userdata('userlogin');
			if(isset($us) && $us != ""&&isset($_FILES["flEmail"]))
			{
				$data;
				$allowedExts = array("txt");
				$temp = explode(".", $_FILES["flEmail"]["name"]);
				$extension = end($temp);
				if (in_array($extension, $allowedExts))
				{
					if ($_FILES["flEmail"]["error"] > 0)
					{
					  //echo "Error: " . $_FILES["flEmail"]["error"] . "<br>";
					}
					else
					{
					  //echo "Upload: " . $_FILES["flEmail"]["name"] . "<br>";
					  //echo "Type: " . $_FILES["flEmail"]["type"] . "<br>";
					  //echo "Size: " . ($_FILES["flEmail"]["size"] / 1024) . " kB<br>";
					  //echo "Stored in: " . $_FILES["flEmail"]["tmp_name"];

					  $stringEmail='';
					  $f=fopen($_FILES["flEmail"]["tmp_name"],"r") or exit("Unable to open file!");
					  while (!feof($f))
					  {
						$x=fgets($f);
						// The line above stores a character in $x.
						$stringEmail=$stringEmail.";".$x;

					  }
					  fclose($f);
					}
					$stringEmail=str_replace(array(" ","\0","\t","\n","\x0B","\r" ),";", $stringEmail);

					$arrayEmail=explode(';', $stringEmail);
					$data["resultCheckEmails"]=$arrayEmail;
					$data["ss"]=$this->Checkemail_Model->getSessionCheckEmail();
					/*$resultCheckEmails;
					$this->load->model("Checkemail_Model");
					foreach ($arrayEmail as $email)
					{
						echo " ".$email;
						if(strpos($email, '@')!=false)
							$resultCheckEmails[$email]= false;//$this->Checkemail_Model->jValidateEmailUsingSMTP($email);
					}
					$data["resultCheckEmails"]=$resultCheckEmails;
					*/
					$temp['data']=$data;
				}
				else
				{
					echo "only allow extension:"; var_dump($allowedExts);
				}

			}
			$temp['index']="2";
			$temp['title']="Kiểm tra địa chỉ Email";
			$temp['template']='verifyemail_view';
			$temp['userlogin']=$this->session->userdata('userlogin');
			$this->load->view("mylayout",$temp);
		}

		public function textfile()
		{
			$filename="download.txt";
			if(isset($_GET["ss"]))
			{
				$ss=$_GET["ss"];
				$data = $this->Checkemail_Model->getCheckEmails($ss);
				foreach($data as $row)
					if($row['Status']=='1')
				{
						echo $row['CheckedEmail']."\n";
				}
			}
			header("Content-type: application/octet-stream");
			header("Content-disposition: attachment;filename=$filename");
		}

		public function excelfile()
		{
			$this->load->library('phpexcel');
		//	$this->load->library('PHPExcel/iofactory');

			$excel = new PHPExcel();
			$excel->getProperties()->setTitle("Emails")
									->setDescription("Result for checking emails");

			$excel->setActiveSheetIndex(0);
   			$worksheet = $excel->getActiveSheet();

   			$worksheet->setCellValueByColumnAndRow(0,1,"Number");
   			$worksheet->setCellValueByColumnAndRow(1,1,'Checked Email');
			if(isset($_GET["ss"]))
			{
				$ss=$_GET["ss"];
				$data = $this->Checkemail_Model->getCheckEmails($ss);
				$n=0;
				foreach($data as $row)
				{
					if($row['Status']=='1')
					{
						$n++;
						$worksheet->setCellValueByColumnAndRow(0,$n+1,$n);
						$worksheet->setCellValueByColumnAndRow(1,$n+1,$row['CheckedEmail']);
					}
				}
			}

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="checkemails.xls"');
			header('Cache-Control: max-age=0');

			// Do your stuff here

			$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

			// This line will force the file to download

			$writer->save('php://output');
			$excel->disconnectWorksheets();
			unset($excel);

		}
		
		public function allexcelfile()
		{
			$this->load->library('phpexcel');
		//	$this->load->library('PHPExcel/iofactory');

			$excel = new PHPExcel();
			$excel->getProperties()->setTitle("Emails")
									->setDescription("Result for checking emails");

			$excel->setActiveSheetIndex(0);
   			$worksheet = $excel->getActiveSheet();

   			$worksheet->setCellValueByColumnAndRow(0,1,"Number");
   			$worksheet->setCellValueByColumnAndRow(1,1,'Checked Email');
   			$worksheet->setCellValueByColumnAndRow(2,1,'Status');
			if(isset($_GET["ss"]))
			{
				$ss=$_GET["ss"];
				$data = $this->Checkemail_Model->getCheckEmails($ss);
				$n=0;
				foreach($data as $row)
				{
					$n++;
					$worksheet->setCellValueByColumnAndRow(0,$n+1,$n);
					$worksheet->setCellValueByColumnAndRow(1,$n+1,$row['CheckedEmail']);
					$worksheet->setCellValueByColumnAndRow(2,$n+1,$row['Status']);
				}
			}

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="checkemails.xls"');
			header('Cache-Control: max-age=0');

			// Do your stuff here

			$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');

			// This line will force the file to download

			$writer->save('php://output');
			$excel->disconnectWorksheets();
			unset($excel);

		}

		public function moredetail()
		{
			if(isset($_GET["email"]))
			{
				$this->load->library('simple_html_dom');
				$email=$_GET["email"];
				$emailParts = explode("@", trim($email));
				if(!isset($emailParts[0]) || !isset($emailParts[1])) return ;
				// Create DOM from URL or file
				$url  = 'http://www.google.com/search?hl=en&safe=active&tbo=d&site=&source=hp&q='.$email.'';
				//echo $url;
				$html1 = file_get_html($url);

				$n=0;
				$results='';
				foreach ($html1->find('li.g') as $html)
				{
					$title = "";
					$link  = "";
					$content = "";
					$linkObjs = $html->find('h3.r a');
					if(isset($linkObjs[0]))
					{
						$linkObj = $linkObjs[0];
						$title = trim($linkObj->plaintext);
						$link  = trim($linkObj->href);
						
						// if it is not a direct link but url reference found inside it, then extract
						if (!preg_match('/^https?/', $link) && preg_match('/q=(.+)&amp;sa=/U', $link, $matches) && preg_match('/^https?/', $matches[1])) {
							$link = $matches[1];
						} else if (!preg_match('/^https?/', $link)) { // skip if it is not a valid link
							$link="";    
						}  
					}
					$contents = $html->find('span.st');
					if(isset($contents[0]))
					{
						$temp=strtolower($contents[0]);
						if(strpos($temp, strtolower($emailParts[0]))==false || strpos($temp, strtolower($emailParts[1]))==false) $content = "";   
						else $content = $contents[0];   
					}
					
					if($title != "" && $link != "" && $content != "")
					{
						$n++;
						$results.='<div><a href="'.$link.'">'.$title.'</a><br/>'.$content.'</div><br/>';
					}
					if($n>2) break;
				}
				if($n==0) echo "No results found";
				else echo '<div style="border:1px solid;border-radius:10px;padding-left:5px;">'.$results.'</div>';
			}
			else echo "No results found";
		}
		
	}
	?>