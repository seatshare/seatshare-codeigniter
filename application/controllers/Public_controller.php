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
        $this->template->setPageTitle('Welcome to SeatShare');
        $this->template->setHead('<meta name="description" content="SeatShare helps you manage your group\'s season tickets for sporting or performing arts events. Sign up for free." />');
        $this->template->setHead('<script>mixpanel.track("View home");</script>');
    }

    /**
     * Terms of Service
     */
    public function tos()
    {
        $this->layout = 'two_column';
        $data['address'] = $this->config->item('application_address');
        $data['email'] = $this->config->item('application_email');
        $this->template->setPageTitle('Terms of Service - SeatShare');
        $this->template->setHead('<meta name="description" content="The Terms of Service for SeatShare are the rules that govern access and use of the website." />');
        $this->template->setHead('<script>mixpanel.track("View terms of service");</script>');
        $this->load->view('public/tos', $data);
    }

    /**
     * Privacy Policy
     */
    public function privacy()
    {
        $this->layout = 'two_column';
        $data['address'] = $this->config->item('application_address');
        $data['email'] = $this->config->item('application_email');
        $this->template->setPageTitle('Privacy Policy - SeatShare');
        $this->template->setHead('<meta name="description" content="SeatShare values your privacy and will not sell or share your information." />');
        $this->template->setHead('<script>mixpanel.track("View privacy policy");</script>');
        $this->load->view('public/privacy', $data);
    }

    /**
     * Privacy Policy
     */
    public function error_404()
    {
        $this->layout = 'two_column';
        $data['sidebar'] = sprintf('<h3>Think this is an error?</h3><p>Please take a moment to <a href="%s">contact us</a>.</p>', site_url('contact'));
        $this->template->setPageTitle('Page Not Found -  SeatShare');
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
        $this->template->setPageTitle('Contact - SeatShare');
        $this->template->setHead('<meta name="description" content="Have questions or comments about SeatShare? We are here to help." />');
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
