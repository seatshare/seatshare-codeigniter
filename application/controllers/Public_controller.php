<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Public_Controller extends MY_Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('email_model');
    }

    /**
     * Welcome
     **/
    public function index()
    {
        $this->layout = 'home';
        if ($this->user_model->isLoggedIn()) {
            redirect('dashboard');
        }
        $data['sidebar'] = $this->load->view('public/_sidebar', null, true);
        $this->template->setPageTitle('Welcome to ' . $this->config->item('application_name'));
        $this->template->setHead(sprintf('<meta name="description" content="%s is a web-based utility helps manage a shared ticket pool for events, such as a sports team or performing arts venue." />', $this->config->item('application_name')));
        $this->template->setHead('<script>mixpanel.track("View home");</script>');
    }

    /**
     * Terms of Service
     */
    public function tos()
    {
        $this->layout = 'two_column';
        $data['company'] = $this->config->item('application_name');
        $data['application'] = $this->config->item('application_name') . ' (http://' . $this->config->item('application_domain') . ')';
        $this->template->setPageTitle('Terms of Service - ' . $this->config->item('application_name'));
        $this->template->setHead(sprintf('<meta name="description" content="The Terms of Service %s are the rules that govern access and use of the website." />', $this->config->item('application_name')));
        $this->template->setHead('<script>mixpanel.track("View terms of service");</script>');
        $this->load->view('public/tos', $data);
    }

    /**
     * Privacy Policy
     */
    public function privacy()
    {
        $this->layout = 'two_column';
        $data['company'] = $this->config->item('application_name');
        $data['address'] = $this->config->item('application_address');
        $data['email'] = $this->config->item('application_email');
        $this->template->setPageTitle('Privacy Policy - ' . $this->config->item('application_name'));
        $this->template->setHead(sprintf('<meta name="description" content="%s  values your privacy and will not sell or share your information." />', $this->config->item('application_name')));
        $this->template->setHead('<script>mixpanel.track("View privacy policy");</script>');
        $this->load->view('public/privacy', $data);
    }

    /**
     * Privacy Policy
     */
    public function error_404()
    {
        $this->layout = 'two_column';
        $data['sidebar'] = '<h3>Think this is an error?</h3><p>Please take a moment to <a href="' . site_url('contact') . '">contact us</a>.</p>';
        $this->template->setPageTitle('Page Not Found - ' . $this->config->item('application_name'));
        $this->template->setFoot('<script>_gaq.push([\'_trackPageview\',\'/404error/?url=\' + document.location.pathname + document.location.search + \'&ref=\' + document.referrer]);</script>');
        $this->load->view('public/404', $data);
    }

    /**
     * Contact
     */
    public function contact()
    {
        $this->layout = 'two_column';
        $data = array();
        if ($this->input->post()) {

            // Spam honeypot field
            if ($this->input->post('url') != '') {
                return;
            }

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('message', 'Message', 'required');
            if ($this->form_validation->run() == true) {
                $this->email_model->sendContactEmail(
                    'Message from ' . $this->input->post('name'),
                    $this->input->post('message'),
                    $this->input->post('name'),
                    $this->input->post('email')
                );
                $data['sent'] = true;
                $this->growl('Message sent!');
            }
        }
        $this->template->setPageTitle('Contact - ' . $this->config->item('application_name'));
        $this->template->setHead(sprintf('<meta name="description" content="Have questions or comments about %s? We are here to help." />', $this->config->item('application_name')));
        $this->template->setHead('<script>mixpanel.track("View contact form");</script>');
        $this->load->view('public/contact_form', $data);
    }

    /**
     * Sitemap
     */
    public function sitemap()
    {
        $this->layout = false;
        header('Content-type: application/xml');
        $this->load->view('public/sitemap');
    }

}
