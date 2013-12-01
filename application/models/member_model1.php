<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Member_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		  // đếm tổng số record trong table book
        function count_all($user)
		{
			$this->db->where('EmailUser',$user);
			$this->db->where('(Deleted is null or Deleted = 0)', null, false);
            return $this->db->count_all_results('storedemail');
        } 
		
		public function addEmail($user, $email, $note, $domain)
		{
			$this->db->select('ID');
			$this->db->limit(1,0);
			$this->db->where('EmailUser',$user);
			$this->db->where('StoredEmail',$email);
			$this->db->where('(Deleted is null or Deleted = 0)', null, false);
			$result=$this->db->get('storedemail');
			$ss=$result->result_array();
			if(isset($ss[0]) && $ss[0]["ID"]!='') 
			{
				$id = $ss[0]["ID"];
				$data = array(
					   'UpdatedDate' => date('Y-m-d H:i:s'),
							);

				$this->db->where('ID', $id);
				$this->db->update('storedemail', $data); 
			}
			else {
				$array = array('EmailUser' => $user, 
								'StoredEmail' => $email, 
								'CreatedDate' => date('Y-m-d H:i:s'), 
								'UpdatedDate' => date('Y-m-d H:i:s'), 
								'Note' => $note, 
								'Domain' => $domain,
								'status' => '-1');

				$this->db->set($array);
				$this->db->insert('storedemail'); 
				
			}
		}
		
		public function editnote($user, $id, $note)
		{
			
			$data = array(
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'Note'=>$note
						);

			$this->db->where('EmailUser', $user);
			$this->db->where('ID', $id);
			$this->db->update('storedemail', $data); 
			
		}
		
		public function deletemultistoredemail($user, $ids)
		{
			
			$data = array(
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'Deleted'=>'1'
						);

			$this->db->where('EmailUser', $user);
			$this->db->where($ids,null,false);
			$this->db->update('storedemail', $data); 
			
		}
		
		public function deletestoredemail($user, $id)
		{
			
			$data = array(
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'Deleted'=>'1'
						);

			$this->db->where('EmailUser', $user);
			$this->db->where('ID', $id);
			$this->db->update('storedemail', $data); 
			
		}
		
		public function getEmailOfUser($user, $begin, $number, $sort_by=null, $sort_order=null)
		{
			$this->db->limit($number,$begin);
			$this->db->where('EmailUser',$user);
			$this->db->where('(Deleted is null or Deleted = 0)', null, false);
			if($sort_by != null && $sort_order != null)
				$this->db->order_by($sort_by, $sort_order);
			$result=$this->db->get('storedemail');
			return $result->result_array();
		}
		
		public function signUp($FullName, $Email, $Pass, $MobilePhone)
		{
			$this->db->select('Name');
			$this->db->limit('1','0');
			$this->db->where('EmailAddress',$Email);
			$result=$this->db->get('member');
			$ss=$result->result_array();
			if(isset($ss[0]) && $ss[0]["Name"]!='') return false;
			else {
			$this->db->query('insert into member(Name,EmailAddress,Password,DateRegistry, MobilePhone) values("'.$FullName.'","'.$Email.'","'.$Pass.'","'.date('Y-m-d H:i:s').'","'.$MobilePhone.'")');
			return true;
			}
		}

		public function signIn($Email,$Pass)
		{
			$this->db->limit('1','0');
			$this->db->where('EmailAddress',$Email);
			$result=$this->db->get('member');
			$ss=$result->result_array();
			if(isset($ss[0]) && $ss[0]["Password"]==$Pass)
				return true;
			else {
				return false;
			}
		}
		
		public function getProfile($Email)
		{
			$this->db->limit('1','0');
			$this->db->where('EmailAddress',$Email);
			$result=$this->db->get('member');
			$ss=$result->result_array();
			if(isset($ss[0]))
				return $ss[0];
			else {
				return null;
			}
		}
	}
?>