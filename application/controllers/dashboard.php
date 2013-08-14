<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends App_Controller
{
	public function index()
	{
		// Load dataTables
		$this->js[]=array(
			'file'=>'js/jquery.dataTables.min.js',
			'type'=>'plugins/datatables',
		);
		$this->css[]=array(
			'file'=>'css/jquery.dataTables.css',
			'type'=>'plugins/datatables',
		);
		$this->js[]='pages/dashboard-index.js';

		
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */