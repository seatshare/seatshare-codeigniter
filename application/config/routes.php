<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/


// Miscellaneous
$route['logout'] = 'login_controller/logout'; 
$route['user/([a-zA-z0-9_\-\.]+)'] = 'profile_controller/view/$1';

// Public routes
$route['tos'] = 'public_controller/tos';
$route['privacy'] = 'public_controller/privacy';

// Patches routing to allow for *_controller naming convention
$route['([a-z]+)'] = '$1_controller/index';
$route['([a-z_\-]+)/([a-z_\-]+)'] = '$1_controller/$2';
$route['([a-z_\-]+)/([a-z_\-]+)/([a-zA-z0-9_\-\.]+)'] = '$1_controller/$2/$3';

$route['default_controller'] = "public_controller";
$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */