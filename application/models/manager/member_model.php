<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Member_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		function countAll($manager, $level, $filter=null)
		{
			$this->db->select('ID');
			if($level!=1) $this->db->where('Manager',$manager);
			// if($filter!=null)
			// {
				// $this->db->where('('.$this->getStringFilter($filter).')', null, false);
			// }
            return $this->db->count_all_results('member');
        } 
		
		public function getAll($manager, $level, $begin, $number=10, $sort_by=null, $sort_order=null, $filter=null)
		{
			if(!isset($begin) || $begin=='') $begin=0;
			$query= 'select member.*, manager.FullName as ManagerFullName from member left join manager on member.Manager = manager.UserName';
			if($level!=1) $query.=' where Manager="'.$manager.'"';
			// if($filter!=null)
			// {
				// $query.=' and '.$this->getStringFilter($filter);
			// }
			if($sort_by != null && $sort_order != null)
				$query.=' order by '.$sort_by.' '.$sort_order;
			$query.=' limit '.$begin.','.$number.'';
			$result=$this->db->query($query);
			return $result->result_array();
		}
		
		public function getMember($manager, $level, $email)
		{
			$this->db->where('EmailAddress',$email);
			if($level!=1) $this->db->where('Manager',$manager);
			$result=$this->db->get('member');
			$ss=$result->result_array();
			if(isset($ss[0]))
			{
				return $ss[0];
			}
		}
		
		public function editMember($manager, $managerlevel, $email, $name, $setmanager, $phone, $level, $status)
		{
		
			if($managerlevel==1){
				$data = array(
					'Name' => $name,
					'MobilePhone' => $phone,
					'Manager' => $setmanager,
					'Level' => $level,
					'Status' => $status,
				   'UpdatedDate' => date('Y-m-d H:i:s')
				  	);
				$this->db->where('EmailAddress', $email);
				$this->db->update('member', $data);
			}else{
				$data = array(
					'Name' => $name,
					'MobilePhone' => $phone,
					'Level' => $level,
					'Status' => $status,
				   'UpdatedDate' => date('Y-m-d H:i:s')
				  	);
				$this->db->where('Manager', $manager);
				$this->db->where('EmailAddress', $email);
				$this->db->update('member', $data);
			}
		}
		
	}
?>