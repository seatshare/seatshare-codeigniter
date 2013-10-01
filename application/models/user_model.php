<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends CI_Model {

	public $username;
	public $first_name;
	public $last_name;
	public $email;
	public $public_fields = array('user_id', 'username', 'first_name', 'last_name', 'email', 'status');
	
	/**
	 * Return instance
	 */
	public function instance() {
		return $this;
	}

	/**
	 * Login
	 */
	public function login( $username='', $password='' ) {
		$this->db->select( $this->public_fields );
		$this->db->where('username', $username);
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
	public function getUserById($user_id = 0) {
		$this->db->select( $this->public_fields );
		$query = $this->db->get_where('users', array('user_id' => $user_id), 1);
		return $query->row();
	}
	
	/**
	 * Get User by Username
	 *
	 * @param string $username 
	 */
	public function getUserByUsername($username = null) {
		$this->db->select( $this->public_fields );
		$query = $this->db->get_where('users', array('username' => $username), 1);
		return $query->row();
	}
	
	/**
	 * Update User from POST
	 *
	 * @param string $user_id 
	 */
	public function updateUserFromPost($user_id) {
		$update_user_data = array(
			'display_name' => $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email' => $this->input->post('email')
		);
		$this->db->where('user_id', $user_id);
		$update = $this->db->update('users', $update_user_data);
		
		// Update session information
		if ($update):
			$this->resetSessionData($user_id);
		endif;
		
		return $update;
	}
	
	/**
	 * Update Password from POST
	 *
	 * @param string $user_id 
	 * @return boolean
	 */
	public function updatePasswordFromPost($user_id) {
		$update_user_data = array(
			'password' => md5($this->input->post('password') . $this->config->item('encryption_key'))
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
	public function resetSessionData($user_id) {
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
			'inserted_ts' => date('c')
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
	public function userExists($username = null) {
		$this->db->where('username', $username);
		$query = $this->db->get('users');
		$result = $query->row();
		
		if (isset($result->username) && $result->username == $username):
			return true;
		endif;
		
		return false;
		
	}

	/**
	 * Generate Password Reset Key
	 */
	public function generatePasswordResetKey() {
		$this->load->helper('string');
		return sprintf('%s-%d', random_string('alnum', 16), time());
	}

	/**
	 * Set Password Reset Key
	 *
	 * @param string $username 
	 */
	public function setPasswordResetKey($username = '') {
		$user = $this->getUserByUsername($username);
		if (!$user)
			return false;
		
		// Generate and set the password reset key
		$activation_key = $this->generatePasswordResetKey();
		$this->db->where('user_id', $user->id);
		$user_data['activation_key'] = $activation_key;
		$this->db->update('users', $user_data);
		
		// Assemble information to return to controller
		$data['user'] = $user;
		$data['activation_key'] = $activation_key;
		
		return $data;
		
	}

	/**
	 * Use Password Reset Key
	 *
	 * @param string $username 
	 * @param string $activation_key 
	 */
	public function usePasswordResetKey($username = '', $activation_key = '') {

		if (!$activation_key)
			return false;

		$this->db->where('username', $username);
		$this->db->where('activation_key', $activation_key);
		$query = $this->db->get('users');
		$user = $query->row();
		
		if (!$user)
			return false;
		
		// Remove activation key data
		$this->db->where('user_id', $user->id);
		$user_data['activation_key'] = null;
		$this->db->update('users', $user_data);
		
		// Prevent keys from being permanently available
		$ts = explode('-', $activation_key);
		if (time()-3600 > $ts[1])
			show_error('Activation key expired. Please request a new key.');

		$this->resetSessionData($user->id);
		
		return true;

	}

	/* ***** Site Administrator Methods ***** */
	
	/**
	 * Is Admin Check
	 */
	public function isAdmin() {
		$user = unserialize($this->session->userdata('user'));
		if ($user->level != 'admin')
			return false;
		else
			return true;
	}
	
	/**
	 * Admin: Get All USers
	 *
	 * @param string $status 
	 * @param string $limit 
	 * @param string $offset 
	 */
	public function adminGetAllUsers($status = true, $limit = 50, $offset = 0) {
		if (!$this->isAdmin())
			show_error('Access denied.');
		
		$this->db->select(array('users.id', 'username', 'display_name', 'first_name', 'last_name', 'email', 'level', 'package_id AS package', 'count(foursquare_checks.id) AS check_count', 'users.insert_ts'));
		$this->db->join('foursquare_checks', 'foursquare_checks.user_id = users.id', 'left');
		$this->db->where('status', ($status == true) ? 1 : 0);
		$this->db->group_by('users.id');
		$this->db->order_by('insert_ts', 'DESC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get('users');
		
		return $query->result();
	}

	/**
	 * Admin: Update User Status
	 *
	 * @param string $user_id 
	 * @param string $status 
	 */
	public function adminUpdateUserStatus($user_id, $status = 0) {
		if (!$this->isAdmin())
			show_error('Access denied.');
		
		$this->db->where('user_id', $user_id);
		$status_data = array(
			'status' => ($status == 1) ? 1 : 0
		);
		$status = $this->db->update('users', $status_data);
		
		return $status;
	}
	
	/**
	 * Admin: Change User Package
	 *
	 * @param string $user_id 
	 * @param string $package_id 
	 */
	public function adminchangeUserPackage($user_id, $package_id) {
		$user = $this->getUserById($user_id);
		if (!$user)
			show_error('Could not locate user record', 404);

		// Process update
		$user_update_data = array(
			'package_id' => $package_id
		);
		$this->db->where('user_id', $user->id);
		$this->db->update('users', $user_update_data);
	}
	
	/**
	 * Admin: Assume User
	 *
	 * @param string $user_id 
	 */
	public function adminAssumeUser($user_id) {
		if (!$this->isAdmin())
			show_error('Access denied.');
		
		// Load user record
		$user = $this->getUserById($user_id);
		if (!$user)
			show_error('Could not locate user record', 404);
		$this->session->set_userdata('admin_user_tmp', $this->session->userdata('user'));
		$this->session->unset_userdata('user');
		$this->session->set_userdata('user', serialize($user));
		
		return $user;
	}
	
	/**
	 * Admin: Resume Admin
	 */
	public function adminResumeAdmin() {
		
		// Pull Admin data out of temporary session store
		$user = unserialize($this->session->userdata('admin_user_tmp'));
		if (!$user)
			show_error('Could not resume admin session.', 500);

		$this->session->unset_userdata('admin_user_tmp');
		$this->session->unset_userdata('user');
		$this->session->set_userdata('user', serialize($user));
	}


}