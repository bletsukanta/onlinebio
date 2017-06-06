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

class HomeControllerSukanta extends Controller {
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
