<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class EmailConfig_Model extends CI_Model
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
            return $this->db->count_all_results('emailconfig');
        } 
		
		public function getAll($begin, $number=10, $sort_by=null, $sort_order=null, $filter=null)
		{
			if(!isset($begin) || $begin=='') $begin=0;
			$query= 'select * from emailconfig';
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
		
		public function add($email,$protocol,$SMTPHost,$SMTPPort,$NumberSendPerDate,$Password,$note,$status)
		{
			$data = array(
				"Email" => $email,
				"Protocol"=>$protocol,
				"smtp_host"=>$SMTPHost,
				"smtp_port"=>$SMTPPort,
				"CreatedDate"=>date('Y-m-d H:i:s'),
				"LastUsedDate"=>null,
				"NumberSentEmail"=>"0",
				"NumberSendPerDate"=>$NumberSendPerDate,
				"NumberSentEmailToday"=>"0",
				"Note"=>$note,
				"Status"=>$status
			);
			$result=$this->db->insert('emailconfig',$data);	
		}
		/*
		public function getPage($id)
		{
			$this->db->where("ID",$id);
			$result=$this->db->get('general');
			$ss=$result->result_array();
			if(isset($ss[0]))
				return $ss[0];
			return false;
		}
		
		public function editPage($id, $title, $content)
		{
			$data = array(
				"Title" => $title,
				"Content" => $content,
				"UpdatedDate" => date('Y-m-d H:i:s')
			);
			$this->db->where("ID",$id);
			$result=$this->db->update('general',$data);			
		}
		*/
	}
?>