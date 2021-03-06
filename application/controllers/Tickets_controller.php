<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tickets_Controller extends MY_Controller
{
    /**
     * Constructor
     **/
    public function __construct()
    {
        parent::__construct();
        $this->layout = 'two_column';
        $this->requireLogin();
        $this->requireSSL();
        $this->load->library('form_validation');
        $this->load->model('ticket_model');
        $this->load->model('event_model');
        $this->load->model('email_model');
    }

    /**
     * Return to Dashboard
     **/
    public function index()
    {
        redirect('dashboard');
    }

    /**
     * Ticket Detail
     *
     * @param int $ticket_id
     **/
    public function ticket($ticket_id=0)
    {
        $group_id = $this->current_group->group_id;
        $ticket = $this->ticket_model->getTicketById($ticket_id, $group_id);
        $event = $this->event_model->getEventById($ticket->event_id);
        $group_users_objects = $this->group_model->getGroupUsersByGroupId($group_id);
        $user_alias_objects = $this->user_model->getAliasesByUserId($this->current_user->user_id);
        $history = $this->ticket_model->getTicketHistoryById($ticket_id);
        $can_edit = (bool) ($ticket->owner_id == $this->current_user->user_id || $ticket->user_id == $this->user_model->current_user->user_id);

        if (!is_object($ticket) || !$ticket->event_id) {
            $this->growl('Could not load specified ticket.', 'error');
            redirect('dashboard');
        }

        if ($ticket->group_id != $this->current_group->group_id) {
            $this->growl('Access denied.', 'error');
            redirect('dashboard');
        }

        // Updating a ticket
        if ($this->input->post() && $can_edit) {

            $this->form_validation->set_rules('cost', 'Cost', 'decimal');

            if ($this->form_validation->run() == true) {

                $this->ticket_model->updateTicket(array(
                    'ticket_id' => $ticket->ticket_id,
                    'user_id' => $this->input->post('assigned'),
                    'cost' => (float) $this->input->post('cost'),
                    'alias_id' => (float) $this->input->post('alias'),
                    'note' => $this->input->post('note')
                ));

                // Process file submit
                $this->_uploadTicket((array) $ticket);

                // Send email if assignee changed
                if ($ticket->user_id != $this->input->post('assigned') && $this->input->post('assigned') != '0' && $this->input->post('assigned') != $this->current_user->user_id) {
                    $ticket->user_id = $this->input->post('assigned');
                    $this->ticket_model->log('assigned', $ticket);
                    $recipient = $this->user_model->getUserById($this->input->post('assigned'));
                    $this->email_model->sendAssign($recipient, $ticket);
                    $this->growl('Ticket assigned!');
                // Show that ticket was unassigned
                } elseif ($ticket->user_id != $this->input->post('assigned') && $this->input->post('assigned') == '0') {
                    $ticket->user_id = $this->input->post('assigned');
                    $this->ticket_model->log('unassigned', $ticket);
                    $this->growl('Ticket unassigned!');
                // Show an update to the ticket
                } else {
                    $this->ticket_model->log('updated', $ticket);
                    $ticket->user_id = $this->input->post('assigned');
                    $this->growl('Ticket updated!');
                }

                redirect('events/event/' . $ticket->event_id);
            }
        }

        $group_users['0'] = 'Unassigned';
        foreach ($group_users_objects as $row) {
            $group_users[$row->user_id] = $row->name;
        }

        $user_aliases['0'] = '';
        foreach ($user_alias_objects as $row) {
            $user_aliases[$row->alias_id] = $row->name;
        }

        $data['group_users'] = $group_users;
        $data['user_aliases'] = $user_aliases;
        $data['event'] = $event;
        $data['ticket'] = $ticket;
        $data['history'] = $history;
        $data['can_edit'] = $can_edit;
        $data['current_user_id'] = $this->current_user->user_id;

        $data['sidebar'] = $this->load->view('tickets/_history', $data, true);
        $this->template->setPageTitle(sprintf('%s - %s %s %s', $event->event, $ticket->section, $ticket->row, $ticket->seat));
        $this->template->setHead('<script>mixpanel.track("View ticket");</script>');
        $this->load->view('tickets/ticket_detail', $data);

    }

    /**
     * Create Ticket
     *
     * @param int $event_id
     **/
    public function create($event_id=0)
    {
        $event = $this->event_model->getEventById($event_id);
        if (!$event) {
            redirect('dashboard');
        }

        // Process submitted ticket
        if ($this->input->post()) {
            $this->form_validation->set_rules('section', 'Section', 'required');
            $this->form_validation->set_rules('row', 'Row', 'required');
            $this->form_validation->set_rules('seat', 'Seat', 'required');
            $this->form_validation->set_rules('cost', 'Cost', 'decimal');

            if ($this->form_validation->run() == true) {
                $ticket = array(
                    'event_id' => $event->event_id,
                    'section' => $this->input->post('section'),
                    'row' => $this->input->post('row'),
                    'seat' => $this->input->post('seat'),
                    'cost' => $this->input->post('cost'),
                    'user_id' => $this->input->post('assigned')
                );

                $ticket['ticket_id'] = $this->ticket_model->createTicket($ticket);

                // Process file submit
                $this->_uploadTicket($ticket);

                $this->ticket_model->log('created', $ticket);
                redirect('events/event/' . $event_id);
            }
        }

        $group_id = $this->current_group->group_id;
        $group_users = $this->group_model->getGroupUsersAsArray($group_id);

        $data['event'] = $event;
        $data['group_users'] = $group_users;
        $data['assigned'] = $this->current_user;
        $this->template->setPageTitle('Add Ticket - ' . $event->event);
        $this->template->setHead('<script>mixpanel.track("View create single ticket");</script>');
        $this->load->view('tickets/new_ticket', $data);
    }

    /**
     * Create Season Ticket
     **/
    public function create_season()
    {
        $group_id = $this->current_group->group_id;
        $group_users = $this->group_model->getGroupUsersAsArray($group_id);
        $events = $this->event_model->getEvents(array(
            'after' => date('c', strtotime('+1 hour'))
        ));

        // Process submitted ticket
        if ($this->input->post()) {
            $this->form_validation->set_rules('section', 'Section', 'required');
            $this->form_validation->set_rules('row', 'Row', 'required');
            $this->form_validation->set_rules('seat', 'Seat', 'required');
            $this->form_validation->set_rules('cost', 'Cost', 'decimal');

            if ($this->form_validation->run() == true) {

                foreach ($this->input->post('events') as $event_id) {
                    $ticket = array(
                        'event_id' => $event_id,
                        'section' => $this->input->post('section'),
                        'row' => $this->input->post('row'),
                        'seat' => $this->input->post('seat'),
                        'cost' => $this->input->post('cost'),
                        'user_id' => $this->input->post('assigned')
                    );
                    $ticket['ticket_id'] = $this->ticket_model->createTicket($ticket);
                    $this->ticket_model->log('created', $ticket);
                }
                redirect('dashboard');
            }
        }

        $data['group_users'] = $group_users;
        $data['assigned'] = $this->current_user;
        $data['events'] = $events;
        $this->template->setPageTitle('Add Season Ticket');
        $this->template->setHead('<script>mixpanel.track("View create season ticket");</script>');
        $this->load->view('tickets/new_season_ticket', $data);
    }

    /**
     * Unassign a Ticket
     **/
    public function unassign($ticket_id=0)
    {
        $group_id = $this->current_group->group_id;
        $ticket = $this->ticket_model->getTicketById($ticket_id, $group_id);

        if (!is_object($ticket) || !$ticket->event_id) {
            redirect('dashboard');
        }

        $this->ticket_model->unassignTicket($ticket->ticket_id);
        $this->ticket_model->log('unassigned', $ticket);

        redirect('events/event/' . $ticket->event_id);
    }

    /**
     * Delete Ticket
     *
     * @param int $ticket_id
     **/
    public function delete($ticket_id=0)
    {
        $ticket = $this->ticket_model->getTicketById($ticket_id);

        if (!is_object($ticket) || !$ticket->event_id) {
            redirect('dashboard');
        }

        $this->ticket_model->deleteTicket($ticket->ticket_id);
        $this->ticket_model->log('deleted', $ticket);

        redirect('events/event/' . $ticket->event_id);
    }

    /**
     * Request a Ticket
     *
     * @param int $ticket_id
     **/
    public function request($ticket_id=0)
    {
        $group_id = $this->current_group->group_id;
        $ticket = $this->ticket_model->getTicketById($ticket_id, $group_id);
        $event = $this->event_model->getEventById($ticket->event_id);
        $history = $this->ticket_model->getTicketHistoryById($ticket_id);

        if (!is_object($ticket) || !$ticket->event_id) {
            redirect('dashboard');
        }

        if ($this->input->post()) {
            $recipient = $this->user_model->getUserById($ticket->owner_id);
            $personalized = $this->input->post('message');
            $this->email_model->sendRequest($recipient, $ticket, $personalized);
            $this->ticket_model->log('requested', (array) $ticket);
        }

        $this->growl('Ticket request sent!');
        redirect('tickets/ticket/' . $ticket->ticket_id);
    }

    /**
     * Delete File
     *
     * @param int $file_id
     */
    public function deletefile($file_id=0) {
        $group_id = $this->current_group->group_id;
        $file = $this->ticket_model->getTicketFileById($file_id);
        $ticket = $this->ticket_model->getTicketById($file->ticket_id, $group_id);

        // Only allow authorized user to delete files
        if (!is_object($ticket) || ($ticket->user_id != $this->current_user->user_id && $ticket->owner_id != $this->current_user->user_id)) {
            redirect('dashboard');
        }

        // Delete ticket file
        try { 
            $this->ticket_model->deleteTicketFile($file_id);
        } catch (Exception $e) {
            $this->growl($this->getMessage(), 'error');
        }

        $this->ticket_model->log('removed file', $ticket);

        redirect('tickets/ticket/' . $ticket->ticket_id);


    }

    /* Private Methods */

    /**
     * Upload Ticket
     */
    private function _uploadTicket($ticket=array()) {

        $config['upload_path'] = APPPATH . '/cache/tickets/';
        $config['allowed_types'] = 'gif|jpg|png|pdf|doc';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload('ticket_file')) {
            return false;
        } else {
            $file = $this->upload->data();
            $file['user_id'] = (int) $ticket['user_id'];
            $file['ticket_id'] = (int) $ticket['ticket_id'];
            try {
                $this->ticket_model->addTicketFile($file);
            } catch (Exception $e) {
                $this->growl($e->getMessage());
                return false;
            }

            $this->ticket_model->log('attached file', $ticket);

            return true;
        }
    }

}
