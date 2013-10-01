<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_Controller extends MY_Controller {

	/**
	 * Welcome
	 **/
	public function index()
	{
		if ($this->user_model->isLoggedIn()) {
			redirect('dashboard');
		}
		$data['title'] = $this->config->item('application_name');
		$this->load->view('welcome_message', $data);
	}
}