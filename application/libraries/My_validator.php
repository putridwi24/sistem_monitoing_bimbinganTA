<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_validator extends CI_Form_validation
{
	protected $CI;

	public function __construct()
	{
		parent::__construct();
		// reference to the CodeIgniter super object
		$this->CI = &get_instance();
	}

	public function min_one_word($str)
	{
		if (preg_match('/\s/', $str)) {
			echo $str;
			return TRUE;
		} else {
			return TRUE;
		}
	}
}
