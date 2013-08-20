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
		
		
	}
	
/* End of file patron_model.php */
/* Location: ./application/models/patron_model.php */