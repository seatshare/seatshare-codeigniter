<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_Controller extends MY_Controller {

	/**
	 * Welcome
	 **/
	public function index() {
		$this->layout = 'two_column';
		if ($this->user_model->isLoggedIn()) {
			redirect('dashboard');
		}
		$data['sidebar'] = $this->load->view('public/_sidebar', null, true);
		$data['title'] = $this->config->item('application_name');
		$this->load->view('public/home', $data);
	}
}