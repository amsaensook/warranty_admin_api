<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

// Auth API Routes
$route['login'] = 'api/auth/login';
$route['logout'] = 'api/auth/logout';
$route['validate_token'] = 'api/auth/validate_token';
$route['refresh_token'] = 'api/auth/refresh_token';

// User API Routes
$route['user'] = 'api/user/index';
//$route['user/:(any)'] = 'api/user/show/$1';
$route['create_user'] = 'api/user/create';
$route['update_user'] = 'api/user/update';
$route['delete_user'] = 'api/user/delete';

// Menu API Routes
$route['menu'] = 'api/menu/index';
//$route['menu/:(any)'] = 'api/menu/show/$1';
$route['create_menu'] = 'api/menu/create';
$route['update_menu'] = 'api/menu/update';
$route['delete_menu'] = 'api/menu/delete';
$route['parent_menu'] = 'api/menu/parent';

// Menu Type API Routes
$route['menu_type'] = 'api/MenuType/index';
//$route['menu_type/:(any)'] = 'api/MenuType/show/$1';

// Platform API Routes
$route['platform'] = 'api/platform/index';
//$route['platform/:(any)'] = 'api/platform/show/$1';

// Group API Routes
$route['group'] = 'api/group/index';
//$route['group/:(any)'] = 'api/group/show/$1';
$route['create_group'] = 'api/group/create';
$route['update_group'] = 'api/group/update';
$route['delete_group'] = 'api/group/delete';

// Grade API Routes
$route['grade'] = 'api/grade/index';
//$route['grade/:(any)'] = 'api/grade/show/$1';
$route['create_grade'] = 'api/grade/create';
$route['update_grade'] = 'api/grade/update';
$route['delete_grade'] = 'api/grade/delete';

// Bom API Routes
$route['bom'] = 'api/bom/index';
$route['bom/:(any)'] = 'api/bom/show/$1';
$route['create_bom'] = 'api/bom/create';
$route['update_bom'] = 'api/bom/update';
$route['delete_bom'] = 'api/bom/delete';
$route['bom_item'] = 'api/bom/bomitem';

// SKUMapping API Routes
$route['skumapping'] = 'api/skumapping/index';
$route['skumapping/:(any)'] = 'api/skumapping/show/$1';
$route['create_skumapping'] = 'api/skumapping/create';
$route['update_skumapping'] = 'api/skumapping/update';
$route['delete_skumapping'] = 'api/skumapping/delete';
$route['skumapping_item'] = 'api/skumapping/skumappingitem';

// Grade FG  API Routes
$route['grade_fg'] = 'api/GradeFG/index';

// Grade Package  API Routes
$route['grade_package'] = 'api/GradePackage/index';

// Grade SP  API Routes
$route['grade_sp'] = 'api/GradeSP/index';

// Grade All API Routes
$route['grade_all'] = 'api/GradeAll/index';

// BOMID API Routes
$route['bomid'] = 'api/bomid/index';

//Receive Type  API Routes
$route['receive_type'] = 'api/ReceiveType/index';

//Request Type  API Routes
$route['request_type'] = 'api/RequestType/index';

// Receive Part API Routes
$route['jobpacking'] = 'api/jobpacking/index';
$route['jobpacking/:(any)'] = 'api/jobpacking/show/$1';
$route['create_jobpacking'] = 'api/jobpacking/create';
$route['update_jobpacking'] = 'api/jobpacking/update';
$route['delete_jobpacking'] = 'api/jobpacking/delete';
$route['jobpacking_item'] = 'api/jobpacking/jobpackingitem';
$route['create_qrcode'] = 'api/jobpacking/createqrcode';
$route['clear_qrcode'] = 'api/jobpacking/clearqrcode';


//Job Type  API Routes
$route['job_type'] = 'api/jobType/index';

//Job No  API Routes
$route['job_no'] = 'api/JobNo/index';



// Product Type  API Routes
$route['producttype'] = 'api/ProductType/index';

// Location  API Routes
$route['location'] = 'api/Location/index';

//Location Team  API Routes
$route['location_team'] = 'api/LocationTeam/index';


// Permission API Routes
$route['permission'] = 'api/permission/index';
$route['create_permission'] = 'api/permission/create';


// URL QR Code API Routes
$route['url_qrcode'] = 'api/URLQrCode/index';

// Tag API Routes
$route['tag'] = 'api/tag/index';
$route['tag/:(any)'] = 'api/tag/show/$1';
$route['select_receivestatus'] = 'api/tag/selectreceivestatus';
$route['select_tag'] = 'api/tag/select';;


// Reprint API Routes
$route['reprintqrcode'] = 'api/reprint/qrcode';


// Province  API Routes
$route['province'] = 'api/Province/index';
// Province M API Routes
$route['provinceM'] = 'api/ProvinceM/index';

// District  API Routes
$route['district'] = 'api/District/index';
// District M API Routes
$route['districtM'] = 'api/DistrictM/index';

// Subdistrict  API Routes
$route['subdistrict'] = 'api/Subdistrict/index';
// Subdistrict  API Routes
$route['subdistrictM'] = 'api/SubdistrictM/index';


// Customer API Routes
$route['customer'] = 'api/Customer/index';
$route['create_customer'] = 'api/Customer/create';
$route['update_customer'] = 'api/Customer/update';
$route['delete_customer'] = 'api/Customer/delete';


//Customer No  API Routes
$route['customer_no'] = 'api/CustomerNo/index';

// Project API Routes
$route['project'] = 'api/Project/index';
$route['create_project'] = 'api/Project/create';
$route['update_project'] = 'api/Project/update';
$route['delete_project'] = 'api/Project/delete';

// RegisterProduct API Routes
$route['registerproduct'] = 'api/RegisterProduct/index';
$route['create_registerproduct'] = 'api/RegisterProduct/create';
$route['update_registerproduct'] = 'api/RegisterProduct/update';
$route['delete_registerproduct'] = 'api/RegisterProduct/delete';



//ProductListWarranty  API Routes
$route['productlist_warranty'] = 'api/ProductlistWarranty/index';

//ProductListWarranty  API Routes
$route['productlist_warrantydes'] = 'api/ProductlistWarrantyDes/index';


// Claim API Routes
$route['claim'] = 'api/Claim/index';
$route['create_claim'] = 'api/Claim/create';
$route['update_claim'] = 'api/Claim/update';
$route['delete_claim'] = 'api/Claim/delete';


// Service Categories  API Routes
$route['servicecategories'] = 'api/ServiceCategories/index';