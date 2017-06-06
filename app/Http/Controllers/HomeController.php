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

class HomeController extends Controller {
    // Get all categories of domains by subharam
    public function getSignupData(){  
        // Get records from tbl_domain_category table
        $domain_category = DB::table('tbl_domain_category')
                ->where('status', '=', 1)
                ->orderBy('category_name', 'asc')->pluck('category_name', 'id');
        return view('create-your-bio')->with('domain_category_arr', $domain_category);
    }
    
    //Get the list of domain of the given category 
    public function getDomainList(Request $request){
        $jData = file_get_contents("php://input");
        $data = json_decode($jData, true);
        $domain_category = $data["domain_category"]; 
        
        $domain_list = DB::table('tbl_domain')
                ->join('tbl_domain_category_match', 'tbl_domain.id', '=', 'tbl_domain_category_match.domain_id')
                ->where('tbl_domain_category_match.category_id', '=', $domain_category)
                //->pluck('tbl_domain.domain_name', 'tbl_domain.id');
                ->select('tbl_domain.id', 'tbl_domain.domain_name')
                ->get();
        //return response()->json($domain_list);
        return $domain_list;
    }
    // Get content data for home page by sukanta
    public function getContent(Request $request){  
        $contentid = $request->content_id;
        // Get records from tbl_contents table
        $contentData = DB::table('tbl_contents')
                ->where('id', '=', $contentid)
                ->get();
        //print_r($contentData[0]);exit;
        return $contentData;
    }
    public function getFaqs(){  
        // Get records from tbl_domain_category table
        $contentData = DB::table('tbl_faqs')
                ->where('status', '=', 0)
                ->get();
        //print_r($contentData[0]);exit;
        return $contentData;
    }
}
