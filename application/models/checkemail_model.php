<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Checkemail_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function saveCheckedEmailToData($FromIP,$UserName,$Email,$Domain,$Status,$ss)
		{
			$this->db->query('insert into checkemailsrecord(FromIP,UserName,CheckedEmail,CheckDate,Status,Session,DomainOfEmail) values("'.$FromIP.'","'.$UserName.'","'.$Email.'","'.date('Y-m-d H:i:s').'","'.$Status.'","'.$ss.'","'.$Domain.'")');
			if(trim($UserName)!="")
			{
				$this->db->select('ID');
				$this->db->limit(1,0);
				$this->db->where('EmailUser',$UserName);
				$this->db->where('StoredEmail',$Email);
				$this->db->where('(Deleted is null or Deleted = 0)', null, false);
				$result=$this->db->get('storedemail');
				$ss=$result->result_array();
				if(isset($ss[0]) && $ss[0]["ID"]!='') 
				{
					$id = $ss[0]["ID"];
					$data = array(
						   'UpdatedDate' => date('Y-m-d H:i:s'),
						   'Status' => $Status
								);

					$this->db->where('ID', $id);
					$this->db->update('storedemail', $data); 
				}
				else {
					$array = array('EmailUser' => $UserName, 
									'StoredEmail' => $Email, 
									'CreatedDate' => date('Y-m-d H:i:s'), 
									'UpdatedDate' => date('Y-m-d H:i:s'), 
									'Note' => '', 
									'Domain' => $Domain,
									'status' => $Status);

					$this->db->set($array);
					$this->db->insert('storedemail'); 
					
				}
			}
		}
		

		public function getSessionCheckEmail()
		{
			$this->db->select('Session');
			$this->db->order_by('Session desc');
			$this->db->limit('1','0');
			$result=$this->db->get('checkemailsrecord');
			$ss=$result->result_array();
			if(isset($ss[0]) && $ss[0]["Session"]!='') return $ss[0]["Session"]+1;
			else return 1;
		}

		public function getCheckEmails($ss)
		{
			$this->db->select('CheckedEmail, Status');
			$this->db->where('Session',$ss);
			$result=$this->db->get('checkemailsrecord');
			return $result->result_array();
		}

	}
?>