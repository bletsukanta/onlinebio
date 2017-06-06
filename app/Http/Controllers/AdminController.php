<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Redirect;
use Image;
use Excel;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller {
    // Get all categories of domains by subharam
    public function getDomainCategory(){       
        //Check super-admin is login or not
        if(!Session::get('bio_admin_id')){
                return view('admin.login');
        }
        // Get records from tbl_domain_category table
        $domain_category = DB::table('tbl_domain_category')->get();
        return view('admin.domain-categorylist')->with('domain_category', $domain_category);
    }
    
    //Save Domain category by subharam on 25thApril2017
    public function saveDomainCategory(Request $request) {
        $category_name = $request->input('category_name');
        $curr_date = date('Y-m-d');
        
        //check empty first name, last name or email
        if ($category_name == "") {
            Session::flash('message', 'Sorry ! category name');
            return Redirect::to('/backend/create-domaincategory')->withInput();
        }
        $categoryData = DB::table('tbl_domain_category')
                ->where('category_name', '=', $category_name)
                ->get();
        if (count($categoryData) > 0) {
            Session::flash('message', 'Sorry ! this category is already exist');
            return Redirect::to('/backend/create-domaincategory')->withInput();
        }

        DB::table('tbl_domain_category')->insert(array('category_name' => $category_name,
                            'status' => 1,
                            'created_date' => $curr_date));
        
        $last_insert_category_id = DB::getPdo()->lastInsertId();
        if($last_insert_category_id){
            Session::flash('sucmsg', 'Domain category is created successfully.');
            return Redirect::to('/backend/domaincategory');
        }   
    }
    
    //Edit Domain Category by subharam
    public function editDomainCategory(Request $request){
        // Check Login here
        if(Session::get('bio_admin_id') == ""){
                return view('admin.login');
        }
        $domain_category_id = $request->id;
        // Get records from tbl_admin_users with subadminuserid
        $category_data = DB::table('tbl_domain_category')
                ->where('id', '=', $domain_category_id)
                ->get();
        return view('admin.create-domaincategory')->with('data', $category_data[0]);
    }
    //Update domain category by subharam on 25thApril2017
    public function updateDomainCategory(Request $request) {
        $domain_category_id = $request->input('hdn_domain_categoryid');
        $category_name = $request->input('category_name');
        $curr_date = date('Y-m-d');
        
        //check empty first name, last name or email
        if ($category_name == "") {
            Session::flash('message', 'Sorry ! category name');
            return Redirect::to('/backend/edit-domaincategory/'.$domain_category_id);
        }
        $categoryData = DB::table('tbl_domain_category')
                ->where('category_name', '=', $category_name)
                ->where('id', '<>', $domain_category_id)
                ->get();
        if (count($categoryData) > 0) {
            Session::flash('message', 'Sorry ! this category is already exist');
            return Redirect::to('/backend/edit-domaincategory/'.$domain_category_id);
        }

        DB::table('tbl_domain_category')
                ->where('id', '=', $domain_category_id)
                ->update(array('category_name' => $category_name,
                            'updated_date' => $curr_date));
        
        Session::flash('sucmsg', 'Domain category is updated successfully.');
        return Redirect::to('/backend/domaincategory');
    }  
    
    //Change the status of Domain category added by subharam on 28thApril2017
    public function changeStatusDomainCategory(Request $request) {
        $domain_category_id = $request->id;
        $domaincategory_status = $request->status;
        $change_status = ($domaincategory_status == 1 ) ? 0 : 1;
        DB::table('tbl_domain_category')->where('id', '=', $domain_category_id)->update(['status' => $change_status]);
        return Redirect::to('/backend/domaincategory');
    }

    //Edit AdminUser by subharam on 27thApril2017
    public function deleteDomainCategory(Request $request){
        $domain_category_id = $request->id;
        // Delete record from tbl_admin_users table
        DB::table('tbl_domain_category')->where('id', '=', $domain_category_id)->delete();
        return Redirect::to('/backend/domaincategory');
    }
    
    //SubAdmin user listing added by subharam on 24thApril2017
    public function getAdminUsers() {
        //Check super-admin is login or not
        if(!Session::get('bio_admin_id') || (Session::get('bio_user_type') != 'admin')){
                //return Redirect::to('/backend');
                return view('admin.login');
        }
        // Get records from core table with email address
        $subadminusers = DB::table('tbl_admin_users')
                ->where('type', '=', 'subadmin')
                ->get();
        return view('admin.manage-subadmin')->with('subadminusers', $subadminusers);
    }
    
    //Save SubAdminUser by subharam on 25thApril2017
    public function saveAdminUser(Request $request) {
        $admin_type = 'subadmin';
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $alt_email = $request->input('alt_email');
        $phone_no = $request->input('phone_no');
        $alt_phone_no = $request->input('alt_phone_no');
        $address = $request->input('address');
        $city = $request->input('city');
        $state = $request->input('state');
        $country = $request->input('country');
        $password = base64_encode(base64_encode($request->input('password')));
        $curr_date = date('Y-m-d');
        
        //check empty first name, last name or email
        if ($first_name == "" || $last_name == "" || $email == "") {
            Session::flash('message', 'Sorry ! first name or email id should not be blank');
            return Redirect::to('/backend/createadmin')->withInput();
        }
        $adminData = DB::table('tbl_admin_users')
                ->where('email', '=', $email)
                ->get();
        if (count($adminData) > 0) {
            Session::flash('message', 'Sorry ! this email is already exist');
            return Redirect::to('/backend/createadmin')->withInput();
        }

        DB::table('tbl_admin_users')->insert(array('type' => $admin_type,
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'email' => $email,
                            'alt_email' => $alt_email,
                            'phone_no' => $phone_no,
                            'alt_phone_no' => $alt_phone_no,
                            'address' => $address,
                            'state' => $state,
                            'city' => $city,
                            'country' => $country,
                            'password' => $password,
                            'created_date' => $curr_date));
        
        $admin_user_id = DB::getPdo()->lastInsertId();
        if($admin_user_id){
            //send mail to admin after creation
            $orginal_password = $request->input('password');
            $res_template = DB::table('email_template')->where('id', '=', 1)->get();

            # Subject
            $subject = $res_template[0]->subject;
            $input = $res_template[0]->contents;

            $body = str_replace(
                    array('%USERNAME%', '%EMAIL%', '%PASSWORD%'), array($first_name, $email, $orginal_password), $input);
            //echo $body;exit;
            #header
            $headers = "MIME-Version: 1.0\n";
            $headers .= "Content-type: text/html; charset=UTF-8\n";
            $headers .= "From:info@onlinebio.com <>\n";
            //$headers .= "From:" . $admin_name . " < " . $admin_email . ">\n";
            @mail($email, $subject, $body, $headers);
            Session::flash('sucmsg', 'Admin user created successfully.');
            return Redirect::to('/backend/adminusers');
        }else{
            Session::flash('message', 'Sorry ! some error occured in inserting record');
            return Redirect::to('/backend/createadmin')->withInput();
        }    
    }
    
     //Edit subadminuser
    public function editAdminUser(Request $request){
        // Check Login here
        $admin_id = Session::get('bio_admin_id');
        if($admin_id == "" || (Session::get('bio_user_type') != 'admin')){
                return view('admin.login');
        }
        $admin_user_id = $request->id;//SubAdmin userid
        // Get records from tbl_admin_users with subadminuserid
        $adminData = DB::table('tbl_admin_users')
                ->where('id', '=', $admin_user_id)
                ->get();
        return view('admin.edit-adminuser')->with('data', $adminData[0]);
    }
    
    //Update adminUser by subharam on 27thApril2017
    public function updateAdminUser(Request $request){
        // Check super admin is Login here or not
        if(!Session::get('bio_admin_id') || (Session::get('bio_user_type') != 'admin')){
                //return Redirect::to('/backend');
                return view('admin.login');
        }
        //SubAdmin userid for edit his information
        $admin_user_id = $request->input('hdn_admin_userid');
        
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $alt_email = $request->input('alt_email');
        $phone_no = $request->input('phone_no');
        $alt_phone_no = $request->input('alt_phone_no');

        $address = $request->input('address');
        $city = $request->input('city');
        $state = $request->input('state');
        $country = $request->input('country');
        $curr_date = date('Y-m-d');
        
        //check empty first name, last name or email
        if ($first_name == "" || $last_name == "" || $email == "") {
            Session::flash('message', 'Sorry ! first name or email id should not be blank');
            return Redirect::to('/backend/editadmin/'.$admin_user_id);
        }
        $adminData = DB::table('tbl_admin_users')
                ->where('email', '=', $email)
                ->where('id', '<>', $admin_user_id)
                ->get();
        
        if (count($adminData) > 0) {
            Session::flash('message', 'Sorry ! this email is already exist');
            return Redirect::to('/backend/editadmin/'.$admin_user_id);
        }
        DB::table('tbl_admin_users')
                ->where('id', '=', $admin_user_id)
                ->update(
                        array('first_name' => $first_name,
                            'last_name' => $last_name,
                            'email' => $email,
                            'alt_email' => $alt_email,
                            'phone_no' => $phone_no,
                            'alt_phone_no' => $alt_phone_no,
                            'address' => $address,
                            'state' => $state,
                            'city' => $city,
                            'country' => $country,
                            'updated_date' => $curr_date
        ));
        Session::flash('sucmsg', 'Admin user is updated successfully.');
        return Redirect::to('/backend/editadmin/'.$admin_user_id);
    }
   
    //Change the status of SubAdminUser added by subharam on 25thApril2017
    public function changeStatusAdminUser(Request $request) {
        $admin_user_id = $request->id;
        $admin_user_status = $request->status;
        $change_status = ($admin_user_status == 1 ) ? 0 : 1;
        DB::table('tbl_admin_users')->where('id', '=', $admin_user_id)->update(['status' => $change_status]);
        return Redirect::to('/backend/adminusers');
    }

    //Delete SubAdminUser added by subharam on 25thApril2017
    public function deleteAdminUser(Request $request) {
        $admin_user_id = $request->id;
        // Delete record from tbl_admin_users table
        DB::table('tbl_admin_users')->where('id', '=', $admin_user_id)->delete();
        return Redirect::to('/backend/adminusers');
    }

    //Domain listing added by subharam on 28thApril2017
    public function getDomainList() {
        //Check super-admin is login or not
        if(!Session::get('bio_admin_id')){
                return view('admin.login');
        }
        //Get the domain details by joining tables tbl_domain, tbl_domain_category, tbl_domain_category_match
        $domain_list = DB::table('tbl_domain')
                ->join('tbl_domain_category_match', 'tbl_domain.id', '=', 'tbl_domain_category_match.domain_id')
                ->join('tbl_domain_category', 'tbl_domain_category_match.category_id', '=', 'tbl_domain_category.id')
                ->groupBy('tbl_domain_category_match.domain_id')
                ->select('tbl_domain.*',DB::raw("(GROUP_CONCAT(tbl_domain_category.category_name)) as category_name"))
                ->get();
        return view('admin.domain-list')->with('domain_list', $domain_list);
      
        // Get records from core table with domain_id
        /*$domain_list = DB::table('tbl_domain')
                ->join('tbl_domain_category', 'tbl_domain.category_id', '=', 'tbl_domain_category.id')
                ->select('tbl_domain.*', 'tbl_domain_category.category_name')
                ->get();
        return view('admin.domain-list')->with('domain_list', $domain_list);*/
    }
    
    //Create a new domain by subharam 1stMay2017
    public function createNewDomain(){
        //Check super-admin is login or not
        if(!Session::get('bio_admin_id')){
                return view('admin.login');
        }
        $domain_category = DB::table('tbl_domain_category')
                ->where('status', '=', 1)
                ->orderBy('category_name', 'asc')->pluck('category_name', 'id');
                //->select('tbl_domain_category.id', 'tbl_domain_category.category_name')
                //->get();
        return view('admin.create-domain')->with('domain_category_arr', $domain_category);
    }
    
    //Save Domain by subharam on 1stApril2017
    public function saveDomain(Request $request) {
        $domain_name = $request->input('domain_name');
        $domain_category = $request->input('domain_category');
        $meta_title = $request->input('meta_title');
        $meta_description = $request->input('meta_description');
        $meta_keyword = $request->input('meta_keyword');
        $curr_date = date('Y-m-d');
        
        //check empty domain name, domain category
        if ($domain_name == "" || $domain_category == "") {
            Session::flash('message', 'Sorry ! Domain category and Domain should not be blank');
            return Redirect::to('/backend/create-domain')->withInput();
        }
        $domain_data = DB::table('tbl_domain')
                ->where('domain_name', '=', $domain_name)
                ->get();
        if (count($domain_data) > 0) {
            Session::flash('message', 'Sorry ! this domain is already exist');
            return Redirect::to('/backend/create-domain')->withInput();
        }

        DB::table('tbl_domain')->insert(array('domain_name' => $domain_name,
                            /*'category_id'       => $domain_category,*/
                            'meta_title'        => $meta_title,
                            'meta_description'  => $meta_description,
                            'meta_keyword'      => $meta_keyword,
                            'status'            => 1,
                            'created_date'      => $curr_date));
        
        $last_insert_domain_id = DB::getPdo()->lastInsertId();
        
        //Insert in to the tbl_domain_category_match table (for domain and category match) on 15thMay2017
        foreach($domain_category as $k => $v ){
            $domain_category_arr[] = array('domain_id' => $last_insert_domain_id, 'category_id' => $v, 'created_date' => $curr_date);
        }
        DB::table('tbl_domain_category_match')->insert($domain_category_arr);
        //End of domain-category match on 15thMay2017
        
        if($last_insert_domain_id){
            //condition for profile image
            if ($request->hasFile('favicon_image')) {
                $ext = strtolower($request->file('favicon_image')->getClientOriginalExtension());
                if($request->file('favicon_image') != "" && $ext != "png" && $ext != "jpg" && $ext != "jpeg"){
                    return Redirect::to('backend/create-domain')->with('invformat', true);
                }
                // Remove Previous image
                $imageData = DB::table('tbl_domain')->where('id', '=', $last_insert_domain_id)->get();
                if ($imageData[0]->favicon_image != "" && file_exists(public_path() . '/admin_favicon_image/' . $imageData[0]->favicon_image)) {
                    unlink(public_path() . '/admin_favicon_image/' . $imageData[0]->favicon_image);
                }
                $fileName = date('ymdhis') . '_' . str_replace(" ", "_", $request->file('favicon_image')->getClientOriginalName());
                //Thumb Photo Uploading
                $thumb_img = Image::make($request->file('favicon_image')->getRealPath())->resize(109, 115);
                $thumb_img->save(public_path().'/admin_favicon_image/'.$fileName,80);

                //$request->input('profile_image')->move(public_path() . '/admin_profile_image/', $fileName);

                // Update into Table
                DB::table('tbl_domain')->where('id', '=', $last_insert_domain_id)->update(array('favicon_image' => $fileName));
            }
            
            Session::flash('sucmsg', 'Domain is created successfully.');
            return Redirect::to('/backend/domain-list');
        }   
    }
    
    //Edit Domain Category by subharam
    public function editDomain(Request $request){
        // Check Login here
        if(Session::get('bio_admin_id') == ""){
                return view('admin.login');
        }
        $domain_id = $request->id;
        // Get records from tbl_admin_users with subadminuserid
        $domain_data = DB::table('tbl_domain')
                ->join('tbl_domain_category_match', 'tbl_domain.id', '=', 'tbl_domain_category_match.domain_id')
                ->where('tbl_domain.id', '=', $domain_id)
                ->groupBy('tbl_domain_category_match.domain_id')
                ->select('tbl_domain.*', DB::raw("(GROUP_CONCAT(tbl_domain_category_match.category_id)) as category_id"))
                ->get();
        
        /*$domain_data = DB::table('tbl_domain')
                ->where('id', '=', $domain_id)
                ->get();*/
        
        $domain_category = DB::table('tbl_domain_category')
                ->where('status', '=', 1)
                ->orderBy('category_name', 'asc')->pluck('category_name', 'id');
        return view('admin.create-domain')
                ->with('domain_data_arr', $domain_data[0])
                ->with('domain_category_arr', $domain_category);
    }
    
    //Update domain by subharam on 2ndApril2017
    public function updateDomain(Request $request) {
        $domain_id = $request->input('hdn_domain_id');
        $domain_name = $request->input('domain_name');
        $domain_category = $request->input('domain_category');
        $meta_title = $request->input('meta_title');
        $meta_description = $request->input('meta_description');
        $meta_keyword = $request->input('meta_keyword');
        $curr_date = date('Y-m-d');
        
        //check empty domain name or domain category
        if ($domain_name == "" || $domain_category[0] == "") {
            Session::flash('message', 'Sorry ! Domain category and Domain should not be blank');
            return Redirect::to('/backend/edit-domain/'.$domain_id);
        }
        $domain_data = DB::table('tbl_domain')
                ->where('domain_name', '=', $domain_name)
                ->where('id', '<>', $domain_id)
                ->get();
        if (count($domain_data) > 0) {
            Session::flash('message', 'Sorry ! this domain is already exist');
            return Redirect::to('/backend/edit-domain/'.$domain_id);
        }

        DB::table('tbl_domain')
                ->where('id', '=', $domain_id)
                ->update(array('domain_name' => $domain_name,
                            /*'category_id'       => $domain_category,*/
                            'meta_title'        => $meta_title,
                            'meta_description'  => $meta_description,
                            'meta_keyword'      => $meta_keyword,
                            'updated_date' => $curr_date));
        
        //Insert in to the tbl_domain_category_match table (for domain and category match) on 15thMay2017
        /*First Delete all category from tbl_domain_category_match table*/
        DB::table('tbl_domain_category_match')->where('domain_id', '=', $domain_id)->delete();
        foreach($domain_category as $k => $v ){
            $domain_category_arr[] = array('domain_id' => $domain_id, 'category_id' => $v, 'updated_date' => $curr_date);
        }
        DB::table('tbl_domain_category_match')->insert($domain_category_arr);
        //End of domain-category match on 15thMay2017
        
        //condition for profile image and edit domainid
        if ($domain_id && $request->hasFile('favicon_image')) { 
            $ext = strtolower($request->file('favicon_image')->getClientOriginalExtension());
            if($request->file('favicon_image') != "" && $ext != "png" && $ext != "jpg" && $ext != "jpeg"){
                return Redirect::to('/backend/edit-domain/'.$domain_id)->with('invformat', true);
            }
            // Remove Previous image
            $imageData = DB::table('tbl_domain')->where('id', '=', $domain_id)->get();
            if ($imageData[0]->favicon_image != "" && file_exists(public_path() . '/admin_favicon_image/' . $imageData[0]->favicon_image)) {
                unlink(public_path() . '/admin_favicon_image/' . $imageData[0]->favicon_image);
            }
            $fileName = date('ymdhis') . '_' . str_replace(" ", "_", $request->file('favicon_image')->getClientOriginalName());
            //Thumb Photo Uploading
            $thumb_img = Image::make($request->file('favicon_image')->getRealPath())->resize(109, 115);
            $thumb_img->save(public_path().'/admin_favicon_image/'.$fileName,80);

            // Update into Table
            DB::table('tbl_domain')->where('id', '=', $domain_id)->update(array('favicon_image' => $fileName));
        }
        
        Session::flash('sucmsg', 'Domain is updated successfully.');
        return Redirect::to('/backend/domain-list');
    }  
    
    //Change the status of Domain added by subharam on 28thApril2017
    public function changeStatusDomain(Request $request) {
        $domain_id = $request->id;
        $domain_status = $request->status;
        $change_status = ($domain_status == 1 ) ? 0 : 1;
        DB::table('tbl_domain')->where('id', '=', $domain_id)->update(['status' => $change_status]);
        return Redirect::to('/backend/domain-list');
    }
    
    //Delete domain by subharam on 28thApril2017
    public function deleteDomain(Request $request){
        $domain_id = $request->id;
        // Delete record from tbl_domain table
        DB::table('tbl_domain')->where('id', '=', $domain_id)->delete();
        // Delete record from tbl_domain_category_match table of the coresponding domain_id
        DB::table('tbl_domain_category_match')->where('domain_id', '=', $domain_id)->delete();
        // Delete record from tbl_reserved_subdomain of the domain_id
        DB::table('tbl_reserved_subdomain')->where('domain_id', '=', $domain_id)->delete();
        return Redirect::to('/backend/domain-list');
    }

    //Create a new domain by subharam 1stMay2017
    public function importDomains(){
        //Check super-admin is login or not
        if(!Session::get('bio_admin_id')){
                return view('admin.login');
        }
        return view('admin.import-domain');
    }
    
    //Save Imported domains to tbl_domains
    public function saveImportDomains(Request $request){
        if ($request->hasFile('import_domain')) {
            $path = $request->file('import_domain')->getRealPath();
            $data = Excel::load($path, function($reader) {})->get();
            
            if (!empty($data) && $data->count()) {
                $record_no = 0;
                $domain_inserted = 0;
                $mandatory_record_no = "";
                $category_record_no = "";
                $category_msg = "";
                $mandatory_msg = "";
                foreach ($data->toArray() as $key => $value) {
                    $record_no++;
                    $category_name = $value['category_name'];
                    $domain_name = $value['domain_name'];
                    //Check mandatory fields of the record exist or not 
                    if($category_name == "" || $domain_name == ""){
                        $mandatory_record_no .= $record_no.",";
                        continue;
                    }
                    //get the category_id from cagtegory_name from the tbl_domain_category
                    $category_id_data = DB::table('tbl_domain_category')
                        ->where('category_name', '=', $category_name)
                        ->select('id')
                        ->get();
                    //get the domain_id from domain_name from the tble_domain
                    $domain_id_data = DB::table('tbl_domain')
                        ->where('domain_name', '=', $domain_name)
                        ->select('id')
                        ->get();
                    $domain_id = (count($domain_id_data)) ? $domain_id_data[0]->id : 0; 
                    if(count($category_id_data)){
                        $category_id = $category_id_data[0]->id;
                        //check wheather domain is exist by checking the category_id and domain_name with joining the table tbl_domain and tbl_domain_category_match
                        $domain_exist_data = DB::table('tbl_domain')
                            ->join('tbl_domain_category_match', 'tbl_domain.id', '=', 'tbl_domain_category_match.domain_id')
                            ->where('tbl_domain.domain_name', '=', $domain_name)
                            ->where('tbl_domain_category_match.category_id', '=', $category_id)
                            ->select('tbl_domain.*', 'tbl_domain_category_match.category_id')
                            ->get();
                        if(!count($domain_exist_data)){
                            //Insert domain data to tbl_domain 
                            $curr_date = date('Y-m-d');
                            if(!$domain_id){
                                DB::table('tbl_domain')->insert(array('domain_name' => $value['domain_name'],
                                    'meta_title'        => $value['meta_title'],
                                    'meta_description'  => $value['meta_description'],
                                    'meta_keyword'      => $value['meta_keyword'],
                                    'status'            => 1,
                                    'created_date'      => $curr_date));
                                $last_insert_domain_id = DB::getPdo()->lastInsertId();
                            }else{
                                $last_insert_domain_id = $domain_id;
                            }
                            //Insert domain_id and category_id to tbl_domain_category_match
                            DB::table('tbl_domain_category_match')->insert(array('domain_id' => $last_insert_domain_id,
                                'category_id' => $category_id,
                                'created_date' => $curr_date));
                            $domain_inserted++;
                        }
                    }else{
                       $category_record_no .= $record_no."," ;
                    }
                }
                if($mandatory_record_no != ""){
                    $mandatory_msg = "domain_name and category_name are required on record number ".trim($mandatory_record_no,',')." .";
                }
                if($category_record_no != ""){
                    $category_msg = "category_name is not exist on record number ".trim($category_record_no,',');
                }
                $success_msg =  $domain_inserted.' Records imported successfully.'.$mandatory_msg.$category_msg;
                Session::flash('sucmsg', $success_msg);
                return Redirect::to('/backend/domain-list');
            }
        }
        Session::flash('message', 'Please Check your file, Something is wrong there.');
        return Redirect::to('/backend/domain-list');
    }
    
    //Domain listing added by subharam on 28thApril2017
    public function getDomainServiceList() {
        //Check super-admin is login or not
        if(!Session::get('bio_admin_id')){
                return view('admin.login');
        }
        // Get records from core table with domain_id
        $domain_sevice_list = DB::table('tbl_domain_service')->join('tbl_domain', 'tbl_domain_service.domain_id', '=', 'tbl_domain.id')
                ->select('tbl_domain_service.*', 'tbl_domain.domain_name')
                ->get();
        return view('admin.domain-service-list')->with('domain_service_list', $domain_sevice_list);
    }    
    
        //Create a new domain by subharam 1stMay2017
    public function createNewDomainService(){
        //Check super-admin is login or not
        if(!Session::get('bio_admin_id')){
                return view('admin.login');
        }
        $domain_arr = DB::table('tbl_domain')
                ->where('status', '=', 1)
                ->orderBy('domain_name', 'asc')->pluck('domain_name', 'id');
        return view('admin.create-domainservice')->with('domain_arr', $domain_arr);
    }
    
    //Save Domain by subharam on 1stApril2017
    public function saveDomainService(Request $request) {
        $service_name = $request->input('service_name');
        $domain_id = $request->input('domain_name');
        $short_description = $request->input('short_description');
        $curr_date = date('Y-m-d');
        
        //check empty domain name, domain category
        if ($service_name == "" || $domain_id == "") {
            Session::flash('message', 'Sorry ! Domain category and Domain should not be blank');
            return Redirect::to('/backend/create-domain')->withInput();
        }
        $service_data = DB::table('tbl_domain_service')
                ->where('service_name', '=', $service_name)
                ->get();
        if (count($service_data) > 0) {
            Session::flash('message', 'Sorry ! this Service is already exist');
            return Redirect::to('/backend/create-domainservice')->withInput();
        }

        DB::table('tbl_domain_service')->insert(array('service_name' => $service_name,
                            'domain_id'       => $domain_id,
                            'short_description'  => $short_description,
                            'status'            => 1,
                            'created_date'      => $curr_date));
              
        Session::flash('sucmsg', 'Service is created successfully.');
        return Redirect::to('/backend/domainservice-list');   
    }
    
    //Edit Domain Category by subharam
    public function editDomainService(Request $request){
        // Check Login here
        if(Session::get('bio_admin_id') == ""){
                return view('admin.login');
        }
        $service_id = $request->id;
        // Get records from tbl_admin_users with subadminuserid
        $service_data = DB::table('tbl_domain_service')
                ->where('id', '=', $service_id)
                ->get();
        $domain_arr = DB::table('tbl_domain')
                ->where('status', '=', 1)
                ->orderBy('domain_name', 'asc')->pluck('domain_name', 'id');
              
        return view('admin.create-domainservice')
                ->with('service_data_arr', $service_data[0])
                ->with('domain_arr', $domain_arr);
    }
    //Update domain service by subharam on 2ndApril2017
    public function updateDomainService(Request $request) {
        $service_id = $request->input('hdn_service_id');
        $service_name = $request->input('service_name');
        $domain_id = $request->get('domain_name');
        $short_description = $request->input('short_description');
        $curr_date = date('Y-m-d');
        
        //check empty service name or domain name
        if ($service_name == "" || $domain_id == "") {
            Session::flash('message', 'Sorry ! Domain name and service name should not be blank');
            return Redirect::to('/backend/edit-domainservice/'.$domain_id);
        }
        $service_data = DB::table('tbl_domain_service')
                ->where('service_name', '=', $service_name)
                ->where('id', '<>', $service_id)
                ->get();
        if (count($service_data) > 0) {
            Session::flash('message', 'Sorry ! this domain is already exist');
            return Redirect::to('/backend/edit-domainservice/'.$service_id);
        }

        DB::table('tbl_domain_service')
                ->where('id', '=', $service_id)
                ->update(array('service_name' => $service_name,
                            'domain_id'       => $domain_id,
                            'short_description'  => $short_description,
                            'updated_date' => $curr_date));
        
        //condition for profile image
        Session::flash('sucmsg', 'Service is updated successfully.');
        return Redirect::to('/backend/domainservice-list');
    }
    //Change the status of Domain Service added by subharam on 9thMay2017
    public function changeStatusService(Request $request) {
        $service_id = $request->id;
        $service_status = $request->status;
        $change_status = ($service_status == 1 ) ? 0 : 1;
        DB::table('tbl_domain_service')->where('id', '=', $service_id)->update(['status' => $change_status]);
        return Redirect::to('/backend/domainservice-list');
    }
    
    //Delete domain service by subharam on 28thApril2017
    public function deleteDomainService(Request $request){
        $service_id = $request->id;
        // Delete record from tbl_admin_users table
        DB::table('tbl_domain_service')->where('id', '=', $service_id)->delete();
        return Redirect::to('/backend/domainservice-list');
    }
    
    //Reserved SubDomain listing added by subharam on 10thMay2017
    public function getReservedSubdomainList() {
        //Check super-admin is login or not
        if(!Session::get('bio_admin_id')){
                return view('admin.login');
        }
        // Get records from core table with domain_id
        $reserved_subdomain = DB::table('tbl_reserved_subdomain')->join('tbl_domain', 'tbl_reserved_subdomain.domain_id', '=', 'tbl_domain.id')
                ->select('tbl_reserved_subdomain.*', 'tbl_domain.domain_name')
                ->get();
        return view('admin.reserved-subdomain-list')->with('reserved_subdomain_list', $reserved_subdomain);
    }
    
    //Create a new Reserved Subdomain by subharam 5thMay2017
    public function createNewReservedSubdomain(){
        //Check super-admin is login or not
        if(!Session::get('bio_admin_id')){
                return view('admin.login');
        }
        $domain_arr = DB::table('tbl_domain')
                ->where('status', '=', 1)
                ->orderBy('domain_name', 'asc')->pluck('domain_name', 'id');
        $subdomaintype_arr = config('constants.subdomain_type');//array(1 => 'Blocked', 2 => 'Premium', 3 => 'Super Premium');
        return view('admin.create-reservedsubdomain')->with('domain_arr', $domain_arr)->with('subdomaintype_arr', $subdomaintype_arr);
    }
    
    //Save ReservedSubDomain by subharam on 1stApril2017
    public function saveReservedSubdomain(Request $request) {
        $reserved_subdomain_name = $request->input('reserved_subdomain_name');
        $domain_id = $request->input('domain_name');
        $subdomain_type = $request->input('subdomain_type');
        $curr_date = date('Y-m-d');
        
        //check empty subdomain name, domain and subdomain type
        if ($reserved_subdomain_name == "" || $domain_id == "" || $subdomain_type == "") {
            Session::flash('message', 'Sorry ! SubDomain, Domain, SubDomainType should not be blank');
            return Redirect::to('/backend/create-reservedsubdomain')->withInput();
        }
        $subdomain_data = DB::table('tbl_reserved_subdomain')
                ->where('subdomain_name', '=', $reserved_subdomain_name)
                ->where('domain_id', '=', $domain_id)
                ->where('subdomain_type', '=', $subdomain_type)
                ->get();
        if (count($subdomain_data) > 0) {
            Session::flash('message', 'Sorry ! this SubDomain is already exist');
            return Redirect::to('/backend/create-reservedsubdomain')->withInput();
        }

        DB::table('tbl_reserved_subdomain')->insert(array('subdomain_name' => $reserved_subdomain_name,
                            'domain_id'       => $domain_id,
                            'subdomain_type'  => $subdomain_type,
                            'is_used'            => 0,
                            'created_date'      => $curr_date));
              
        Session::flash('sucmsg', 'Subdomain is reserved successfully.');
        return Redirect::to('/backend/reserved-subdomain');   
    }
    
    //Edit Reserved SubDomain by subharam
    public function editReservedSubdomain(Request $request){
        // Check Login here
        if(Session::get('bio_admin_id') == ""){
                return view('admin.login');
        }
        $reserved_subdomain_id = $request->id;
        //Get records from tbl_reserved_subdomain with reserved_subdomain_id
        $reserved_subdomain = DB::table('tbl_reserved_subdomain')
                ->where('id', '=', $reserved_subdomain_id)
                ->get();
        $domain_arr = DB::table('tbl_domain')
                ->where('status', '=', 1)
                ->orderBy('domain_name', 'asc')->pluck('domain_name', 'id');
        $subdomaintype_arr = array(1 => 'Blocked', 2 => 'Premium', 3 => 'Super Premium'); 
        
        return view('admin.create-reservedsubdomain')->with('reserved_subdomain', $reserved_subdomain[0])
                ->with('domain_arr', $domain_arr)
                ->with('subdomaintype_arr', $subdomaintype_arr);
    }
    
    //Update Reserved Subdomain  by subharam on 11thApril2017
    public function updateReservedSubdomain(Request $request) {
        $subdomain_id = $request->input('hdn_reserved_subdomain_id');
        $subdomain_name = $request->input('reserved_subdomain_name');
        $domain_id = $request->get('domain_name');
        $subdomain_type = $request->input('subdomain_type');
        $curr_date = date('Y-m-d');
        
        //check empty subdomain name, domain and subdomain type
        if ($subdomain_name == "" || $domain_id == "" || $subdomain_type == "") {
            Session::flash('message', 'Sorry ! SubDomain, Domain, SubDomainType should not be blank');
            return Redirect::to('/backend/edit-reserved-subdomain/'.$subdomain_id);
        }
        
        $subdomain_data = DB::table('tbl_reserved_subdomain')
                ->where('subdomain_name', '=', $subdomain_name)
                ->where('id', '<>', $subdomain_id)
                ->where('domain_id', '<>', $domain_id)
                ->where('subdomain_type', '<>', $subdomain_type)
                ->get();
        if (count($subdomain_data) > 0) {
            Session::flash('message', 'Sorry ! this Subdomain is already reserved');
            return Redirect::to('/backend/edit-reserved-subdomain/'.$subdomain_id);
        }

        DB::table('tbl_reserved_subdomain')
                ->where('id', '=', $subdomain_id)
                ->update(array('subdomain_name' => $subdomain_name,
                            'domain_id'       => $domain_id,
                            'subdomain_type'  => $subdomain_type,
                            'updated_date' => $curr_date));
                       
        //condition for profile image
        Session::flash('sucmsg', 'Reserved subdomain is updated successfully.');
        return Redirect::to('/backend/reserved-subdomain');
    }
    
    //Delete domain service by subharam on 28thApril2017
    public function deleteReservedSubdomain(Request $request){
        $reservedsubdomain_id = $request->id;
        // Delete record from tbl_admin_users table
        DB::table('tbl_reserved_subdomain')->where('id', '=', $reservedsubdomain_id)->delete();
        return Redirect::to('/backend/reserved-subdomain');
    }
    
    //Create a new domain by subharam 1stMay2017
    public function importReservedSubdomains(){
        //Check super-admin is login or not
        if(!Session::get('bio_admin_id')){
                return view('admin.login');
        }
        return view('admin.import-reserved-subdomain');
    }
    
    //Save Imported domains to tbl_domains
    public function saveImportReservedSubdomains(Request $request){
        if ($request->hasFile('import_subdomain')) {
            $path = $request->file('import_subdomain')->getRealPath();
            $data = Excel::load($path, function($reader) {})->get();
            if (!empty($data) && $data->count()) {
                $record_no = 0;$subdomain_inserted = 0;
                $mandatory_record_no = "";$subdomaintype_record_no = "";$domain_record_no = "";
                $subdomaintype_msg = "";$mandatory_msg = "";$domain_msg = "";
                
                $subdomain_type_arr = config('constants.subdomain_type');//array(1 => 'Blocked', 2 => 'Premium', 3 => 'Super Premium');
                
                foreach ($data->toArray() as $key => $value) {
                    $record_no++;
                    $subdomain_name = $value['subdomain_name'];
                    $domain_name = $value['domain_name'];
                    $subdomain_type = $value['subdomain_type'];
                    //Check mandatory fields of the record exist or not 
                    if($subdomain_name == "" || $domain_name == "" || $subdomain_type == ""){
                        $mandatory_record_no .= $record_no.",";
                        continue;
                    }
                    //Check SubdomainType is valid or not 
                    if(in_array($subdomain_type,$subdomain_type_arr)){
                        $subdomaintype_id = array_flip($subdomain_type_arr)[$subdomain_type];
                    }else{
                        $subdomaintype_record_no .= $record_no."," ;
                        continue;
                    }
                    
                    //get the domain_id from domain_name from the tble_domain
                    $domain_id_data = DB::table('tbl_domain')
                        ->where('domain_name', '=', $domain_name)
                        ->select('id')
                        ->get();
                    
                    $domain_id = (count($domain_id_data)) ? $domain_id_data[0]->id : 0; 
                    if(!$domain_id){
                        $domain_record_no .= $record_no."," ;
                        continue;
                    }
                    
                    if($domain_id && $subdomaintype_id && $subdomain_name){
                        //check wheather domain is exist by checking the category_id and domain_name with joining the table tbl_domain and tbl_domain_category_match
                        $subdomain_exist_data = DB::table('tbl_reserved_subdomain')
                            ->where('domain_id', '=', $domain_id)
                            ->where('subdomain_name', '=', $subdomain_name)
                            ->where('subdomain_name', '=', $subdomain_name)
                            //->where('subdomain_type', '=', $subdomaintype_id)    
                            ->get();
                        
                        if(!count($subdomain_exist_data)){
                            //Insert reserved subdomain data to tbl_reserved_subdomain 
                            $curr_date = date('Y-m-d');
                            DB::table('tbl_reserved_subdomain')->insert(array('subdomain_name' => $subdomain_name,
                                'domain_id'        => $domain_id,
                                'subdomain_type'  => $subdomaintype_id,
                                'created_date'      => $curr_date));
                            $subdomain_inserted++;
                        }
                    }
                }
                if($mandatory_record_no != ""){
                    $mandatory_msg = "Subdomain_name, Domain_name and Subdomain_type are required on record number ".trim($mandatory_record_no,',')." .";
                }
                if($subdomaintype_record_no != ""){
                    $subdomaintype_msg = "Subdomain_type is not exist on record number ".trim($subdomaintype_record_no,',')." .";
                }
                if($domain_record_no != ""){
                    $domain_msg = "Domain_name is not exist on record number ".trim($domain_record_no,',')." .";
                }
                $success_msg =  $subdomain_inserted.' Records imported successfully.'.$mandatory_msg.$subdomaintype_msg.$domain_msg;
                Session::flash('sucmsg', $success_msg);
                return Redirect::to('/backend/reserved-subdomain');
            }
        }
        Session::flash('message', 'Please Check your file, Something is wrong there.');
        return Redirect::to('/backend/reserved-subdomain');
    }
    
    //Edit Reserved SubDomain by subharam
    public function editSubdomainPrice(Request $request){
        // Check Login here
        if(Session::get('bio_admin_id') == ""){
                return view('admin.login');
        }
        //Get records from tbl_reserved_subdomain with reserved_subdomain_id
        $subdomain_price = DB::table('tbl_subdomain_price')->get();
        return view('admin.subdomain-editprice')->with('subdomain_price', $subdomain_price[0]);
    }
    //Update Reserved Subdomain  by subharam on 11thApril2017
    public function updateSubdomainPrice(Request $request) {
        $generic_price = $request->input('generic_price');
        $premium_tire1_price = $request->get('premium_tire1_price');
        $premium_tire2_price = $request->input('premium_tire2_price');
        $curr_date = date('Y-m-d');
        
        //check empty subdomain name, domain and subdomain type
        if ($generic_price == "" || $premium_tire1_price == "" || $premium_tire2_price == "") {
            Session::flash('message', 'Sorry ! GenericPrice, PremiumPrice, SuperPremiumPrice should not be blank');
            return Redirect::to('/backend/edit-subdomainprice');
        }

        DB::table('tbl_subdomain_price')
                ->update(array('generic_price' => $generic_price,
                            'premium_tire1_price'       => $premium_tire1_price,
                            'premium_tire2_price'  => $premium_tire2_price,
                            'created_date' => $curr_date));
                       
        //condition for profile image
        Session::flash('sucmsg', 'Subdomain Prices are updated successfully.');
        return Redirect::to('/backend/edit-subdomainprice');
    }
    public function postLogins(Request $request) {
        //echo $request->input('email');exit;
        $email = $request->input('email');
        $user_password = $request->input('password');
        if ($email == "" || $user_password == "") {
            Session::flash('message', 'Email and Password is required');
            return Redirect::to('/backend');
        }

        // Get records from core table with email address
        $result = DB::table('tbl_admin_users')
                ->where('email', '=', $email)
                ->where('status', '=', '1')
                ->get();
        // If record not exist
        if (count($result) == 0) {
            Session::flash('message', 'Sorry ! Invalid email or password');
            return Redirect::to('/backend');
        }

        // Decrypt the password from the database
        $db_password = base64_decode(base64_decode($result[0]->password));

        // If password does not macth in db_password
        if ($user_password != $db_password) {
            Session::flash('message', 'Sorry ! password is not correct');
            return Redirect::to('/backend');
        }

        // Store in SESSION
        $request->session()->put('bio_admin_id', $result[0]->id);
        $request->session()->put('bio_admin_name', $result[0]->first_name);
        $request->session()->put('bio_user_type', $result[0]->type);
        
        /*Session::put('bio_admin_id', $result[0]->id);
        Session::put('bio_admin_name', $result[0]->first_name);
        Session::put('bio_user_type', $result[0]->type);*/
        ###################DELETE FILES FROM FOLDER#########################
        $filesarr = Storage::disk('previewimage')->allFiles();
        foreach ($filesarr as $valfile){
            Storage::disk('previewimage')->delete($valfile);
        }
        //Storage::disk('previewimage')->delete('domain-1495023875.jpg');
        //print "<pre>";   
        //print_r($filesarr);exit;
        ###################DELETE FILES FROM FOLDER#########################
        return Redirect::to('/backend/dashboard');
    }

    public function logoutMe(Request $request) {
        $request->session()->forget('bio_admin_id');
        $request->session()->forget('bio_admin_name');
        $request->session()->forget('bio_user_type');
        $request->session()->flush();
        
        /*Session::flush();
        Session::forget('bio_admin_id');
        Session::forget('bio_admin_name');
        Session::forget('bio_user_type');*/
        return Redirect::to('/backend');
    }

    public function getmyprofile() {
        // Check Login here
        $admin_id = Session::get('bio_admin_id');
        if($admin_id == ""){
                return Redirect::to('/backend');
        }
        // Get records from tbl_admin_users with email address
        $adminData = DB::table('tbl_admin_users')
                ->where('id', '=', $admin_id)
                ->get();
        return view('admin.edit-profile')->with('data', $adminData[0]);
    }

    public function postmyprofile(Request $request) {
        //get admin id from session 
        $admin_id = Session::get('bio_admin_id');
        if($admin_id == ""){
                return Redirect::to('/backend');
        }
        //echo $request->input('email');exit;
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $alt_email = $request->input('alt_email');
        $phone_no = $request->input('phone_no');
        $alt_phone_no = $request->input('alt_phone_no');

        $address = $request->input('address');
        $city = $request->input('city');
        $state = $request->input('state');
        $country = $request->input('country');
        $curr_date = date('Y-m-d');
        //check empty first name, last name or email
        if ($first_name == "" || $last_name == "" || $email == "") {
            Session::flash('message', 'Sorry ! first name or email id should not be blank');
            return Redirect::to('/backend/editprofile');
        }
        $adminData = DB::table('tbl_admin_users')
                ->where('email', '=', $email)
                ->where('id', '<>', $admin_id)
                ->get();
//        echo count($adminData);
//        print_r($adminData); exit();
        if (count($adminData) > 0) {
            Session::flash('message', 'Sorry ! this email is already exist');
            return Redirect::to('/backend/editprofile');
        }
        DB::table('tbl_admin_users')
                ->where('id', '=', $admin_id)
                ->where('type', '=', 'admin')
                ->update(
                        array('first_name' => $first_name,
                            'last_name' => $last_name,
                            'email' => $email,
                            'alt_email' => $alt_email,
                            'phone_no' => $phone_no,
                            'alt_phone_no' => $alt_phone_no,
                            'address' => $address,
                            'state' => $state,
                            'city' => $city,
                            'country' => $country,
                            'updated_date' => $curr_date
        ));
        //condition for profile image
        if ($request->hasFile('profile_image')) {
            $ext = strtolower($request->file('profile_image')->getClientOriginalExtension());
            if($request->file('profile_image') != "" && $ext != "png" && $ext != "jpg" && $ext != "jpeg"){
                return Redirect::to('backend/editprofile')->with('invformat', true);
            }
            // Remove Previous image
            $imageData = DB::table('tbl_admin_users')->where('id', '=', $admin_id)->get();
            if ($imageData[0]->profile_image != "" && file_exists(public_path() . '/admin_profile_image/' . $imageData[0]->profile_image)) {
                unlink(public_path() . '/admin_profile_image/' . $imageData[0]->profile_image);
            }
            $fileName = date('ymdhis') . '_' . str_replace(" ", "_", $request->file('profile_image')->getClientOriginalName());
            //Thumb Photo Uploading
            $thumb_img = Image::make($request->file('profile_image')->getRealPath())->resize(109, 115);
            $thumb_img->save(public_path().'/admin_profile_image/'.$fileName,80);
            
            //$request->input('profile_image')->move(public_path() . '/admin_profile_image/', $fileName);

            // Update into Table
            DB::table('tbl_admin_users')->where('id', '=', $admin_id)->update(array('profile_image' => $fileName));
        }
        Session::flash('sucmsg', 'Your profile updated successfully.');
        return Redirect::to('/backend/editprofile');
    }

    public function getsocialmedia() {
        $admin_id = Session::get('bio_admin_id');
        // Get records from tbl_admin_users with email address
        $adminData = DB::table('tbl_admin_users')
                ->where('id', '=', $admin_id)
                ->get();
        return view('admin.edit-social-media')->with('data', $adminData[0]);
    }
    public function postmysocialmedia(Request $request) {
        //echo $request->input('email');exit;
        $facebook_url = $request->input('facebook_url');
        $twitter_url = $request->input('twitter_url');
        $pinterest_url = $request->input('pinterest_url');
        $linkdin_url = $request->input('linkdin_url');
        $googleplus_url = $request->input('googleplus_url');
        $instagram_url = $request->input('instagram_url');
        
        //get admin id from session 
        $admin_id = Session::get('bio_admin_id');
        $curr_date = date('Y-m-d');

        DB::table('tbl_admin_users')
                ->where('id', '=', $admin_id)
                ->where('type', '=', 'admin')
                ->update(
                        array('facebook_url' => $facebook_url,
                            'twitter_url' => $twitter_url,
                            'pinterest_url' => $pinterest_url,
                            'linkdin_url' => $linkdin_url,
                            'googleplus_url' => $googleplus_url,
                            'instagram_url' => $instagram_url,
                            'updated_date' => $curr_date
        ));
        Session::flash('sucmsg', 'Social media updated successfully.');
        return Redirect::to('/backend/editsocialmedia');
    }
     public function postpasswordchange(Request $request) {
        //echo "here";exit;
         //get admin id from session 
        $admin_id = Session::get('bio_admin_id');
        if($admin_id == ""){
                return Redirect::to('/backend');
        }
        $old_password = $request->input('old_password');
        $new_password = $request->input('new_password');
        $confirm_password = $request->input('confirm_password');

        if ($old_password == "" || $new_password == "" || $confirm_password == "") {
            Session::flash('message', 'password fields should not be blank');
            return Redirect::to('/backend/changepassword');
        }

        if ($new_password != $confirm_password) {
            Session::flash('message', 'Sorry ! new password and confirm password should be match');
            return Redirect::to('/backend/changepassword');
        }

        $is_password_exist = DB::table('tbl_admin_users')
                ->select('password')
                ->where('id', '=', $admin_id)
                ->get();
        $decrypted_db_password = base64_decode(base64_decode($is_password_exist[0]->password));

        if ($decrypted_db_password != $old_password) {
            Session::flash('message', 'Sorry ! old password is not correct');
            return Redirect::to('/backend/changepassword');
        }

        $encrypted_password = base64_encode(base64_encode($new_password));

        DB::table('tbl_admin_users')
                ->where('id', '=', $admin_id)
                ->update(array('password' => $encrypted_password));

        Session::flash('sucmsg', 'Your password changed successfully');
        return Redirect::to('/backend/changepassword');
    }
    public function getemailtemplate() {
        //get admin id from session 
        $admin_id = Session::get('bio_admin_id');
        if($admin_id == ""){
                return Redirect::to('/backend');
        }
        $EmailData = DB::table('tbl_email_template')->orderBy('id')->where('id', '>', 0)->get();
        return view('admin.manage-emailtemplate')->with('EmailData', $EmailData);
    }

    public function getemailsingle(Request $request) {
       $reference_id=$request->id;
       $data = DB::table('tbl_email_template')->where('id', '=', $reference_id)->get();
       return view('admin.edit-emailtemplate')->with('data', $data[0]);
    }

    public function postemailtemplate(Request $request) {

        $reference_id = $request->input('reference_id');
        $title = $request->input('title');
        $subject = $request->input('subject');
        $content = $request->input('content');
        DB::table('tbl_email_template')
                ->where('id', '=', $reference_id)
                ->update(
                        array('title' => $title,
                            'subject' => $subject,
                            'contents' => $content));

        Session::flash('sucmsg', 'Email template updated successfully');
        return Redirect::to('backend/editemailtemplate/'.$reference_id.'/edit');
    }
     // Manage Contents
    public function getcontentslist() {
        //get admin id from session 
        $admin_id = Session::get('bio_admin_id');
        if($admin_id == ""){
                return Redirect::to('/backend');
        }
        $data = DB::table('tbl_contents')->orderBy('id')->get();
        return view('admin.manage-content')->with('Data', $data);
    }

    public function getcontentslistsingle($reference_id) {

        $data = DB::table('tbl_contents')
                ->where('id', '=', $reference_id)
                ->get();
       
         return view('admin.edit-content')->with('data', $data[0]);
    }

    public function postcontentslistsingle(Request $request) {

        $reference_id = $request->input('reference_id');
        $content_title = $request->input('content_title');
        $content_description = $request->input('content_description');
        $meta_title = $request->input('meta_title');
        $meta_descr = $request->input('meta_descr');
        $meta_keyword = $request->input('meta_keyword');
        $date = date('Y-m-d');
        if ($content_title == "") {
            Session::flash('message', 'Content title should not be blank');
            return Redirect::to('backend/editcontent/'.$reference_id.'/edit');
        }

        DB::table('tbl_contents')
                ->where('id', '=', $reference_id)
                ->update(
                        array('content_title' => $content_title,
                            'content_description' => $content_description,
                            'meta_title' => $meta_title,
                            'meta_descr' => $meta_descr,
                            'meta_keyword' => $meta_keyword,
                            'updated_date' => $date));

        Session::flash('sucmsg', 'Content updated successfully');
        return Redirect::to('backend/editcontent/'.$reference_id.'/edit');
    }

    // Manage Contents
    // Manage FAQs	
    public function getFAQsLists() {
        //get admin id from session 
        $admin_id = Session::get('bio_admin_id');
        if($admin_id == ""){
                return Redirect::to('/backend');
        }
        $data = DB::table('tbl_faqs')->orderBy('id')->get();
        return view('admin.manage-faqs')->with('data', $data);
    }
    public function getFAQsSingles($reference_id) {
        $data = DB::table('tbl_faqs')
                ->where('id', '=', $reference_id)
                ->get();
        return view('admin.edit-faq')->with('data', $data[0]);
    }

    public function postFAQsSingles(Request $request) {
        $faq = $request->input('question');
        $faq_ans = $request->input('answer');
        $created_date = date('Y-m-d');
        if ($faq == "") {
            Session::flash('message', 'Faq question should not be blank');
            return Redirect::to('backend/addfaq');
        }
        // insert records
        DB::table('tbl_faqs')->insert(
                array('question' => $faq, 'answer' => $faq_ans, 'created_date' => $created_date)
        );
        return Redirect::to('backend/faqs');
    }

    public function postFAQsSingleEdits(Request $request) {
        $reference_id = $request->input('reference_id');
        $faq = $request->input('question');
        $faq_ans = $request->input('answer');
        $updated_date = date('Y-m-d');
        if ($faq == "") {
            Session::flash('message', 'Faq question should not be blank');
            return Redirect::to('backend/editfaq/'.$reference_id.'/edit');
        }
        DB::table('tbl_faqs')->where('id', '=', $reference_id)
                ->update(array('question' => $faq, 'answer' => $faq_ans,'updated_date' => $updated_date));

        return Redirect::to('backend/faqs');
    }

    public function getFAQsDelete($id) {
        DB::table('tbl_faqs')->where('id', '=', $id)->delete();
        return Redirect::to('backend/faqs');
    }
    // Manage FAQs
    // Manage Tutorials	
    public function getTutorialsLists() {
        //get admin id from session 
        $admin_id = Session::get('bio_admin_id');
        if($admin_id == ""){
                return Redirect::to('/backend');
        }
        $data = DB::table('tbl_tutorials')->orderBy('id')->get();
        return view('admin.manage-tutorials')->with('data', $data);
    }
    public function getTutorialSingles($reference_id) {
        $data = DB::table('tbl_tutorials')
                ->where('id', '=', $reference_id)
                ->get();
        return view('admin.edit-tutorial')->with('data', $data[0]);
    }

    public function postTutorialSingles(Request $request) {
        $topic = $request->input('topic');
        $content= $request->input('content');
        $created_date = date('Y-m-d');
        if ($topic == "") {
            Session::flash('message', 'Tutorial topic should not be blank');
            return Redirect::to('backend/addtutorial');
        }
        // insert records
        DB::table('tbl_tutorials')->insert(
                array('topic' => $topic, 'content' => $content, 'created_date' => $created_date)
        );
        return Redirect::to('backend/tutorials');
    }
    public function postTutorialSingleEdits(Request $request) {
        $reference_id = $request->input('reference_id');
        $topic = $request->input('topic');
        $content = $request->input('content');
        $updated_date = date('Y-m-d');
        if ($topic == "") {
            Session::flash('message', 'Tutorial topic should not be blank');
            return Redirect::to('backend/edittutorial/'.$reference_id.'/edit');
        }
        DB::table('tbl_tutorials')->where('id', '=', $reference_id)
                ->update(array('topic' => $topic, 'content' => $content,'updated_date' => $updated_date));

        return Redirect::to('backend/tutorials');
    }

    public function getTutorialDelete($id) {
        DB::table('tbl_tutorials')->where('id', '=', $id)->delete();
        return Redirect::to('backend/tutorials');
    }
    // Manage Tutorials
    // Manage Contacts
    public function getContactLists() {
        //get admin id from session 
        $admin_id = Session::get('bio_admin_id');
        if($admin_id == ""){
                return Redirect::to('/backend');
        }
        $data = DB::table('tbl_contacts')->orderBy('id')->get();
        return view('admin.manage-contacts')->with('data', $data);
    }
    public function getContactListdelete($id) {
        DB::table('tbl_contacts')->where('id', '=', $id)->delete();
        return Redirect::to('backend/contactus');
    }
     public function getContactSingles($reference_id) {
        $data = DB::table('tbl_contacts')
                ->where('id', '=', $reference_id)
                ->get();
        return view('admin.view-contacts')->with('data', $data[0]);
    }
    //ManageContacts
    //Domain images added by sukanta on 15th May 2017
    public function getDomainImages() {
        //Check super-admin is login or not
        if(!Session::get('bio_admin_id')){
                return view('admin.login');
        }
        // Get records from core table with domain_id
        $domain_list = DB::table('tbl_domain_image')
                ->join('tbl_domain', 'tbl_domain_image.domain_id', '=', 'tbl_domain.id')
                ->select('tbl_domain_image.*', 'tbl_domain.domain_name',DB::raw("count(*) as cntdomain"))
                ->groupBy('tbl_domain_image.domain_id')
                ->get();
        //print "<pre>";        print_r($domain_list);exit;
        return view('admin.domain-image')->with('domain_list', $domain_list);
    }
    public function addDomainImages(){
        //Check super-admin is login or not
        if(!Session::get('bio_admin_id')){
                return view('admin.login');
        }
        $domain_name = DB::table('tbl_domain')
                ->where('status', '=', 1)
                ->orderBy('domain_name', 'asc')->pluck('domain_name', 'id');               
        return view('admin.add-domain-image')->with('domain_name_arr', $domain_name);
    }
    
    public function saveDomainImages(Request $request){
        //Check super-admin is login or not
        if(!Session::get('bio_admin_id')){
            return view('admin.login');
        }
        $created_date= date("Y-m-d");
        //print_r($request->all());exit;
        $domain_id=$request->domain_name;
        if($domain_id =='' || count($request->hid_img)==0){
           Session::flash('message', 'Domain name or Image should not be blank');
           return Redirect::to('backend/add-domain-image'); 
        }
        foreach($request->hid_img as $imgname){
           $tempImgPath= public_path('preview_images').'/'.$imgname;
            if ($imgname != "" && file_exists($tempImgPath)) {
                //Original Photo Uploading
                $orig_img = Image::make($tempImgPath)->resize(1000, 293);
                $orig_img->save(public_path('domain_images/orig').'/'.$imgname,80);
                
                //Thumb Photo Uploading
                $thumb_img = Image::make($tempImgPath)->resize(170, 50);
                $thumb_img->save(public_path('domain_images/thumb').'/'.$imgname,80);
            }
            unlink(public_path('preview_images').'/'.$imgname);
        
            // insert records
            DB::table('tbl_domain_image')->insert(
                array('domain_id' => $domain_id, 'image_name' => $imgname, 'created_date' => $created_date)
            );
        }
        return Redirect::to('backend/domain-image');
    }
    public function postUpload(Request $request) {
        //echo "here";exit;
        //$file = $request->imgfile;
        $ext = strtolower($request->imgfile->getClientOriginalExtension());
        if($request->imgfile != "" && $ext != "png" && $ext != "jpg" && $ext != "jpeg"){
            return "0"; 
        }
        $imageName = 'domain-'.time().'.'.$request->imgfile->getClientOriginalExtension();
        $request->imgfile->move(public_path('preview_images'), $imageName);
        return $imageName;
    }
    public function editDomainImages($reference_id){
        //Check super-admin is login or not
        if(!Session::get('bio_admin_id')){
                return view('admin.login');
        }
        //echo $reference_id;exit;
        $domain_name = DB::table('tbl_domain')
                ->where('status', '=', 1)
                ->orderBy('domain_name', 'asc')->pluck('domain_name', 'id'); 
        $domain_image_arr = DB::table('tbl_domain_image')->where('domain_id', '=', $reference_id)->get(); 
         //print "<pre>"; print_r($domain_image_arr);exit;
        return view('admin.add-domain-image')->with('domain_name_arr', $domain_name)->with('domain_image_arr', $domain_image_arr);
    }
    public function deleteDomainImageSingle($id) {
        //get data from domain image
        $domain_image_arr = DB::table('tbl_domain_image')->where('id', '=', $id)->get();
        //echo $domain_image_arr[0]->image_name;
        //print "<pre>";print_r($domain_image_arr);exit;
        //unlink image from orig and thumb folder
        $origImgPath= public_path('domain_images/orig');
        $thumbImgPath= public_path('domain_images/thumb');
        if($domain_image_arr[0]->image_name !='' && file_exists($origImgPath.'/'.$domain_image_arr[0]->image_name)){
            unlink($origImgPath.'/'.$domain_image_arr[0]->image_name);
        }
        if($domain_image_arr[0]->image_name !='' && file_exists($thumbImgPath.'/'.$domain_image_arr[0]->image_name)){
            unlink($thumbImgPath.'/'.$domain_image_arr[0]->image_name);
        }
        //delete from main table
        DB::table('tbl_domain_image')->where('id', '=', $id)->delete();
        return Redirect::to('backend/edit-domain-image/'.$domain_image_arr[0]->domain_id);
    }
    public function deleteDomainImageMultiple($domainid) {
        //get data from domain image
        $domain_image_arr = DB::table('tbl_domain_image')->where('domain_id', '=', $domainid)->get();
        //echo $domain_image_arr[0]->image_name;
        //print "<pre>";print_r($domain_image_arr);exit;
        //unlink image from orig and thumb folder
        $origImgPath= public_path('domain_images/orig');
        $thumbImgPath= public_path('domain_images/thumb');
        foreach ($domain_image_arr as $domain_image) {
            if($domain_image->image_name !='' && file_exists($origImgPath.'/'.$domain_image->image_name)){
                unlink($origImgPath.'/'.$domain_image->image_name);
            }
            if($domain_image->image_name !='' && file_exists($thumbImgPath.'/'.$domain_image->image_name)){
                unlink($thumbImgPath.'/'.$domain_image->image_name);
            }
            //delete from main table
            DB::table('tbl_domain_image')->where('id', '=', $domain_image->id)->delete();
        }
        
        return Redirect::to('backend/domain-image');
    }
    public function deleteDomainImagePreview($img,$domain_id) {
        //unlink image from temp folder
        $tempImgPath= public_path('preview_images');
        $returnurl =($domain_id)?'backend/edit-domain-image/'.$domain_id :'backend/add-domain-image';
        if($img !='' && file_exists($tempImgPath.'/'.$img)){
            unlink($tempImgPath.'/'.$img);
        }
        return Redirect::to($returnurl);
    }
}
