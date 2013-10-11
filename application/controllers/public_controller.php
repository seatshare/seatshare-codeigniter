<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Public_Controller extends MY_Controller {

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

	/**
	 * Terms of Service
	 */
	public function tos() {
		$this->layout = 'two_column';
		$data['head'] = '<meta name="title" content="Terms of Service" />';
		$data['head'] .= sprintf('<meta name="description" content="The Terms of Service %s are the rules that govern access and use of the website." />', $this->config->item('application_name'));
		$data['title'] = 'Welcome to ' . $this->config->item('application_name');
		$data['company'] = $this->config->item('application_name');
		$data['application'] = $this->config->item('application_name') . ' (http://' . $_SERVER['HTTP_HOST'] . ')';
		$this->load->view('public/tos', $data);
	}

	/**
	 * Privacy Policy
	 */
	public function privacy() {
		$this->layout = 'two_column';
		$data['head'] = '<meta name="title" content="Privacy Policy" />';
		$data['head'] .= sprintf('<meta name="description" content="%s  values your privacy and will not sell or share your information." />', $this->config->item('application_name'));
		$data['title'] = 'Privacy Policy for ' . $this->config->item('application_name');
		$data['company'] = $this->config->item('application_name');
		$data['address'] = $this->config->item('application_address');
		$data['email'] = $this->config->item('application_email');
		$this->load->view('public/privacy', $data);
	}

}