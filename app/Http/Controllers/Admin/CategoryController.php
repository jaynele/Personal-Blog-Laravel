<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * get   admin/category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = (new Category)->tree();
        return view('admin/category/list')->with('data',$data);
    }

    public function changeorder(){
        $input =Input::except('_token');
        $field = Category::find($input['cate_id']);
        $field->cate_order = $input['cate_order'];
        $re = $field->update();
        if($re){
            $data = [
                'status'=>1,
                'msg'=>'栏目排序修改成功,点击更新按钮进行排序!'
            ];
        }else{
            $data =[
                'status'=>0,
                'msg'=>'栏目排序修改失败!请重新修改!'
            ];
        }
        return $data;
    }

    /**
     * get  admin/category/create.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.add',compact('data'));
    }

    /**
     * post admin/category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');
        $rules = [
            'cate_pid'=>'required',
            'cate_name'=>'required|unique:Category|max:6',
            'cate_title'=>'required|unique:Category',
            'cate_order'=>'required'
        ];
        $messages = [
            'cate_pid.required'=>'栏目父级分类不能为空!',
            'cate_name.required'=>'栏目分类名称不能为空!',
            'cate_title.required'=>'栏目分类标题不能为空!',
            'cate_title.unique'=>'栏目分类标题已存在!',
            'cate_order.required'=>'栏目分排序类不能为空!',
            'cate_name.unique'=>'栏目分类名称已存在!',
            'cate_name.max'=>'栏目分类名称不要超过6个字哦!',
        ];
        $validator = Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re = Category::create($input);
            if($re){
                return redirect('admin/category');
            }else{
                return back()->with('msg','栏目信息添加失败!');
            }
        }else{
            return back()->withErrors($validator);
        }

    }

    /**
     * get  admin/category/{category}/edit.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($cate_id)
    {
        $data = Category::where('cate_pid',0)->get();
        $field = Category::find($cate_id);
        return view('admin.category.edit',compact('data','field'));
    }

    /**
     * put  admin/category/{category}.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cate_id)
    {
        $input = Input::except('_method','_token');
        $rules = [
            'cate_pid'=>'required',
            'cate_name'=>'required|max:6',
            'cate_title'=>'required',
            'cate_order'=>'required'
        ];
        $messages = [
            'cate_pid.required'=>'栏目父级分类不能为空!',
            'cate_name.required'=>'栏目分类名称不能为空!',
            'cate_title.required'=>'栏目分类标题不能为空!',
            'cate_order.required'=>'栏目分排序类不能为空!',
            'cate_name.max'=>'栏目分类名称不要超过6个字哦!',
        ];
        $validator = Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $up = Category::where('cate_id',$cate_id)->update($input);
            if($up){
                return redirect('admin/category');
            }else{
                return back()->with('msg','请重新修改!');
            }
        }else{
            return back()->withErrors($validator);
        }

    }

    /**
     * get  admin/category/{category}.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'get  admin/category/{category}';
    }

    /**
     * delete  admin/category/{category}.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cate_id)
    {
        $re = Category::where('cate_id',$cate_id)->delete();
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
        if($re){
            $data = [
                'status'=>1,
                'msg'=>'分类删除成功!'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'分类删除失败!'
            ];
        }
        return $data;
    }
}
