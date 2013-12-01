<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Manager_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		
		public function signIn($user,$pass)
		{
			$this->db->limit('1','0');
			$this->db->where('UserName',$user);
			$result=$this->db->get('manager');
			$ss=$result->result_array();
			if(isset($ss[0]) && $ss[0]["Password"]==$pass)
			{
				$data = array(
				   'LastLogin' => date('Y-m-d H:i:s')
				  	);
				$this->db->where('UserName', $user);
				$this->db->update('manager', $data); 
				return $ss[0];
			}
			
		}
		
		public function getAll()
		{
			$this->db->select("UserName");
			$this->db->select("FullName");
			$result=$this->db->get('manager');
			return $result->result_array();
			
		}
	}
?>