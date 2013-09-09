<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends App_Controller
{
	public function __construct()
	{
		$this->models=array_merge($this->models,array(
			'patron',
		));

		$this->data['nav_pages'] = array(
			'/' => array('name' => 'Assign Seating', 'active' => ''),
			'/table_feedback' => array('name' => 'Table Feedback', 'active' => ''),
			'/guest_connection' => array('name' => 'Guest Connection', 'active' => '')
		);

		parent::__construct();

		if(!$this->user->logged_in)
			redirect('/');
	}

	public function index()
	{
		$this->_load_js_css();
		$this->js[]='pages/dashboard-index.js';
		$this->data['nav_pages']['/']['active'] = 'active';
	}

	public function table_feedback()
	{
		$this->_load_js_css();
		$this->js[]='pages/dashboard-table-feedback.js';
		$this->js[]=array(
			'file'=>'jquery.base64.min.js',
			'type'=>'plugins/jquery-base64-master',
		);
		$this->js[]=array(
			'file'=>'jquery.printElement.min.js',
			'type'=>'plugins',
		);
		$this->data['nav_pages']['/table_feedback']['active'] = 'active';
		$this->data['user'] = $this->user->data;
	}

	public function guest_connection()
	{
		$this->_load_js_css();
		$this->js[]='pages/dashboard-guest-connection.js';
		$this->data['nav_pages']['/guest_connection']['active'] = 'active';
	}	

	public function refresh_guest_connection()
	{
		$this->layout=FALSE;
		$this->view=FALSE;

		$patrons = $this->patron->get_guest_connections();
		$data = array();
		foreach($patrons as $patron)
		{
			$item=array(
				$patron['id'],
				date('m/d/Y - h:ia',strtotime($patron['last_in'])),
				$patron['name'],
				$patron['phone'],
				$patron['total_visits']	
			);

			$data[]=$item;
		}

		echo json_encode($data);
	}

	public function refresh_table_feedback()
	{
		$this->layout=FALSE;
		$this->view=FALSE;

		$patrons = $this->db->query('select * from patron_feedback where user_id='.$this->user->data['id'].' order by time desc')->result_array();
		$data = array();
		foreach($patrons as $patron)
		{
			$item=array(
				$patron['id'],
				date('m/d/Y - h:ia',strtotime($patron['time'])),
				$patron['table_number'],
				$patron['server_name'],
				substr(wordwrap($patron['comment'],30,"\n",true),0,2000)	
			);

			$data[]=$item;
		}

		echo json_encode($data);
	}

	public function visit_details($id=0)
	{
		$this->_load_js_css();
		//$this->js[]='pages/dashboard-visit-details.js';
		$this->layout = FALSE; //'layouts/popup.php';
		$this->data = $this->patron->get_visit_details($id);

		//format timestamps
		foreach($this->data['visits'] as $i => $v){
			if(!$v['time_seated'])
				$seated = '-';
			else
				$seated = date('m/d/Y - h:ia',strtotime($v['time_seated']));
			$this->data['visits'][$i]['time_seated'] = $seated;
			$this->data['visits'][$i]['time_in'] = date('m/d/Y - h:ia',strtotime($v['time_in']));
		}
	}

	public function send_text_offer()
	{
		$this->layout = FALSE;
		$this->data = $this->input->post();
		if(!empty($this->data['text'])){
			$this->view = false;
			$errors = array();
			$this->data['numbers'] = array_unique($this->data['numbers']);
			foreach($this->data['numbers'] as $i => $to){
				$success = send_sms($this->data['text'],array(),$to);
				if(!$success)
					unset($this->data['numbers'][$i]);
			}
			if(empty($this->data['numbers']))
				echo "Unable to send text messages.";
			else
				echo "Sent: {$this->data['text']}<br/><br/> To: ".join(', ',$this->data['numbers']);
		}
	}

	public function refresh_assign_seating()
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
				$patron['party_size'],
				$patron['status'],
				empty($patron['response']) ? '-' : $patron['response'],
				empty($patron['table_number']) ? '-' : $patron['table_number'],
			);

			$data[]=$item;
		}

		echo json_encode($data);
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
				'party_size'=>intval($data['party_size']),
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
			$message='Hi, {name} - your table is now ready. Please reply with "okay", "stay at bar", or "cancel".';
			
			if(send_sms($message,$patron,$patron['phone']))
			{
				$this->patron->update($patron_id,array(
					'status'=>'Notified'
				));
				echo json_encode('success');
			}else{
				echo json_encode('Error sending SMS');
			}

			$this->view=FALSE;
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

	private function _load_js_css()
	{
		// Load dataTables
		$this->js[]=array(
			'file'=>'media/js/jquery.js',
			'type'=>'plugins/DataTables-1.9.4',
		);
		$this->js[]=array(
			'file'=>'media/js/jquery.dataTables.js',
			'type'=>'plugins/DataTables-1.9.4',
		);
		$this->js[]=array(
			'file'=>'extras/TableTools/media/js/ZeroClipboard.js',
			'type'=>'plugins/DataTables-1.9.4',
		);
		$this->js[]=array(
			'file'=>'extras/TableTools/media/js/TableTools.js',
			'type'=>'plugins/DataTables-1.9.4',
		);
		$this->css[]=array(
			'file'=>'css/jquery.dataTables.css',
			'type'=>'plugins/datatables',
		);
		$this->css[]=array(
			'file'=>'extras/TableTools/media/css/TableTools.css',
			'type'=>'plugins/DataTables-1.9.4',
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
		// Load pines notify
		$this->js[]=array(
			'file'=>'jquery.pnotify.min.js',
			'type'=>'plugins/pnotify',
		);
		$this->css[]=array(
			'file'=>'jquery.pnotify.default.css',
			'type'=>'plugins/pnotify',
		);
		$this->js[]='jquery.maskedinput.min.js';
	}

	private function _log($msg)
	{
		// Dump the POST data
		ob_start();
		var_dump($_POST);
		$data=ob_get_clean();

		// Log it for later
		$sql='insert into sms_exception (error, data) values ('.$this->db->escape($msg).','.$this->db->escape($data).')';
		$this->db->query($sql);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */