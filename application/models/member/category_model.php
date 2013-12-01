<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Category_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		  // đếm tổng số record trong table book
        function count_all($user)
		{
			$this->db->where('EmailUser',$user);
			$this->db->where('(Deleted is null or Deleted = 0)', null, false);
            return $this->db->count_all_results('category');
        } 
		
		public function addcategory($user, $name, $note)
		{
			$array = array('Name' => $name, 
							'EmailUser' => $user, 
							'CreatedDate' => date('Y-m-d H:i:s'), 
							'UpdatedDate' => date('Y-m-d H:i:s'), 
							'Note' => $note);

			$this->db->set($array);
			$this->db->insert('category'); 
			
		}
		
		
		public function editcategory($user, $name, $id, $note)
		{
			
			$data = array(
					'Name' => $name,
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'Note'=>$note
						);

			$this->db->where('EmailUser', $user);
			$this->db->where('ID', $id);
			$this->db->update('category', $data); 
			
		}
		/*
		public function deletemultistoredemail($user, $ids)
		{
			
			$data = array(
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'Deleted'=>'1'
						);

			$this->db->where('EmailUser', $user);
			$this->db->where($ids,null,false);
			$this->db->update('storedemail', $data); 
			
		}
		*/
		public function deletecategory($user, $id)
		{
			$data = array(
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'Deleted'=>'1'
						);

			$this->db->where('EmailUser', $user);
			$this->db->where('ID', $id);
			$this->db->update('category', $data);
			
			$data = array(
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'CategoryID'=>null
						);

			$this->db->where('CategoryID', $id);
			$this->db->update('storedemail', $data); 			
		}
		
		public function getCategoryOfUser($user, $begin, $number=10, $sort_by=null, $sort_order=null)
		{
			if(!isset($begin) || $begin=='') $begin=0;
			$query= 'select *, NumberContact(ID) as NumContact from category';
			$query.=' where EmailUser="'.$user.'" and ((Deleted is null) OR (Deleted = 0))';
			if($sort_by != null && $sort_order != null)
				$query.=' order by '.$sort_by.' '.$sort_order;
			$query.=' limit '.$begin.','.$number.'';
			$result=$this->db->query($query);
			return $result->result_array();
		}
		
	}
?>