<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Manage extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper("url");
		}

		public function index()
		{
			$this->load->view('manage_view');
		}

		public function checkemailrecods()
		{
			$this->load->model('Manage_Model');
			$data["checkemailrecods"]=$this->Manage_Model->checkemailrecods();
			$this->load->view('manage_view',$data);
		}
	}
?>