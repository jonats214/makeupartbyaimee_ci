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
|	http://codeigniter.com/user_guide/general/routing.html
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

$adminController = false;

if($_SERVER["HTTP_HOST"] == "localhost")
{
    if(($_SERVER["REQUEST_URI"] == "/AVR/myadmin") ||
        ($_SERVER["REQUEST_URI"] == "/AVR/myadmin/")||
        ($_SERVER["REQUEST_URI"] == "/AVR/index.php/myadmin") ||
        ($_SERVER["REQUEST_URI"] == "/AVR/index.php/myadmin/"))
    {
        $adminController = true;
    }
}
else if(($_SERVER["REQUEST_URI"] == "/myadmin") ||
        ($_SERVER["REQUEST_URI"] == "/myadmin/")||
        ($_SERVER["REQUEST_URI"] == "/index.php/myadmin") ||
        ($_SERVER["REQUEST_URI"] == "/index.php/myadmin/"))
{
    $adminController = true;
}

if($adminController==true)
{
    $route['default_controller'] = 'admin/admin/index';
}
else
{
    $route['default_controller'] = 'mainpages/index';
}

unset($adminController);


$route['myadmin'] = 'admin/admin/index';
$route['myadmin/gallery/(:any)/(:num)'] = 'admin/gallery/$1/$2';
$route['myadmin/gallery/(:any)'] = 'admin/gallery/$1';
$route['myadmin/videos/(:any)/(:num)'] = 'admin/videos/$1/$2';
$route['myadmin/videos/(:any)'] = 'admin/videos/$1';
$route['myadmin/works/(:any)/(:num)'] = 'admin/works/$1/$2';
$route['myadmin/works/(:any)'] = 'admin/works/$1';
$route['myadmin/blogs/(:any)/(:num)'] = 'admin/blogs/$1/$2';
$route['myadmin/blogs/(:any)'] = 'admin/blogs/$1';
$route['myadmin/staticblock/(:any)/(:num)'] = 'admin/staticblock/$1/$2';
$route['myadmin/staticblock/(:any)'] = 'admin/staticblock/$1';
$route['myadmin/(:any)'] = 'admin/admin/$1';

$route['videos/(:any)'] = 'videos/$1';
$route['works/(:any)'] = 'works/$1';
$route['blog/(:any)'] = 'blog/$1';
$route['blog'] = 'blog/index';
$route['(:any)'] = 'mainpages/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
