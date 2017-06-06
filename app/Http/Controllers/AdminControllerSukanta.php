<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Redirect;
use Image;
//use Dotenv\Validator;
//use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class AdminControllerSukanta extends Controller {
    
    public function welcome() {
       //$response = new Response();
      //$response->setStatusCode(500, 'The resource is created successfully!');
      //abort(500, 'Unauthorized action.');
      // return view('welcome');
        
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
