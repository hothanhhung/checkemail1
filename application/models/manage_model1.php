<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Manage_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function checkemailrecods()
		{
			$this->db->order_by('CheckDate desc');
			$this->db->limit('30','0');
			$result = $this->db->get('checkemailsrecord');
			return $result->result_array();
		}

	}
?>