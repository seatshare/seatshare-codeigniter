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
		$data['head'] = sprintf('<meta name="title" content="%s" />', $this->config->item('application_name'));
		$data['head'] .= sprintf('<meta name="description" content="%s is a web-based utility helps manage a shared ticket pool for events, such as a sports team or performing arts venue." />', $this->config->item('application_name'));
		$data['title'] = 'Welcome to ' . $this->config->item('application_name');
		$this->load->view('public/home', $data);
	}
}