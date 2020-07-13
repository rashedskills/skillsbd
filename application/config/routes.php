<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['become-an-instructor'] = 'home/become_instructor';
$route['about-us'] = 'home/about_us';
$route['privacy-policy'] = 'home/privacy_policy';
$route['terms-conditions'] = 'home/terms_and_condition';
$route['instructor-terms'] = 'home/instructor_terms';
$route['sign-up'] = 'home/sign_up';
# HOSTED SSLC
$route['requestapih'] = 'home/request_api_hosted';
$route['hosted'] = 'home/hosted_view';
# EASY CHECKOUT SSLC
$route['easycheckout'] = 'home/easycheckout_view';
$route['easyendpoint'] = 'home/easycheckout_endpoint';
# COMMON ROUTE SSLC
$route['success'] = 'home/success_payment';
$route['fail'] = 'home/fail_payment';
$route['cancel'] = 'home/cancel_payment';
$route['ipn'] = 'home/ipn_listener';

$route['404_override'] = 'home/page_not_found';
$route['translate_uri_dashes'] = FALSE;
