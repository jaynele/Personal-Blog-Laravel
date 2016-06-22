<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\LinksModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    /**
     * get   admin/links.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = LinksModel::orderBy('link_order','desc')->paginate(4);
        return view('admin.links.list',compact('data'));
    }

    public function changeorder(){
        $input = Input::except('_token');
        $fiels = LinksModel::find($input['link_id']);
        $fiels->link_order = $input['link_order'];
        $re = $fiels->update();
        if($re){
            $data = [
                'status'=>1,
                'msg'=>'排序修改成功!'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'排序修改失败!'
            ];
        }
        return $data;
    }

    /**
     * get  admin/links/create.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.links.add');
    }

    /**
     * post admin/links.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');
        $rules = [
            'link_name'=>'required|max:10|unique:Links',
            'link_title'=>'required|max:20|unique:Links',
            'link_url'=>'required|max:100|unique:Links',
            'link_order'=>'required|unique:Links',
        ];
        $messages = [
            'link_name.required'=>'链接名称不能为空!',
            'link_name.max'=>'链接名称最多10个字!',
            'link_name.unique'=>'链接名称已存在!',
            'link_title.unique'=>'链接标题已存在!',
            'link_url.unique'=>'链接路径已存在!',
            'link_order.unique'=>'链接排名已存在!',
            'link_title.required'=>'链接标题不能为空!',
            'link_title.max'=>'链接标题最多20个字!',
            'link_url.required'=>'链接路径不能为空!',
            'link_url.max'=>'链接路径不要超过200个字哦!',
            'link_order.required'=>'链接排序不能为空!',
        ];
        $validator = Validator::make($input,$rules,$messages);;
        if($validator->passes()){
            $re = LinksModel::create($input);
            if($re){
                return redirect('admin/links');
            }else{
                return back()->with('errors','文章信息添加失败!');
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
     * get  admin/links/{links}/edit.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($link_id)
    {
        $field = LinksModel::find($link_id);
        return view('admin.links.edit',compact('field'));
    }

    /**
     * put  admin/links/{links}.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $link_id)
    {
        $input = Input::except('_method','_token');
        $rules = [
            'link_name'=>'required|max:10',
            'link_title'=>'required|max:20',
            'link_url'=>'required|max:100',
            'link_order'=>'required',
        ];
        $messages = [
            'link_name.required'=>'链接名称不能为空!',
            'link_name.max'=>'链接名称最多10个字!',
            'link_title.required'=>'链接标题不能为空!',
            'link_title.max'=>'链接标题最多20个字!',
            'link_url.required'=>'链接路径不能为空!',
            'link_url.max'=>'链接路径不要超过200个字哦!',
            'link_order.required'=>'链接排序不能为空!',
        ];
        $validator = Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re = LinksModel::where('link_id',$link_id)->update($input);
            if($re){
                return redirect('admin/links');
            }else{
                return back()->with('msg','无任何修改!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * delete  admin/links/{links}.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($link_id)
    {
        $re = LinksModel::where('link_id',$link_id)->delete();
        if($re){
            $data = [
                'status'=>1,
                'msg'=>'链接删除成功!'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'链接删除失败!'
            ];
        }
        return $data;
    }
}
