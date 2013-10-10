<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends CI_Model {

	public $public_fields = array('user_id', 'username', 'first_name', 'last_name', 'email', 'activation_key', 'status', 'inserted_ts');

	/**
	 * Constructor
	 **/
	public function __construct() {
		parent::__construct();
		$this->load->model('email_model');
	}

	/**
	 * Login
	 */
	public function login( $username='', $password='' ) {
		$this->db->select( $this->public_fields );
		$this->db->where(sprintf('(username = "%s" OR email = "%s")', $username, $username));
		$this->db->where('password', md5($password . $this->config->item('encryption_key')));
		$this->db->where('status', 1);
		$query = $this->db->get('users');
		
		// If valid, set 'user' session variable. If not, clear it.
		if($query->num_rows == 1):
			$this->session->set_userdata('user', serialize(array_shift($query->result())));
			return true;
		else:
			$this->session->unset_userdata('user');
			return false;
		endif;
	}
	
	/**
	 * Logout
	 */
	public function logout() {
		$this->session->unset_userdata('user');
		return true;
	}
	
	/**
	 * Is Logged In
	 */
	public function isLoggedIn() {
		$user = unserialize($this->session->userdata('user'));
		if (!$user)
			return false;
		else
			return true;
	}
	
	/**
	 * Current User
	 */
	public function getCurrentUser() {
		$user = unserialize($this->session->userdata('user'));
		return $user;
	}

	/**
	 * Get User By ID
	 *
	 * @param string $user_id 
	 */
	public function getUserById($user_id=0) {
		$this->db->select( $this->public_fields );
		$query = $this->db->get_where('users', array('user_id' => $user_id), 1);
		return $query->row();
	}
	
	/**
	 * Get User by Username
	 *
	 * @param string $username 
	 */
	public function getUserByUsername($username='') {
		$this->db->select( $this->public_fields );
		$query = $this->db->get_where('users', array('username' => $username), 1);
		return $query->row();
	}
	

	/**
	 * Get User by Email
	 *
	 * @param string $email 
	 */
	public function getUserByEmailAddress($email='') {
		$this->db->select( $this->public_fields );
		$query = $this->db->get_where('users', array('email' => $email), 1);
		return $query->row();
	}

	/**
	 * Get User by Activation Key
	 *
	 * @param string $activation_key 
	 */
	public function getUserByActivationKey($activation_key='') {
		$this->db->select( $this->public_fields );
		$query = $this->db->get_where('users', array('activation_key' => $activation_key), 1);
		return $query->row();
	}

	/**
	 * Update User from POST
	 *
	 * @param string $user_id 
	 */
	public function updateUserFromPost() {
		$user_id = $this->getCurrentUser()->user_id;
		$update_user_data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email' => $this->input->post('email'),
			'username' => $this->input->post('username'),
			'activation_key' => ''
		);
		$this->db->where('user_id', $user_id);
		$update = $this->db->update('users', $update_user_data);
		
		// Update session information
		if ($update) {
			$this->resetSessionData($user_id);
		}
		
		return $update;
	}
	
	/**
	 * Update Password
	 *
	 * @param int $user_id 
	 * @param string $password
	 */
	public function updatePassword($user_id=0, $password='') {
		if (!$user_id) {
			return false;
		}
		$update_user_data = array(
			'password' => md5($password . $this->config->item('encryption_key')),
			'activation_key' => ''
		);
		$this->db->where('user_id', $user_id);
		$update = $this->db->update('users', $update_user_data);
		
		return $update;
	}

	/**
	 * Reset Session Data
	 *
	 * @param string $user_id 
	 */
	public function resetSessionData($user_id=0) {
		$user = $this->getUserById($user_id);
		$this->session->unset_userdata('user');
		$this->session->set_userdata('user', serialize($user));
	}
	
	/**
	 * Create New User from POST
	 *
	 * @return $user
	 */
	public function createNewUserFromPost() {
		$insert_user_data = array(
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password') . $this->config->item('encryption_key')),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email' => $this->input->post('email'),
			'status' => 1,
			'inserted_ts' => date('Y-m-d h:i:s')
		);
		
		$insert = $this->db->insert('users', $insert_user_data);
		
		// Authenticate the user
		if ($insert):
			$this->resetSessionData($this->db->insert_id());
		else:
			show_eror('User registration failed.', 500);
		endif;
		
		return true;
	}
	
	/**
	 * User Exists
	 *
	 * @param string $username 
	 * @return boolean
	 */
	public function userExists($username=null) {
		$this->db->where('username', $username);
		$query = $this->db->get('users');
		$result = $query->row();
		
		if (isset($result->username) && $result->username == $username):
			return true;
		endif;
		
		return false;
		
	}

	/**
	 * Set Password Reset Key
	 *
	 * @param string $username 
	 */
	public function setPasswordResetKey($user_id=0) {
		$user = $this->getUserById($user_id);
		if (!$user) {
			return false;
		}
		
		// Generate and set the password reset key
		$user->activation_key = $this->generatePasswordResetKey();
		$this->db->where('user_id', $user->user_id);
		$user_data['activation_key'] = $user->activation_key;
		$this->db->update('users', $user_data);
		
		// Send an email to the user
		$this->email_model->sendPasswordReset($user);

		return true;
	}

	/* Private Methods */

	/**
	 * Generate Password Reset Key
	 */
	private function generatePasswordResetKey() {
		$this->load->helper('string');
		return sprintf('%s-%d', random_string('alnum', 16), time());
	}


}