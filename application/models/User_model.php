<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class User_Model extends CI_Model {

	public $public_fields = array( 'user_id', 'username', 'first_name', 'last_name', 'email', 'activation_key', 'status', 'inserted_ts' );

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model( 'email_model' );
	}

	/**
	 * Login
	 *
	 * @param string  $username
	 * @param string  $password
	 * @return boolean
	 */
	public function login( $username='', $password='' ) {
		$this->db->select( $this->public_fields );
		$this->db->where( sprintf('(username = %s OR email = %s)', $this->db->escape($username), $this->db->escape($username)));
		$this->db->where( 'password', md5( $password . $this->config->item( 'encryption_key' ) ) );
		$this->db->where( 'status', 1 );
		$query = $this->db->get( 'users' );

		// If valid, set 'user' session variable. If not, clear it.
		if ( $query->num_rows() === 1 ):
			$user_record = $query->result();
			$this->session->set_userdata( 'user', serialize( array_shift( $user_record ) ) );
		return true;
		else:
			$this->session->unset_userdata( 'user' );
		return false;
		endif;
	}

	/**
	 * Logout
	 *
	 * @return boolean
	 */
	public function logout() {
		$this->session->unset_userdata( 'user' );
		return true;
	}

	/**
	 * Is Logged In
	 *
	 * @return boolean
	 */
	public function isLoggedIn() {
		$user = unserialize( $this->session->userdata( 'user' ) );
		if ( !$user )
			return false;
		else
			return true;
	}

	/**
	 * Current User
	 *
	 * @return object $user
	 */
	public function getCurrentUser() {
		$user = unserialize( $this->session->userdata( 'user' ) );
		return $user;
	}

	/**
	 * Get User By ID
	 *
	 * @param string  $user_id
	 * @return object
	 */
	public function getUserById( $user_id=0 ) {
		$this->db->select( $this->public_fields );
		$query = $this->db->get_where( 'users', array( 'user_id' => $user_id ), 1 );
		
		$user = $query->row();
		$user->name = $user->first_name . ' ' . $user->last_name;
		return $user;
	}

	/**
	 * Get User by Username
	 *
	 * @param string  $username
	 * @return object
	 */
	public function getUserByUsername( $username='' ) {
		$this->db->select( $this->public_fields );
		$query = $this->db->get_where( 'users', array( 'username' => $username ), 1 );
		
		$user = $query->row();
		$user->name = $user->first_name . ' ' . $user->last_name;
		return $user;
	}


	/**
	 * Get User by Email
	 *
	 * @param string  $email
	 * @return object
	 */
	public function getUserByEmailAddress( $email='' ) {
		$this->db->select( $this->public_fields );
		$query = $this->db->get_where( 'users', array( 'email' => $email ), 1 );
		
		$user = $query->row();
		$user->name = $user->first_name . ' ' . $user->last_name;
		return $user;
	}

	/**
	 * Get User by Activation Key
	 *
	 * @param string  $activation_key
	 * @return object
	 */
	public function getUserByActivationKey( $activation_key='' ) {
		$this->db->select( $this->public_fields );
		$query = $this->db->get_where( 'users', array( 'activation_key' => $activation_key ), 1 );
		
		$user = $query->row();
		$user->name = $user->first_name . ' ' . $user->last_name;
		return $user;
	}

	/**
	 * Update User
	 *
	 * @param object $user
	 * @return boolean
	 */
	public function updateUser( $user=null ) {
		if (!is_object($user)) {
			return false;
		}
		$user->updated_ts = date('Y-m-d H:i:s',now());
		$this->db->where( 'user_id', $user->user_id );
		$update = $this->db->update( 'users', $user );

		// Update session information
		if ( $update ) {
			$this->resetSessionData( $user->user_id );
		}

		return $update;
	}

	/**
	 * Update Password
	 *
	 * @param int     $user_id
	 * @param string  $password
	 * @return boolean
	 */
	public function updatePassword( $user_id=0, $password='' ) {
		if ( !$user_id ) {
			return false;
		}
		$update_user_data = array(
			'updated_ts' => now(),
			'password' => md5( $password . $this->config->item( 'encryption_key' ) ),
			'activation_key' => ''
		);
		$this->db->where( 'user_id', $user_id );
		$update = $this->db->update( 'users', $update_user_data );

		return $update;
	}

	/**
	 * Reset Session Data
	 *
	 * @param string  $user_id
	 * @return boolean
	 */
	public function resetSessionData( $user_id=0 ) {
		$user = $this->getUserById( $user_id );
		$this->session->unset_userdata( 'user' );
		$this->session->set_userdata( 'user', serialize( $user ) );
		return true;
	}

	/**
	 * Create New User from POST
	 *
	 * @param mixed   $user
	 * @return boolean
	 */
	public function createUser( $user=null ) {
		$user->inserted_ts = date('Y-m-d H:i:s', now());
		$user->updated_ts = date('Y-m-d H:i:s', now());
		$user->status = 1;
		$insert = $this->db->insert( 'users', $user );

		// Authenticate the user
		if ( $insert ) {
			$this->resetSessionData( $this->db->insert_id() );
		}

		return true;
	}

	/**
	 * User Exists
	 *
	 * @param string  $username
	 * @return boolean
	 */
	public function userExists( $username=null ) {
		$this->db->where( 'username', $username );
		$query = $this->db->get( 'users' );
		$result = $query->row();

		if ( isset( $result->username ) && $result->username == $username ) {
			return true;
		}

		return false;

	}

	/**
	 * Set Password Reset Key
	 *
	 * @param int     $user_id
	 * @return boolean
	 */
	public function setPasswordResetKey( $user_id=0 ) {
		$user = $this->getUserById( $user_id );
		if ( !$user ) {
			return false;
		}

		// Generate and set the password reset key
		$user->activation_key = $this->generatePasswordResetKey();
		$this->db->where( 'user_id', $user->user_id );
		$user_data['updated_ts'] = date('Y-m-d H:i:s',now());
		$user_data['activation_key'] = $user->activation_key;
		$this->db->update( 'users', $user_data );

		// Send an email to the user
		$this->email_model->sendPasswordReset( $user );

		return true;
	}

	public function getAliasesByUserId($user_id=0) {
		$this->db->where('user_id', $user_id);
		$this->db->order_by('last_name', 'ASC');
		$this->db->order_by('first_name', 'ASC');
		$query = $this->db->get('user_aliases');
		$alias_records = $query->result();
		$aliases = array();
		foreach ($alias_records as $k => $row) {
			$aliases[$k] = $row;
			$aliases[$k]->name = $row->first_name . ' ' . $row->last_name;
		}
		return $aliases;
	}

	/**
	 * Get Alias By ID
	 */
	public function getAliasById($alias_id=0) {
		$query = $this->db->get_where( 'user_aliases', array( 'alias_id' => $alias_id ), 1 );
		$alias = $query->row();
		$alias->name = $alias->first_name . ' ' . $alias->last_name;
		return $alias;
	}

	/**
	 * Add Alias
	 */
	public function createAlias($alias=null) {
		$alias->inserted_ts = date('Y-m-d H:i:s',now());
		$alias->updated_ts = date('Y-m-d H:i:s',now());
		$this->db->insert('user_aliases', $alias);
		return true;
	}

	/**
	 * Update Alias
	 */
	public function updateAlias($alias=null) {
		if (!is_object($alias)) {
			return false;
		}
		$alias->updated_ts = date('Y-m-d H:i:s',now());
		$this->db->where( 'alias_id', $alias->alias_id );
		$update = $this->db->update( 'user_aliases', $alias );

		return $update;
	}

	/**
	 * Delete Alias
	 */
	public function deleteAlias($alias_id=0) {
		// Unassign any tickets with alias_id
		$this->db->where('alias_id', $alias_id);
		$ticket_data['alias_id'] = 0;
		$this->db->update('tickets', $ticket_data);

		// Delete the record
		$this->db->where('alias_id', $alias_id);
		$this->db->delete('user_aliases');
	}

	/* Private Methods */

	/**
	 * Generate Password Reset Key
	 *
	 * @return string
	 */
	private function generatePasswordResetKey() {
		$this->load->helper( 'string' );
		return sprintf( '%s-%d', random_string( 'alnum', 16 ), time() );
	}

}
