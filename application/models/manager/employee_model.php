<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Employee_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		function countAll($filter=null)
		{
			$this->db->select('ID');
			// if($filter!=null)
			// {
				// $this->db->where('('.$this->getStringFilter($filter).')', null, false);
			// }
            return $this->db->count_all_results('manager');
        } 
		
		public function getAll($begin, $number=10, $sort_by=null, $sort_order=null, $filter=null)
		{
			if(!isset($begin) || $begin=='') $begin=0;
			$query= 'select * from manager';
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
		
		public function getEmployee($username)
		{
			$this->db->where('UserName',$username);
			$result=$this->db->get('manager');
			$ss=$result->result_array();
			if(isset($ss[0]))
			{
				return $ss[0];
			}
		}
		
		public function editEmployee($username, $name, $note, $phone, $level, $status)
		{
		
			$data = array(
					'FullName' => $name,
					'MobilePhone' => $phone,
					'Note' => $note,
					'Level' => $level,
					'Status' => $status,
				   'UpdatedDate' => date('Y-m-d H:i:s')
				  	);
				$this->db->where('UserName', $username);
				$this->db->update('manager', $data);
			
		}
		
	}
?>