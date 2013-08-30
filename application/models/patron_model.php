<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Patron_model extends App_Model
	{
		public $_table='patron';

		protected $protected_attributes=array('id');
		
		public $has_many=array();
		
		public $belongs_to=array();
		
		public $after_get=array('_filter_data');

		public $before_update=array('_filter_data');

		public $before_delete=array();

	/*-----------------------------------------------------------------------*/

		public function get_guest_connections(){
			$query = 'select id,max(time_seated) as last_seated,name,phone,count(time_seated) as total_visits from patron where time_seated is not null and user_id='.$this->user->data['id'].' group by name,phone order by max(time_seated) desc;';
			return $this->_database->query($query)->result_array();
		}

		public function get_visit_details($id){
			$id = intval($id);

			// get patron name/phone
			$data = $this->_database->select('name,phone')->where('id',$id)->get('patron')->row_array();
			if(empty($data)) throw new Exception('Patron not found. ID: '.$id);

			// get visits
			//$query = 'select concat(u.first_name," ",u.last_name) as employee, p1.time_in,p1.time_seated from patron p1, patron p2, user u where p1.name=p2.name and p1.phone=p2.phone and u.id=p1.user_id and p2.id='.intval($id).' and p1.user_id='.$this->user->data['id'].' order by time_in desc;';
			$query = 'select p1.time_in,p1.time_seated from patron p1, patron p2 where p1.name=p2.name and p1.phone=p2.phone and p2.id='.intval($id).' and p1.user_id='.$this->user->data['id'].' order by time_in desc;';
			$data['visits'] =  $this->_database->query($query)->result_array();

			return $data;
		}
		
	}
	
/* End of file patron_model.php */
/* Location: ./application/models/patron_model.php */