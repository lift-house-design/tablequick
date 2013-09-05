<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Process_sms extends App_Controller
{
	public function __construct()
	{
		$this->models=array_merge($this->models,array(
			'patron',
		));

		parent::__construct();
	}

	public function log_error($string,$array=array())
	{

	}

	public function index()
	{
		$this->layout=FALSE;
		$this->view=FALSE;
		$log = '';
		try
		{
			if($data=$this->input->post())
			{
				if(isset($data['From']) && isset($data['Body']))
				{
					/*
					|--------------------------------------------------------------------------
					| Find the patron that sent the text
					|--------------------------------------------------------------------------
					*/
					$from_phone = parse_phone($data['From']);

					if($from_phone===FALSE)
						throw new Exception('From phone number unable to be formatted - "'.$data['From'].'" = "'.$form_phone.'"');

					$message = trim(strtolower($data['Body']));

					$patron=$this->patron
						->order_by('time_in','desc') // We want the latest entry of this patron (otherwise we may update an old entry)
						->get_by(array(
							'phone'=>$from_phone,
							'removed'=>0,
							'status'=>'Notified', // Make sure this patron has been notified and has not responded yet
						));

					if(empty($patron))
						throw new Exception('Unable to find patron');
					
					$response_keywords=$this->config->item('response_keywords');

					foreach($response_keywords as $response=>$keywords)
					{
						// Check for this response's keywords
						foreach($keywords as $keyword)
						{
							if(strpos($message,$keyword)!==FALSE)
							{
								// Found the keyword
								return $this->patron->update($patron['id'],array(
									'response'=>$response,
									'status'=>'Notified/Replied',
								));
							}
						}
					}

					// At this point, no keywords were found
					throw new Exception('Unable to determine request');
				}
				else
				{
					throw new Exception('Incorrect Twilio data posted');
				}
			}else{
				throw new Exception("No Post Data???");
			}
		}
		catch (Exception $e)
		{
			// Dump the POST data
			ob_start();
			var_dump($_POST);
			$data=ob_get_clean();

			// Log it for later
			$sql='insert into sms_exception (error, data) values ('.$this->db->escape($e->getMessage()).','.$this->db->escape($data).')';
			$this->db->query($sql);
		}
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */