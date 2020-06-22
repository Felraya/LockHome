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


//https://www.formget.com/form-login-codeigniter/

$route['default_controller'] = 'Accueil/home';
$route['accueil'] = 'Accueil/home';
$route['edit'] = 'Accueil/edit';
$route['edit_profil'] = 'Accueil/edit_profil';

$route['deconnexion'] = 'Authentification/deconnexion';
$route['connexion'] = 'Authentification/connexion';
$route['inscription'] = 'Authentification/inscription';
$route['mot_de_passe_oublie'] = 'Authentification/mot_de_passe_oublie';
$route['nouveau_mot_de_passe/(:any)'] = 'Authentification/nouveau_mot_de_passe/$1';

$route['camera/edit/(:any)'] = 'Camera/edit/$1';
$route['camera/view/(:any)'] = 'Camera/view/$1';
$route['camera/delete/(:any)'] = 'Camera/delete/$1';
$route['camera'] = 'Camera/list';

$route['capteur/edit'] = 'Capteur/edit';
$route['capteur/edit/(:any)'] = 'Capteur/edit/$1';
$route['capteur'] = 'Capteur/list';

$route['profil/new'] = 'Profil/edit';
$route['profil/edit/(:any)'] = 'Profil/edit/$1';
$route['profil'] = 'Profil/list';

$route['resume/show'] = 'Resume/show';
$route['resume/delete/(:any)'] = 'Resume/delete/$1';
$route['resume/list'] = 'Resume/list';
$route['resume'] = 'Resume/list';

$route['api/(:any)/(:any)'] = 'API/init';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
