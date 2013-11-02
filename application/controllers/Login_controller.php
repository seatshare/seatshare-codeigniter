<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_Controller extends MY_Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->layout = 'login';
        $this->load->library('form_validation');
    }

    /**
     * Login
     **/
    public function index()
    {
        if ($this->user_model->isLoggedIn()) {
            redirect('dashboard');
        }

        if ($this->input->get('return')) {
            $this->session->set_userdata('return', $this->input->get('return'));
        }

        if ($this->input->post('username') && $this->input->post('password')) {
            $status = $this->user_model->login(
                $this->input->post('username'),
                $this->input->post('password')
            );
            if ($status) {
                if ($this->session->userdata('return')) {
                    $redirect = urldecode($this->session->userdata('return'));
                    $this->session->unset_userdata('return');
                    redirect($redirect);
                } else {
                    redirect('dashboard');
                }

            } else {
                $this->growl('Login failed. Please try again.', 'error');
                redirect('login');
            }
        }

        $data = array();
        $this->template->setHead(sprintf('<meta name="description" content="Sign in to %s to manage your tickets and groups." />', $this->config->item('application_name')));
        $this->template->setPageTitle('User Login');
        $this->template->setHead('<script>mixpanel.track("View login");</script>');
        $this->load->view('login/login_form', $data);
    }

    /**
     * Logout
     **/
    public function logout()
    {
        $this->session->sess_destroy();
        $this->user_model->logout();
        redirect('login');

    }

    /**
     * Forgot Password
     *
     * @param string $activation_key
     **/
    public function forgot_password($activation_key='')
    {
        if ($this->user_model->isLoggedIn()) {
            redirect('dashboard');
        }

        if ($activation_key) {
            $user = $this->user_model->getUserByActivationKey($activation_key);
            if (!$user->user_id) {
                $this->growl('Invalid password token. Please try again.', 'error');
                redirect('login');
            } else {
                if ($this->input->post()) {
                    $this->form_validation->set_rules('password', 'Password', 'required|matches[password_confirm]');
                    $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

                    if ($this->form_validation->run() == true) {
                        $this->user_model->updatePassword($user->user_id, $this->input->post('password'));
                        $this->user_model->login($user->username, $this->input->post('password'));
                        $this->growl('Your password has been changed.');
                        redirect('dashboard');
                    }
                }
            }

            $data = array();
            $this->template->setPageTitle('Change Password');
            $this->template->setHead('<script>mixpanel.track("View change password");</script>');
            $this->load->view('login/change_password', $data);

        } else {

            if ($this->input->post()) {
                $user = $this->user_model->getUserByEmailAddress($this->input->post('email'));
                if (!$user->user_id) {
                    $this->growl('Could not find a user with that email address.');
                    redirect('login');
                }
                $this->user_model->setPasswordResetKey($user->user_id);
                $this->growl('Your password reset email has been sent.');
                redirect('login');
            }

            $data = array();
            $this->template->setPageTitle('Forgot Password');
            $this->template->setHead(sprintf('<meta name="description" content="Provide your email address or username to %s to reset your password." />', $this->config->item('application_name')));
            $this->template->setHead('<script>mixpanel.track("View forgot password");</script>');
            $this->load->view('login/forgot_password', $data);
        }

    }

}
