<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Contact_Model extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		  // đếm tổng số record trong table book
        function count_all($user, $filter=null)
		{
			$this->db->where('EmailUser',$user);
			$this->db->where('(Deleted is null or Deleted = 0)', null, false);
			if($filter!=null)
			{
				$this->db->where('('.$this->getStringFilter($filter).')', null, false);
			}
            return $this->db->count_all_results('storedemail');
        } 
		
		function getAllEmails($user, $filter=null)
		{
			$this->db->select("FullName");
			$this->db->select("StoredEmail");
			$this->db->where('EmailUser',$user);
			$this->db->where('(Deleted is null or Deleted = 0)', null, false);
			if($filter!=null)
			{
				if(strpos($filter,',-1,') !== false)
				{
					$this->db->where("storedemail.CategoryID is null or POSITION(','+storedemail.CategoryID+',' IN ".$filter.") > 0 ", null, false);
				}else
					$this->db->where("POSITION(','+storedemail.CategoryID+',' IN '".$filter."') > 0 ", null, false);
			}
            $result=$this->db->get('storedemail');
			return $result->result_array();
        } 
		
		function deleteContactInFilter($user, $filter)
		{
			$data = array(
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'Deleted'=>'1'
						);

			$this->db->where('EmailUser', $user);
			$this->db->where('('.$this->getStringFilter($filter).')', null, false);
			$this->db->update('storedemail', $data); 
			
		}
		
		public function addContact($user, $name, $email, $note, $domain, $catID=null)
		{
			$this->db->select('ID');
			$this->db->limit(1,0);
			$this->db->where('EmailUser',$user);
			$this->db->where('StoredEmail',$email);
			$this->db->where('(Deleted is null or Deleted = 0)', null, false);
			$result=$this->db->get('storedemail');
			$ss=$result->result_array();
			if(isset($ss[0]) && $ss[0]["ID"]!='') 
			{
				$id = $ss[0]["ID"];
				$data = array(
						'FullName' => $name,
						'UpdatedDate' => date('Y-m-d H:i:s'),
						'Note' => $note, 
						'CategoryID' => $catID
							);

				$this->db->where('ID', $id);
				$this->db->update('storedemail', $data); 
			}
			else {
				$array = array(	'FullName' => $name,
								'EmailUser' => $user, 
								'StoredEmail' => $email, 
								'CreatedDate' => date('Y-m-d H:i:s'), 
								'UpdatedDate' => date('Y-m-d H:i:s'), 
								'Note' => $note, 
								'Domain' => $domain,
								'CategoryID' => $catID,
								'status' => '-1');

				$this->db->set($array);
				$this->db->insert('storedemail'); 
				
			}
		}
		
		public function editnote($user, $id, $note)
		{
			
			$data = array(
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'Note'=>$note
						);

			$this->db->where('EmailUser', $user);
			$this->db->where('ID', $id);
			$this->db->update('storedemail', $data); 
			
		}
		
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
		
		public function deletestoredemail($user, $id)
		{
			
			$data = array(
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'Deleted'=>'1'
						);

			$this->db->where('EmailUser', $user);
			$this->db->where('ID', $id);
			$this->db->update('storedemail', $data); 
			
		}
		
		public function getStringFilter($data)
		{
			$fullname=$data['fullname'];
			$email=$data['email'];
			$sbCateID=$data['sbCateID'];
			$sbDomain=$data['sbDomain'];
			$sbDisconnected=$data['sbDisconnected'];
			$sbStatus=$data['sbStatus'];
			
			$filter='';
			if($fullname!="") $filter.=' FullName like "%'.$fullname.'%" and'; 
			if($email!="") $filter.=' StoredEmail like "%'.$email.'%" and ';
			
			if($sbCateID!=null)
			{
				$sub='(';
				foreach($sbCateID as $cat)
				{
					if($cat==-1) $sub.=' CategoryID is null or CategoryID = '.$cat.' or';
					else $sub.=' CategoryID = '.$cat.' or';
				}
				$sub.=' false) and ';
				$filter.=$sub;
			}
			
			
			if($sbDomain!=null)
			{
				$sub='(';
				foreach($sbDomain as $dm)
				{
					$sub.=' Domain like "'.$dm.'" or';
				}
				$sub.=' false) and ';
				$filter.=$sub;
			}
			if($sbDisconnected!=null)
			{
				$sub='(';
				if($sbDisconnected=="0")
						$sub.=' Disconnected is null or Disconnected =0 or';
				else	$sub.=' Disconnected = '.$sbDisconnected.' or';
				
				$sub.=' false) and ';
				$filter.=$sub;
			}
			if($sbStatus!=null)
			{
				$sub='(';
				foreach($sbStatus as $st)
				{
					if($st==-1)
						$sub.=' Status is null or Status = -1 or';
					else	$sub.=' Status = '.$st.' or';
				}
				$sub.=' false) and';
				$filter.=$sub;
			}
			$filter.=' true';
			return $filter;
		}
		
		public function getEmailOfUser($user, $begin, $number=10, $sort_by=null, $sort_order=null, $filter=null)
		{
			if(!isset($begin) || $begin=='') $begin=0;
			$query= 'select *, getNameCategory(CategoryID) as NameCategory from storedemail';
			$query.=' where EmailUser="'.$user.'" and ((Deleted is null) OR (Deleted = 0))';
			if($filter!=null)
			{
				$query.=' and '.$this->getStringFilter($filter);
			}
			if($sort_by != null && $sort_order != null)
				$query.=' order by '.$sort_by.' '.$sort_order;
			
			if($number != -1)
				$query.=' limit '.$begin.','.$number.'';
			$result=$this->db->query($query);
			return $result->result_array();
			
		}
		
		public function getEmailOfUserInFilter($user, $filter)
		{
			$query= 'select StoredEmail from storedemail';
			$query.=' where EmailUser="'.$user.'" and ((Deleted is null) OR (Deleted = 0))';
			$query.=' and '.$this->getStringFilter($filter);			
			$result=$this->db->query($query);
			return $result->result_array();
			
		}
		
		public function getDomainOfUser($user)
		{
			if(!isset($begin) || $begin=='') $begin=0;
			$query= 'select DISTINCT Domain from storedemail';
			$query.=' where EmailUser="'.$user.'" and ((Deleted is null) OR (Deleted = 0))';
			$query.=' order by Domain ASC';
			$result=$this->db->query($query);
			return $result->result_array();
			
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
		
		public function getContact($user, $id)
		{
			$this->db->where('EmailUser',$user);
			$this->db->where('ID',$id);
			$this->db->where('(Deleted is null or Deleted = 0)', null, false);
			$result=$this->db->get('storedemail');
			$ss = $result->result_array();
			if(isset($ss[0]))
				return $ss[0];
			else {
				return null;
			}
		}
		
		public function editcontact($user, $name, $id, $note, $catID)
		{
			
			$data = array(
					'FullName' => $name,
				   'UpdatedDate' => date('Y-m-d H:i:s'),
				   'Note'=>$note,
				   'CategoryID'=>$catID
						);

			$this->db->where('EmailUser', $user);
			$this->db->where('ID', $id);
			$this->db->update('storedemail', $data); 
			
		}
		
	}
?>