<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Artical;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\NavsModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
   public function __construct(){
       $navs = NavsModel::orderBy('nav_order','asc')->get();
       //8篇最新发布文章
       $new = Artical::orderBy('art_time','desc')->take(8)->get();
       //最热right
       $hott = Artical::orderBy('art_view','desc')->take(5)->get();
       View::share('navs',$navs);
       View::share('new',$new);
       View::share('hott',$hott);
   }
}
