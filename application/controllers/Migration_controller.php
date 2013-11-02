<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Controller extends MY_Controller
{
    /**
     * Constructor
     **/
    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_cli_request()) {
            show_error('Must run from command line.' . PHP_EOL);
        }
        $this->layout = false;
        $this->load->library('migration');
    }

    /**
     * Run Migration
     **/
    public function index()
    {
        print 'Starting migration ...' . PHP_EOL;
        if ( ! $this->migration->current()) {
            show_error($this->migration->error_string());
        }
        exit(0);
    }

    /**
     * Version
     */
    public function version($version='')
    {
        if (!$version) {
            die('No version set.' . PHP_EOL);
        }
        print 'Migrating to version ' . $version . ' ...' . PHP_EOL;
        $this->migration->version($version);
    }

}
