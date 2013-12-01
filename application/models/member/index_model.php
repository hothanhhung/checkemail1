<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Index_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
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
			{
				$data = array(
				   'LastDateLogin' => date('Y-m-d H:i:s')
				  	);
				$this->db->where('EmailAddress', $Email);
				$this->db->update('member', $data); 
				return $ss[0]["Name"];
			}
			else {
				return "";
			}
		}
		
		public function checkPass($Email,$Pass)
		{
			$this->db->limit('1','0');
			$this->db->where('EmailAddress',$Email);
			$result=$this->db->get('member');
			$ss=$result->result_array();
			if(isset($ss[0]) && $ss[0]["Password"]==$Pass)
			{
				return true;
			}
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
		
		public function saveProfile($user, $name, $mobilephone, $newpass='')
		{
			if($newpass=='')
			{
				$data = array(
					'Name'=>$name,
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'MobilePhone' => $mobilephone,
				  	);
			}
			else
			{
				$data = array(
					'Name'=>$name,
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'MobilePhone' => $mobilephone,
				   'Password' => $newpass
				  	);
			}
			
			$this->db->where('EmailAddress', $user);
			$this->db->update('member', $data); 
			
		}
		
	}
?>