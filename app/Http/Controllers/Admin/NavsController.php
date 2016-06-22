<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\NavsModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    /**
     * get   admin/navs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = NavsModel::orderBy('nav_order','desc')->paginate(4);
        return view('admin.navs.list',compact('data'));
    }

    public function changeorder(){
        $input = Input::except('_token');
        $fiels = NavsModel::find($input['nav_id']);
        $fiels->nav_order = $input['nav_order'];
        $re = $fiels->update();
        if($re){
            $data = [
                'status'=>1,
                'msg'=>'导航修改成功!'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'导航修改失败!'
            ];
        }
        return $data;
    }

    /**
     * get  admin/navs/create.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.navs.add');
    }

    /**
     * post admin/navs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');
        $rules = [
            'nav_name'=>'required|max:10|unique:navs',
            'nav_alias'=>'required|max:20|unique:navs',
            'nav_url'=>'required|max:100|unique:navs',
            'nav_order'=>'required|unique:navs',
        ];
        $messages = [
            'nav_name.required'=>'导航名称不能为空!',
            'nav_name.max'=>'导航名称最多10个字!',
            'nav_name.unique'=>'导航名称已存在!',
            'nav_alias.unique'=>'导航标题已存在!',
            'nav_url.unique'=>'导航路径已存在!',
            'nav_order.unique'=>'导航排名已存在!',
            'nav_alias.required'=>'导航标题不能为空!',
            'nav_alias.max'=>'导航标题最多20个字!',
            'nav_url.required'=>'导航路径不能为空!',
            'nav_url.max'=>'导航路径不要超过200个字哦!',
            'nav_order.required'=>'导航排序不能为空!',
        ];
        $validator = Validator::make($input,$rules,$messages);;
        if($validator->passes()){
            $re = NavsModel::create($input);
            if($re){
                return redirect('admin/navs');
            }else{
                return back()->with('errors','导航信息添加失败!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * get  admin/navs/{navs}/edit.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nav_id)
    {
        $field = NavsModel::find($nav_id);
        return view('admin.navs.edit',compact('field'));
    }

    /**
     * put  admin/navs/{navs}.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nav_id)
    {
        $input = Input::except('_method','_token');
        $rules = [
            'nav_name'=>'required|max:10',
            'nav_alias'=>'required|max:20',
            'nav_url'=>'required|max:100',
            'nav_order'=>'required',
        ];
        $messages = [
            'nav_name.required'=>'导航名称不能为空!',
            'nav_name.max'=>'导航名称最多10个字!',
            'nav_alias.required'=>'导航标题不能为空!',
            'nav_alias.max'=>'导航标题最多20个字!',
            'nav_url.required'=>'导航路径不能为空!',
            'nav_url.max'=>'导航路径不要超过200个字哦!',
            'nav_order.required'=>'导航排序不能为空!',
        ];
        $validator = Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re = NavsModel::where('nav_id',$nav_id)->update($input);
            if($re){
                return redirect('admin/navs');
            }else{
                return back()->with('msg','无任何修改!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * delete  admin/navs/{navs}.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nav_id)
    {
        $re = NavsModel::where('nav_id',$nav_id)->delete();
        if($re){
            $data = [
                'status'=>1,
                'msg'=>'导航删除成功!'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'导航删除失败!'
            ];
        }
        return $data;
    }
}
