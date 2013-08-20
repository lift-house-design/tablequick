<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends App_Controller
{
	public function __construct()
	{
		$this->models=array_merge($this->models,array(
			'patron',
		));

		parent::__construct();
	}

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
		// Load fancybox2
		$this->js[]=array(
			'file'=>'jquery.fancybox.pack.js',
			'type'=>'plugins/fancybox2',
		);
		$this->css[]=array(
			'file'=>'jquery.fancybox.css',
			'type'=>'plugins/fancybox2',
		);
		$this->js[]='jquery.maskedinput.min.js';
		$this->js[]='pages/dashboard-index.js';
	}

	public function new_customer($id=NULL)
	{
		$this->layout=FALSE;

		if($data=$this->input->post())
		{
			$this->patron->insert(array(
				'user_id'=>$this->user->data['id'],
				'name'=>$data['name'],
				'phone'=>$data['phone'],
				'status'=>'Waiting',
				'time_in'=>$data['time_in'],
			));
			$this->view=FALSE;
			exit;
		}
		else
		{
			if($id!==NULL)
			{
				$patron=$this->patron->get($id);

				if(!empty($patron))
				{
					$this->data['patron']=$patron;
				}
			}
		}
	}

	public function refresh_data()
	{
		$this->layout=FALSE;
		$this->view=FALSE;

		$patrons=$this->patron
			->order_by('time_in')
			->get_many_by(array(
				'user_id'=>$this->user->data['id'],
				'removed'=>0,
			));

		$data=array();

		foreach($patrons as $patron)
		{
			$item=array(
				$patron['id'],
				date('m/d/Y / h:ia',strtotime($patron['time_in'])),
				$patron['name'],
				$patron['status'],
				empty($patron['response']) ? '-' : $patron['response'],
				empty($patron['table_number']) ? '-' : $patron['table_number'],
			);

			$data[]=$item;
		}

		echo json_encode($data);
	}

	public function remove_customer($id)
	{
		$this->layout=FALSE;

		if($patron_id=$this->input->post('id'))
		{
			$this->patron->update($patron_id,array(
				'removed'=>1,
			));
			$this->view=FALSE;
			exit;
		}
		else
		{
			$this->data['patron']=$this->patron->get($id);
		}
	}

	public function cancel_customer($id)
	{
		$this->layout=FALSE;

		if($patron_id=$this->input->post('id'))
		{
			$this->patron->update($patron_id,array(
				'status'=>'Cancelled/Left',
			));
			$this->view=FALSE;
			exit;
		}
		else
		{
			$this->data['patron']=$this->patron->get($id);	
		}
	}

	public function seat_customer($id)
	{
		$this->layout=FALSE;

		if($data=$this->input->post())
		{
			$this->patron->update($data['id'],array(
				'status'=>'Seated',
				'table_number'=>$data['table_number'],
				'time_seated'=>date('Y-m-d H:i:s'),
			));
			$this->view=FALSE;
			exit;
		}
		else
		{
			$this->data['patron']=$this->patron->get($id);	
		}
	}

	public function seat_ready($id)
	{
		$this->layout=FALSE;

		if($patron_id=$this->input->post('id'))
		{
			$patron=$this->patron->get($patron_id);

			// 141 chars
			$message='Hi, {name} - your table is now ready. Please reply with "okay", "stay at bar", or "cancel" to notify the hostess of your decision. Thank you!';
			
			if(send_sms($message,$patron,$patron['phone']))
			{
				$this->patron->update($patron_id,array(
					'status'=>'Notified'
				));
			}

			$this->view=FALSE;
			exit;
		}
		else
		{
			$this->data['patron']=$this->patron->get($id);	
		}
	}

	public function seat_next_customer()
	{
		$patron=$this->patron
			->order_by('time_in')
			->get_by(array(
				'user_id'=>$this->user->data['id'],
				'status'=>'Waiting',
				'removed'=>0,
			));

		if(!empty($patron))	
		{
			$this->view='dashboard/seat_ready';
			$this->seat_ready($patron['id']);
		}
	}

	public function process_sms()
	{
		ob_start();
		var_dump($_POST);
		$data=ob_get_clean();

		$sql='insert into logger (data) values ('.$this->db->escape($data).')';
		$this->db->query($sql);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */