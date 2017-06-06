<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
################USER WEB ROUTES######################
//Route::get('/', function () { return view('welcome');});
Route::get('/', function () { return view('home');});
//userSignuppage webroute starts here
Route::get('create-your-bio', 'HomeController@getSignupData');
Route::post('getDomains', 'HomeController@getDomainList');
//userSignuppage webroute ends here
Route::post('get-content', 'HomeControllerSukanta@getContent');
Route::get('get-faqs', 'HomeControllerSukanta@getFaqs');


################ADMIN WEB ROUTES######################
Route::get('backend', function(){
    if(Session::get('bio_admin_id')){
	return view('admin.home');
    }else{
        return view('admin.login');
    }
});
Route::post('/backend/postLogin', 'AdminController@postLogins');
Route::get('/backend/logout', 'AdminController@logoutMe');
Route::get('/backend/dashboard', function(){
    if(Session::get('bio_admin_id')){
	return view('admin.home');
    }else{
        return view('admin.login');
    }
});
Route::get('/backend/editprofile', 'AdminController@getmyprofile');
Route::post('/backend/postprofile', 'AdminController@postmyprofile');
Route::get('/backend/editsocialmedia', 'AdminController@getsocialmedia');
Route::post('/backend/postsocialmedia', 'AdminController@postmysocialmedia');
Route::get('/backend/changepassword', function(){
    if(Session::get('bio_admin_id')){
	return view('admin.change-password');
    }else{
        return view('admin.login');
    }
});
Route::post('/backend/postchangepassword', 'AdminController@postpasswordchange');

// Email Template Start
Route::get('backend/emailtemplates', 'AdminController@getemailtemplate');
Route::get('backend/editemailtemplate/{id}/edit', 'AdminController@getemailsingle');
Route::post('backend/postEmailTemplate', 'AdminController@postemailtemplate');
// Email Template End
// Content section Start
Route::get('backend/contents', 'AdminController@getcontentslist');
Route::get('backend/editcontent/{id}/edit', 'AdminController@getcontentslistsingle');
Route::post('backend/postContent', 'AdminController@postcontentslistsingle');
// Content section End
// FAQ section Start
Route::get('backend/faqs', 'AdminController@getFAQsLists');
Route::get('/backend/addfaq', function(){
    if(Session::get('bio_admin_id')){
	return view('admin.add-faq');
    }else{
        return view('admin.login');
    }
});
Route::get('backend/editfaq/{id}/edit', 'AdminController@getFAQsSingles');
Route::post('backend/postFaq', 'AdminController@postFAQsSingles');
Route::post('backend/postFaqEdit', 'AdminController@postFAQsSingleEdits');
Route::get('backend/deleteFaq/{id}', 'AdminController@getFAQsDelete');
// FAQ section End
// Tutorial section Start
Route::get('backend/tutorials', 'AdminController@getTutorialsLists');
Route::get('/backend/addtutorial', function(){
    if(Session::get('bio_admin_id')){
	return view('admin.add-tutorial');
    }else{
        return view('admin.login');
    }
});
Route::get('backend/edittutorial/{id}/edit', 'AdminController@getTutorialSingles');
Route::post('backend/postTutorial', 'AdminController@postTutorialSingles');
Route::post('backend/postTutorialEdit', 'AdminController@postTutorialSingleEdits');
Route::get('backend/deleteTutorial/{id}', 'AdminController@getTutorialDelete');
// Tutorial section End
// Contactus section Start
Route::get('backend/contactus', 'AdminController@getContactLists');
Route::get('backend/viewcontacts/{id}/view', 'AdminController@getContactSingles');
Route::get('backend/deleteContact/{id}', 'AdminController@getContactListdelete');
// Contactus section End


//SubAdmin user starts here
Route::get('/backend/adminusers', 'AdminController@getAdminUsers');
Route::get('/backend/createadmin', function(){
        if(Session::get('bio_admin_id') && (Session::get('bio_user_type') == 'admin')){
            return view('admin.create-adminuser');
        }else{
            return view('admin.login');
        }
});
Route::post('/backend/saveadmin', 'AdminController@saveAdminUser');
Route::get('/backend/editadmin/{id}', 'AdminController@editAdminUser');
Route::post('/backend/updateadmin', 'AdminController@updateAdminUser');
Route::get('/backend/changestatus/{id}/{status}', 'AdminController@changeStatusAdminUser');
Route::get('/backend/deleteadmin/{id}', 'AdminController@deleteAdminUser');
//Subadmin user ends here

//Domain Category starts here
Route::get('/backend/domain-category', 'AdminController@getDomainCategory');
Route::get('/backend/create-domaincategory', function(){
        if(Session::get('bio_admin_id')){
            return view('admin.create-domaincategory');
        }else{
            return view('admin.login');
        }
});
Route::post('/backend/save-domaincategory', 'AdminController@saveDomainCategory');
Route::get('/backend/edit-domaincategory/{id}', 'AdminController@editDomainCategory');
Route::post('/backend/update-domaincategory', 'AdminController@updateDomainCategory');
Route::get('/backend/category/changestatus/{id}/{status}', 'AdminController@changeStatusDomainCategory');
Route::get('/backend/delete/category/{id}', 'AdminController@deleteDomainCategory');
//Domain category ends here

//Domain list starts here
Route::get('/backend/domain-list', 'AdminController@getDomainList');
Route::get('/backend/create-domain', 'AdminController@createNewDomain');
Route::post('/backend/save-domain', 'AdminController@saveDomain');
Route::get('/backend/edit-domain/{id}', 'AdminController@editDomain');
Route::post('/backend/update-domain', 'AdminController@updateDomain');
Route::get('/backend/domain/changestatus/{id}/{status}', 'AdminController@changeStatusDomain');
Route::get('/backend/delete/domain/{id}', 'AdminController@deleteDomain');

Route::get('/backend/import-domains', 'AdminController@importDomains');
Route::post('/backend/save-importdomains', 'AdminController@saveImportDomains');
//End of domain list 

//DomainImages list starts here
Route::get('/backend/domain-image', 'AdminController@getDomainImages');
Route::get('/backend/add-domain-image', 'AdminController@addDomainImages');
Route::post('/backend/save-domain-image', 'AdminController@saveDomainImages');
Route::post('/backend/uploadFiles', 'AdminController@postUpload');
Route::get('/backend/edit-domain-image/{id}', 'AdminController@editDomainImages');
Route::get('/backend/delete/domain-image-single/{id}', 'AdminController@deleteDomainImageSingle');
Route::get('/backend/delete/domain-image-multiple/{id}', 'AdminController@deleteDomainImageMultiple');
Route::get('/backend/delete/domain-image-preview/{img}/{id}', 'AdminController@deleteDomainImagePreview');
//Domain Images
//Domain service list starts here
Route::get('/backend/domainservice-list', 'AdminController@getDomainServiceList');
Route::get('/backend/create-domainservice', 'AdminController@createNewDomainService');
Route::post('/backend/save-domainservice', 'AdminController@saveDomainService');
Route::get('/backend/edit-domainservice/{id}', 'AdminController@editDomainService');
Route::post('/backend/update-domainservice', 'AdminController@updateDomainService');
Route::get('/backend/domain-service/changestatus/{id}/{status}', 'AdminController@changeStatusService');
Route::get('/backend/delete/domain-service/{id}', 'AdminController@deleteDomainService');
//Domain Service list ends here

//Reserved Subdomain list starts here
Route::get('/backend/reserved-subdomain', 'AdminController@getReservedSubdomainList');
Route::get('/backend/create-reservedsubdomain', 'AdminController@createNewReservedSubdomain');
Route::post('/backend/save-reservedsubdomain', 'AdminController@saveReservedSubdomain');
Route::get('/backend/edit-reserved-subdomain/{id}', 'AdminController@editReservedSubdomain');
Route::post('/backend/update-reservedsubdomain', 'AdminController@updateReservedSubdomain');
Route::get('/backend/delete/reserved-subdomain/{id}', 'AdminController@deleteReservedSubdomain');

Route::get('/backend/import-reserved-subdomains', 'AdminController@importReservedSubdomains');
Route::post('/backend/save-import-reservedsubdomains', 'AdminController@saveImportReservedSubdomains');
//Reserved Subdomain list ends here

//Subdomain price mangement Starts here
Route::get('/backend/edit-subdomainprice', 'AdminController@editSubdomainPrice');
Route::post('/backend/update-subdomainprice', 'AdminController@updateSubdomainPrice');
//Subdomain price mangement Ends here