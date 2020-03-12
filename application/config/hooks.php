<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['pre_controller'] = array(
                                'class'    => 'theme_controller',
                                'function' => 'generate_constant',
                                'filename' => 'theme_controller.php',
                                'filepath' => 'hooks'
                                );

$hook['post_controller'][] = array(
                                'class'    => 'authorize_hook',
                                'function' => 'check_login',
                                'filename' => 'authorize_hook.php',
                                'filepath' => 'hooks'
                                );

$hook['post_controller'][] = array(
                                'class'    => 'theme_controller',
                                'function' => 'render_html',
                                'filename' => 'theme_controller.php',
                                'filepath' => 'hooks'
                                );