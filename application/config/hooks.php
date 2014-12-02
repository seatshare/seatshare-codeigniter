<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files. Please see the user guide for info:
|
| http://codeigniter.com/user_guide/general/hooks.html
|
*/

/* Yield is a RoR-like method of allowing a layout to be set */
$hook['display_override'][] = array('class' => 'Yielder',
                                    'function' => 'doYield',
                                    'filename' => 'Yielder.php',
                                    'filepath' => 'hooks'
                                   );

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */