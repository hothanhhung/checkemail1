<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class General_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		
		public function getAll()
		{
			
				$result=$this->db->get('general');
				$ss=$result->result_array();
				return $ss;
		}
		
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
	}
?>