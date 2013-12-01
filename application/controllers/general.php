<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct()
	{
		parent::__construct();
		$this->load->model("General_Model");
		$this->load->library('session');
		$this->load->helper("url");
		
	}
	
	public function index()
	{
	}
	
	public function policy()
	{
		$plc = $this->General_Model->get("Policy");
		if(isset($plc))
		{
			if(isset($plc["Title"])) $data["title"] = $plc["Title"];
			if(isset($plc["Content"])) $data["content"] = $plc["Content"];
			$temp["data"]=$data;
		}
		$temp['index']="6";
		$temp['title']="Điều khoản sử dụng";
		$temp['template']='general_view';
		$temp['userlogin']=$this->session->userdata('userlogin');
		$this->load->view("mylayout",$temp); 
	}
	
	public function faq()
	{
		$plc = $this->General_Model->get("FAQ");
		if(isset($plc))
		{
			if(isset($plc["Title"])) $data["title"] = $plc["Title"];
			if(isset($plc["Content"])) $data["content"] = $plc["Content"];
			$temp["data"]=$data;
		}
		$temp['index']="5";
		$temp['title']="Các câu hỏi thường gặp";
		$temp['template']='general_view';
		$temp['userlogin']=$this->session->userdata('userlogin');
		$this->load->view("mylayout",$temp); 
	}
	
	public function aboutus()
	{
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */