<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Process_sms extends App_Controller
{
	public function __construct()
	{
		$this->models=array_merge($this->models,array(
			'patron',
			'log'
		));

		parent::__construct();
	}

	public function index()
	{
		$this->layout=FALSE;
		$this->view=FALSE;
		$data=$this->input->post();
		if(empty($data))
			$this->log->error("No Post Data in process_sms",$_SERVER,true);
		if(!isset($data['From']) || !isset($data['Body']))
			$this->log->error("Bad POST data from Twilio",$data,true);

		$from_phone = parse_phone($data['From']);
		if(!$from_phone)
			$this->log->error('From phone number unable to be formatted - "'.$data['From'].'" = "'.$from_phone.'"',$data,true);

		$message = trim(strtolower($data['Body']));

		$patron = $this->patron
			->order_by('time_in','desc') // We want the latest entry of this patron (otherwise we may update an old entry)
			->get_by(array(
				'phone'=>$from_phone,
				'removed'=>0,
				'status'=>'Notified', // Make sure this patron has been notified and has not responded yet
			));

		if(empty($patron))
			$this->log->error('Unable to find Notified Patron',$data,true);

		$response_keywords=$this->config->item('response_keywords');

		foreach($response_keywords as $response=>$keywords)
		{
			// Check for this response's keywords
			foreach($keywords as $keyword)
			{
				if(stripos($message,$keyword)!==FALSE)
				{
					// Found the keyword
					$this->patron->update($patron['id'],array(
						'response' => $response,
						'status' => 'Notified/Replied',
					));
					$this->log->log(
						"'$reponse' Response received from patron",
						array(
							'calculated_response' => $response,
							'received_response' => $message
						),
						true
					);
					return true;
				}
			}
		}
		$this->log->error(
			'Unable to determine patron response',
			array(
				'received_response' => $message,
				'response_keywords' => $response_keywords
			),
			true
		);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */