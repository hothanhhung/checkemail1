<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class General_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function get($name)
		{
			$this->db->where('Name',$name);
			$result=$this->db->get('general');
			$ss=$result->result_array();
			if(isset($ss[0])) 
			{
				return $ss[0];
			}
		}
		

	}
?>