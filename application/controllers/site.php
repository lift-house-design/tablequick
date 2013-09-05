<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends App_Controller
{
	public function __construct()
	{
		$this->models[]='notification';

		parent::__construct();
	}

	public function index()
	{
		$this->css[]=array(
			'file'=>'css/bootstrap.min.css',
			'type'=>'plugins/bootstrap'
		);
	}

	public function customer_feedback($user_id='',$table_number='',$server_name='')
	{
		if($this->input->post('user_id'))
		{
			// get post data & user info
			$this->data = $this->input->post();
			$this->data['user_id'] = intval($this->data['user_id']);
			$this->data['phone'] = parse_phone($this->data['phone']);
			$user = $this->db->query('select email, phone, phone_text_capable from user where id='.$this->data['user_id'])->row_array();
			// if valid user and comment, insert and send notification
			if(!empty($user) && !empty($this->data['comment']))
			{
				$this->db->insert('patron_feedback',$this->data);

				// send feedback notification to restaurant manager
				$subject = "Feedback received for " .
					($this->data['server_name'] ? $this->data['server_name'] . " at " : "") .
					"table " . $this->data['table_number'];
				$message = $subject . "\nFrom " . $this->data['name'] .
					" ".$this->data['phone'] . "\n". $this->data['comment'];
				if($user['phone_text_capable'])
				{
					$to = $user['phone'];
					send_sms($message,array(),$to);
				}
				$to = $user['email'];
				send_email($subject,$message,array(),$to);
			}
		}
		else
		{
			$this->js[]=array(
				'file'=>'media/js/jquery.js',
				'type'=>'plugins/DataTables-1.9.4',
			);
			$this->js[]=array(
				'file'=>'jquery.validate.js',
				'type'=>'plugins',
			);
			$this->js[]=array(
				'file'=>'additional-methods.js',
				'type'=>'plugins',
			);
			$this->data['user_id'] = intval(base64_decode($user_id));
			$this->data['table_number'] = base64_decode($table_number);
			$this->data['server_name'] = base64_decode($server_name);

			if(!$user_id || !$table_number)
			{
				redirect('/');
			}
		}
	}

	public function log_in()
	{
		if($this->input->post() && $this->user->log_in())
		{
			redirect('dashboard');
		}

		$this->view='site/index';
		$this->index();
	}

	public function log_out()
	{
		$this->user->log_out();
		redirect('/');
	}

	public function sign_up()
	{
		$rules=array(
			array(
				'field'=>'email',
				'label'=>'E-mail',
				'rules'=>'trim|required|max_length[64]|valid_email|is_unique[user.email]',
			),
			array(
				'field'=>'password',
				'label'=>'Password',
				'rules'=>'trim|required|sha1',
			),
			array(
				'field'=>'confirm_password',
				'label'=>'Confirm Password',
				'rules'=>'trim|required|matches[password]|sha1',
			),
			array(
				'field'=>'first_name',
				'label'=>'First Name',
				'rules'=>'trim|required',
			),
			array(
				'field'=>'last_name',
				'label'=>'Last Name',
				'rules'=>'trim',
			),
			array(
				'field'=>'phone',
				'label'=>'Phone',
				'rules'=>'trim|required|valid_phone',
			),
		);

		$this->load->library('form_validation');
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run()!==FALSE)
		{
			$data=$this->input->post();
			$data['phone_text_capable']=isset($data['phone_text_capable']) ? 1 : 0;
			$data['confirm_code']=$this->user->generate_confirm_code();

			if($user_id=$this->user->insert($data))
			{
				$notification_data=array(
					'first_name'=>$data['first_name'],
					'last_name'=>$data['last_name'],
					'email'=>$data['email'],
					'phone'=>$data['phone'],
					'confirm_url'=>site_url('confirm-account/'.$user_id.'/'.$data['confirm_code']),
				);
				$this->notification->send('user_registered',$notification_data,$data['email']/*,$data['phone']*/);
				$this->form_validation->reset_values();
				$this->set_notification('You have been sent an e-mail with a link that will verify your e-mail address and activate your account. Thank you for registering!');
			}
		}

		$this->js[]='jquery.maskedinput.min.js';
		$this->js[]='pages/site-sign-up.js';
	}

	public function confirm_account($id,$confirm_code)
	{
		$this->data['confirmed']=FALSE;

		$user=$this->user->get_by(array(
			'id'=>$id,
			'confirm_code'=>$confirm_code,
		));

		if(!empty($user))
		{
			$data=array(
				'confirm_code'=>NULL,
			);
			if($this->user->update($id,$data))
			{
				$this->data['confirmed']=TRUE;
				$this->data['email']=$user['email'];

				// Send notification: user_confirmed
				$notification_data=array(
					'first_name'=>$user['first_name'],
					'last_name'=>$user['last_name'],
					'email'=>$user['email'],
					'phone'=>$user['phone'],
					'login_url'=>site_url(),
				);
				$this->notification->send('user_confirmed',$notification_data,$user['email']/*,$user['phone']*/);
			}
		}
	}

	public function forgot_password()
	{
		$rules=array(
			array(
				'field'=>'email',
				'label'=>'E-mail',
				'rules'=>'trim|required|max_length[64]|valid_email',
			),
		);

		$this->load->library('form_validation');
		$this->form_validation->set_rules($rules);

		if($this->form_validation->run()!==FALSE)
		{
			$user=$this->user->get_by(array(
				'email'=>$this->input->post('email'),
			));

			if(!empty($user))
			{
				$data=array(
					'confirm_code'=>$this->user->generate_confirm_code(),
				);
				if($this->user->update($user['id'],$data))
				{
					$notification_data=array(
						'first_name'=>$user['first_name'],
						'last_name'=>$user['last_name'],
						'email'=>$user['email'],
						'phone'=>$user['phone'],
						'reset_url'=>site_url('reset-password/'.$user['id'].'/'.$data['confirm_code']),
					);
					$this->notification->send('user_forgot_password',$notification_data,$user['email'],$user['phone']);
					$this->form_validation->reset_values();
					$this->set_notification('You have been sent an e-mail with a link that will allow you to reset your password.');
				}
			}
			else
			{
				$this->form_validation->set_error('That e-mail address was not found. Please check your e-mail address and try again.');
			}
		}
	}

	public function reset_password($id,$confirm_code)
	{
		$this->data['password_reset']=FALSE;
		$this->data['confirmed']=FALSE;
		$this->data['id']=$id;
		$this->data['confirm_code']=$confirm_code;

		$this->load->library('form_validation');

		$user=$this->user->get_by(array(
			'id'=>$id,
			'confirm_code'=>$confirm_code,
		));

		if(!empty($user))
		{
			$this->data['confirmed']=TRUE;
			$this->data['email']=$user['email'];

			$rules=array(
				array(
					'field'=>'password',
					'label'=>'Password',
					'rules'=>'trim|required|sha1',
				),
				array(
					'field'=>'confirm_password',
					'label'=>'Confirm Password',
					'rules'=>'trim|required|matches[password]|sha1',
				),
			);

			$this->form_validation->set_rules($rules);

			if($this->form_validation->run()!==FALSE)
			{
				$data=array(
					'password'=>$this->input->post('password'),
					'confirm_code'=>NULL,
				);

				if($this->user->update($id,$data))
				{
					$this->data['password_reset']=TRUE;
				}
				else
				{
					$this->form_validation->set_error('There was a problem resetting your password. Please try again.');
				}
			}
		}
	}

	public function authentication_error(){}

	public function send_test_notification()
	{
		$this->load->model('notification_model','notification');
		$data=array(
			'var_1'=>'Value 1',
			'var_2'=>'Value 2',
		);
		$this->notification->send('test_notification',$data,'nick@mvbeattie.com','3048716066');

		$this->view=FALSE;
	}
}

/* End of file site.php */
/* Location: ./application/controllers/site.php */