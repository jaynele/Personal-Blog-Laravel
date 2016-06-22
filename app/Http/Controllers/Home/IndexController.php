<?php

namespace App\Http\Controllers\Home;


use App\Http\Model\Artical;
use App\Http\Model\Category;
use App\Http\Model\LinksModel;
use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //点击量最高的6篇文章
        $hot = Artical::orderBy('art_view','desc')->take(6)->get();
        //图文列表(带分页效果)
        $data = Artical::orderBy('art_time','desc')->paginate(5);

        //友情链接
        $links = LinksModel::orderBy('link_order','asc')->get();

        return view('home.index',compact('hot','data','links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cat($cat_id)
    {
        $data = Artical::where('cate_id',$cat_id)->orderBy('art_time','desc')->paginate(4);
        Category::where('cate_id',$cat_id)->increment('cate_view');
        $dd = Category::where('cate_pid',$cat_id)->take(4)->get();
        $cat = Category::find($cat_id);
        return view('home.list',compact('cat','data','dd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function art($art_id)
    {
        $field = Artical::join('category','category.cate_id',' = ','artical.cate_id')->where('art_id',$art_id)->find($art_id);
        Artical::where('art_id',$art_id)->increment('art_view');
        $artical['pre'] = Artical::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $artical['next'] = Artical::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
        $data = Artical::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6)->get();
        return view('home.new',compact('field','artical','data'));
    }

   
}
