<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Database Configuration
|--------------------------------------------------------------------------
|
| http://ellislab.com/codeigniter/user-guide/database/configuration.html
|
|--------------------------------------------------------------------------
*/
$config['database_environments']=array(
	'local'=>array(
		'username'=>'root',
		'password'=>'root',
	),
	'development'=>array(
		'username'=>'thomas',
		'password'=>'Dsb6Zf3npPi8',
		'database'=>'thomas_tablequick',
	),
	'production'=>array( // TBD
		'username'=>'',
		'password'=>'',
	),
);
$config['database']=array(
	'hostname'=>'localhost',
	'database'=>'tablequick',
	'dbdriver'=>'mysql',
	'db_debug'=>ENVIRONMENT!=='production',
);

// Overwrite default database settings with environment-specific settings
$config['database']=array_merge($config['database'],$config['database_environments'][ENVIRONMENT]);

/*
|--------------------------------------------------------------------------
| General Site Configuration
|--------------------------------------------------------------------------
|
| 'site_name'			The name of the site to be used in the title bar
|						and various other locations
|
| 'site_description'	A short description or tagline to be used as the
|						default meta description and possibly other places
|						on the site
|
| 'title_format'		The formatting of the title used on every page,
|						where the first argument is the site name and the
|						second is the page name
|
| 'copyright_format'	The formatting of the copyright used at the bottom
|						of every page and in the meta tag, where the first
|						argument is the site name and the second is the 
|						current year
|
*/
$config['site_name']='TableQuick';
$config['site_description']='';
$config['title_format']='%1$s | %2$s';
$config['copyright_format']='Copyright &copy; %1$s %2$d. All Rights Reserved.';

/*
|--------------------------------------------------------------------------
| URL/Path Configuration
|--------------------------------------------------------------------------
|
| 'base_url'			Base site URL (prefix with http://)
|
| 'assets_url'			URL prefix to the assets directory
|
| 'module_path'			Base module directory path
|
*/
$config['base_url_environment']=array(
	'local'=>'http://local.tablequick.com',
	'development'=>'http://tablequick.lifthousedesign.com',
	'production'=>'http://tablequick.com',
);
$config['base_url']=$config['base_url_environment'][ENVIRONMENT];
$config['assets_url']='/assets';
$config['module_path']=APPPATH.'modules';

/*
|--------------------------------------------------------------------------
| Google Analytics
|--------------------------------------------------------------------------
|
| 'ga_code'				The "UA-XXXXX-X" code for google analytics, or FALSE
|						to disable
|
*/
$config['ga_code']=FALSE;

/*
|--------------------------------------------------------------------------
| E-mail Notifications Configuration
|--------------------------------------------------------------------------
|
| 'sender_email'		The e-mail address displayed as the sender on
|						outgoing e-mails
|
| 'sender_name'			The name displayed as the sender on outgoing
|						e-mails
|
| 'config'				Configuration array passed to the e-mail component
|
*/
$config['email_notifications']=array(
	'sender_email'=>'no-reply@lifthousedesign.com',
	'sender_name'=>'Lifthouse Design',
	'config'=>array(
		'protocol'=>'smtp',
		'smtp_host'=>'mail.lifthousedesign.com',
		'smtp_user'=>'noreply@lifthousedesign.com',
		'smtp_pass'=>'9sbZdlAklydT',
		'smtp_port'=>'25',
		'mailtype'=>'html',
	),
);

/*
|--------------------------------------------------------------------------
| SMS Notifications Configuration
|--------------------------------------------------------------------------
|
| 'config'				Configuration array used by the Twilio component
|
*/
$config['sms_notifications']=array(
	'config'=>array(
		'mode'=>'prod',
		'account_sid'=>'AC295178e1f333781132528cd16d55e49b',
		'auth_token'=>'81905b30336cc2fb674adf13e3f17fb2',
		'api_version'=>'2010-04-01',
		'number'=>'+15129422374',
	),
);

/*
|--------------------------------------------------------------------------
| SMS Response Keywords
|--------------------------------------------------------------------------
|
| 'okay'				Array of keywords that indicates a patron is on
|						his or her way
|
| 'stay_at_bar'			Array of keywords that indicates a patron has
|						chosen to stay at the bar
|
| 'cancel'				Array of keywords that indicates a patron would
| 						no longer like to be on the list
|
*/
$config['response_keywords']=array(
	'ok on our way'=>array(
		'ok',
		'okay',
		'on our way',
		'on my way',
		'coming',
		'omw',
		'be right there',
		'brt',
		'otw',
		'yes',
	),
	'stay at bar'=>array(
		'stay',
	),
	'cancel table'=>array(
		'cancel',
		'no',
		'not here',
		'left',
		'gone',
	),
);

/* End of file app.php */
/* Location: ./application/config/app.php */