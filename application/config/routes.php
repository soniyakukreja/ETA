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
//$route['default_controller'] = 'welcome';


$route['default_controller'] = 'authorize/authorize';
$route['checkuser'] = 'authorize/checkuser';
$route['userlogin'] = 'authorize/userlogin';
$route['forgot-password'] = 'authorize/forgotPass';
$route['reset-password/(.+)'] = 'authorize/resetpass/reset/$1';
$route['resetPasswordForm'] = 'authorize/resetpass/resetPasswordForm';
$route['order-summary/(.+)'] = 'shop/order_summary/$1';
$route['cart'] = 'shop/your_cart';
$route['logout'] = 'user/Myprofile/logout';


//All Accounts 
$route['licensee/productbylic'] ='product/product/productbylic';
$route['licensee/viewproduct/(.+)']= 'product/product/viewproduct/$1';
$route['licensee/bannerbylic'] = 'marketing/bannerbylic';

$route['industryassociation/productbyia'] ='product/product/productbyia';
$route['industryassociation/viewproduct/(.+)'] ='product/product/viewproduct/$1';

$route['industryassociation/bannerbyia'] = 'marketing/bannerbyia';

$route['supplier/productbysupplier']= 'product/productbysupplier';
$route['supplier/viewproduct/(.+)']= 'product/product/viewproduct/$1';

$route['kams/viewkamslic']= 'kams/kams/viewkamslic';
$route['kams/viewkamsia']= 'kams/kams/viewkamsia';

$route['ticket-account/ticketlic']= 'ticket/ticket_account/ticketlic';
$route['ticket-account/viewlicticket/(.+)']= 'ticket/viewlicticket/$1';

$route['ticket-account/ticketia']= 'ticket/ticket_account/ticketia';
$route['ticket-account/viewiaticket/(.+)']= 'ticket/viewiaticket/$1';

$route['ticket-account/ticketconsume']= 'ticket/ticket_account/ticketconsume';
$route['ticket-account/viewconticket/(.+)']= 'ticket/viewconticket/$1';
$route['import-business-contact']= 'lead/business/uploadcsv';

$route['consumer/consumer-detail/(.+)']= 'consumer/consumer_detail/$1';
$route['reports/purchase-report']= 'reports/purchase_report';
$route['reports/sup-sales-report']= 'reports/sup_sales_report';
$route['reports/general-reconciliation-report']= 'reports/general_reconciliation_report';
$route['reports/general-transaction-report']= 'reports/general_transaction_report';
$route['reports/all-lic-disbursement-report']= 'reports/all_lic_disbursement_report';
$route['reports/all-ia-disbursement-report']= 'reports/all_ia_disbursement_report';
$route['reports/lic-reconciliation-report']= 'reports/lic_reconciliation_report';
$route['reports/ia-reconciliation-report']= 'reports/ia_reconciliation_report';
$route['reports/ia-disbursment-report']= 'reports/ia_disbursment_report';
$route['reports/lic-disbursment-report']= 'reports/lic_disbursment_report';
$route['reports/lic-transaction-summary']= 'reports/lic_transaction_summary';
$route['reports/ia-transaction-summary']= 'reports/ia_transaction_summary';


$route['product/int-expression']= 'product/int_expression';

$route['marketing/page-ads']= 'marketing/page_ads';
$route['marketing/page-ads-form']= 'marketing/page_ads_form';
$route['marketing/page-manage-form']= 'marketing/page_manage_form';
$route['marketing/page-detail/(.+)']= 'marketing/page_detail/$1';
$route['marketing/banner-detail/(.+)']= 'marketing/banner_detail/$1';
$route['marketing/editpage-banner/(.+)']= 'marketing/editpage_banner/$1';

$route['business-review/licbusiness-review']= 'business_review/licbusiness_review/';
$route['business-review/iabusiness-review']= 'business_review/iabusiness_review/';
$route['business-review/licbusiness-detail/(.+)']= 'business_review/licbusiness_detail/$1';
$route['business-review/iabusiness-detail/(.+)']= 'business_review/iabusiness_detail/$1';
$route['business-review/editlicbusiness/(.+)']= 'business_review/editlicbusiness/$1';
$route['business-review/editiabusiness/(.+)']= 'business_review/editiabusiness/$1';


$route['awardlevel']= 'user_category/User';
$route['awardlevel/add']= 'user_category/User/addcategory';
$route['awardlevel/view/(.+)']= 'user_category/User/viewcategory/$1';
$route['awardlevel/edit/(.+)']= 'user_category/User/editcategory/$1';

$route['lead/business/viewbusiness-detail/(.+)']= 'lead/business/viewbusiness_detail/$1';

$route['template-manager/email-manager']= 'template-manager/email_manager';
$route['template-manager/doc-manager']= 'template-manager/doc_manager';
$route['template-manager/doc-manager/update-document/(.+)']= 'template-manager/doc_manager/update_document/$1';


//$route['ticket_account/viewticket_account']= 'ticket/ticket_account/viewticket_account';




$route['myprofile']= 'user/Myprofile';
$route['update-my-password']= 'user/Myprofile/updatePasswordForm';

$route['dashboard'] = 'dashboard/Dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
