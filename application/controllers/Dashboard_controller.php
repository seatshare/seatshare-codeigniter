<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_Controller extends MY_Controller
{
    public $layout = 'two_column';

    /**
     * Constructor
     **/
    public function __construct()
    {
        parent::__construct();
        $this->requireLogin();
        $this->requireSSL();
        $this->load->model('group_model');
        $this->load->model('event_model');
        $this->load->model('entity_model');
        $this->load->model('ticket_model');
    }

    /**
     * Welcome
     **/
    public function index()
    {
        $group = $this->current_group;

        // No group associated, take to group page
        if (!is_object($group) || !$group->group_id) {
            redirect('groups');
        }

        // Sanity check to ensure a departed group is not still displayed
        if (!$this->group_model->getGroupById($group->group_id)) {
            redirect('groups');
        }

        $group->administrator = $this->group_model->getGroupAdministratorByGroupId($group->group_id);

        $data['group'] = $group;
        $data['entity'] = $this->entity_model->getEntityByCurrentGroup();
        $data['events'] = $this->event_model->getEvents(array(
            'after' => date('c', strtotime('+1 hour'))
        ));
        $data['summary'] = array();
        $data['group_users'] = $this->group_model->getGroupUsersByGroupId($group->group_id);

        $this->template->setPageTitle('Dashboard');
        $data['sidebar'] = $this->load->view('dashboard/_sidebar', $data, true);
        $data['sidebar'] .= $this->load->view('groups/_invite', $data, true);

        $this->template->setHead('<script>mixpanel.track("View dashboard");</script>');
        $this->template->setHead('<link rel="stylesheet" href="' . site_url('assets/libraries/add-to-homescreen/style/add2home.css') . '">');
        $this->template->setFoot('<script type="application/javascript" src="' . site_url('assets/libraries/add-to-homescreen/src/add2home.js') . '"></script>');
        $this->load->view('dashboard/main', $data);
    }
}
