<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Newsletter_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function getCategoryOfUser($user)
		{
			$this->db->select('ID');
			$this->db->select('Name');
			$this->db->where('EmailUser',$user);
			$this->db->where('(Deleted is null or Deleted = 0)', null, false);
			$this->db->order_by('Name', 'ASC');
			$result=$this->db->get('category');
			return $result->result_array();
		}
		
		  // đếm tổng số record trong table book
        function countAll($user, $filter=null)
		{
			$this->db->select('ID');
			$this->db->where('EmailUser',$user);
			$this->db->where('(Deleted is null or Deleted = 0)', null, false);
			// if($filter!=null)
			// {
				// $this->db->where('('.$this->getStringFilter($filter).')', null, false);
			// }
            return $this->db->count_all_results('newsletter');
        } 
		
		public function add($user,$name, $subject, $greet, $content, $note)
		{
			$array = array(	'EmailUser' => $user, 
								'CreatedDate' => date('Y-m-d H:i:s'), 
								'UpdatedDate' => date('Y-m-d H:i:s'), 
								'Name' => $name, 
								'Subject' => $subject, 
								'Greet' => $greet, 
								'Content' => $content, 
								'Note' => $note, 
								'status' => '0');

				$this->db->set($array);
				$this->db->insert('newsletter'); 
			
			$this->db->select('ID');
			$this->db->where('EmailUser',$user);
			$this->db->where('CreatedDate',$array["CreatedDate"]);
			$result=$this->db->get('newsletter');
			$ss=$result->result_array();
			if(isset($ss[0]) && $ss[0]["ID"]!='') 
			{
				return $ss[0]["ID"];
			}
		}
		
		public function edit($user, $id, $name, $subject, $greet, $content, $note)
		{
			$array = array(	'UpdatedDate' => date('Y-m-d H:i:s'), 
							'Name' => $name, 
							'Subject' => $subject, 
							'Greet' => $greet, 
							'Content' => $content, 
							'Note' => $note);
							
			$this->db->where('EmailUser',$user);
			$this->db->where('ID',$id);
			$this->db->update('newsletter', $array);
			
		}
		
		public function setup($user, $id, $status, $sentdate, $sentto, $period)
		{
			$array = array('NextRun' => date($sentdate), 
								'UpdatedDate' => date('Y-m-d H:i:s'), 
								'Period' => $period, 
								'SendTo' => $sentto, 
								'status' => $status);
			
			$this->db->where('EmailUser',$user);
			$this->db->where('ID',$id);
			$this->db->update('newsletter', $array);
		}
		
		
		public function getAll($user, $begin, $number=10, $sort_by=null, $sort_order=null, $filter=null)
		{
			if(!isset($begin) || $begin=='') $begin=0;
			$query= 'select * from newsletter';
			$query.=' where EmailUser="'.$user.'" and ((Deleted is null) OR (Deleted = 0))';
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
		
		public function getNewsletter($user, $ID)
		{
			$this->db->where('EmailUser',$user);
			$this->db->where('ID',$ID);
			$this->db->where('(Deleted is null or Deleted = 0)', null, false);
			$result=$this->db->get('newsletter');
			$ss=$result->result_array();
			if(isset($ss[0])) 
			{
				return $ss[0];
			}
		}
		
		public function updateSendData($user, $ID)
		{
			
			$data = array(
				   'LastRun' => date('Y-m-d H:i:s')
						);

			$this->db->where('EmailUser', $user);
			$this->db->where("ID",$ID);
			$this->db->update('newsletter', $data); 
			
		}
		
		public function deleteMultiNewsletter($user, $ids)
		{
			
			$data = array(
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'Deleted'=>'1'
						);

			$this->db->where('EmailUser', $user);
			$this->db->where($ids,null,false);
			$this->db->update('newsletter', $data); 
			
		}
		
		public function deleteNewsletter($user, $id)
		{
			
			$data = array(
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'Deleted'=>'1'
						);

			$this->db->where('EmailUser', $user);
			$this->db->where('ID', $id);
			$this->db->update('newsletter', $data); 
			
		}
		
	}
?>